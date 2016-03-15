<?php
namespace app\modules\frontend\models\report\summary;

use app\enums\ReportGroup;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\QueryInterface;
use app\enums\CaseStatus as Status;
use yii\helpers\ArrayHelper;

class Record extends \app\modules\frontend\models\base\report\Record
{
    const DEFAULT_FILTER_GROUP_ID = 1;
    public $filter_group_id = self::DEFAULT_FILTER_GROUP_ID;
    public $filter_created_at_from;
    public $filter_created_at_to;

    public $count;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['count'], 'integer'],
            [['filter_group_id'], 'integer'],
            [['filter_created_at_from', 'filter_created_at_to'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {

        $labels['filter_group_id'] = Yii::t('app', 'Group by');
        $labels['count'] = Yii::t('app', 'Count');
        return $labels;
    }

    public function search($params)
    {
        $this->setAttributes($params);

        $query = $this->getQueryByGroup();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
//                    'pageSize' => 20,
            ],
        ]);

        if (!empty($this->filter_created_at_from) || !empty($this->filter_created_at_to)) {
            $this->filterByCreatedAtRange($query, $this->filter_created_at_from, $this->filter_created_at_to);
        }

        return $dataProvider;
    }

    public function getQueryByGroup()
    {
        $statuses_ids = array_keys(Status::listStatusesReport());

        $group_attribute = ReportGroup::getGroupAttribute($this->filter_group_id);

        foreach ($statuses_ids as $id) {
            $status_arr['status_' . $id] = 'sum(record.status_id=' . $id . ')';
        }

        switch ($this->filter_group_id) {
            case 1:
                $select = [$group_attribute => 'record.' . $group_attribute] + $status_arr;
                return static::find()
                    ->select($select)
                    ->from(['record' => self::tableName()])
                    ->groupBy(['DAY(FROM_UNIXTIME(record.created_at, "%Y-%m-%d"))']);
            case 2:
                $select = [$group_attribute => 'record.' . $group_attribute] + $status_arr;
//                \app\base\Module::pa($group_attribute,1);
                return static::find()
                    ->select($select)
                    ->from(['record' => self::tableName()])
                    ->groupBy(['record.' . $group_attribute]);
            case 3:
                $select = $status_arr;

                $query = static::find()
                    ->select($select)
                    ->groupBy(['user.id']);


                \app\base\Module::pa($command->sql,1);
                return static::find()
                    ->select($select)
                    ->from(['record' => $subQuery], ['user' => 'User'])
                    ->leftJoin(['history' => 'StatusHistory'], ['history.id' => 'record.id'])
                    ->leftJoin(['user' => 'User'], ['user.id' => 'history.user_id', 'user.is_active' => 1])
//                    ->where(['record.id' => $subQuery])
                    ->groupBy(['user.id']);


//                $subQuery = (new Query())->select('history.id')
//                    ->from(['history' => 'StatusHistory'])
//                    ->where([
//                        'history.author_id' => (new Query())->select('user_id')
//                            ->from(['auth' => 'AuthAssignment'])
//                            ->leftJoin(['user' => 'User'], ['user.id' => 'auth.user_id', 'user.is_active' => 1])
//                            ->where(['item_name' => 'RootSuperuser']),
//                    ])
//                    ->andWhere(['history.status_code' => 1020])
//                    ->groupBy('history.author_id');
//                $command = $subQuery->createCommand();
//
//                $subQuery = (new Query())->select('id')
//                    ->from('StatusHistory')
//                    ->groupBy(['record_id']);
//                $sql = 'SELECT r.*
//                FROM StatusHistory AS sh
//                  INNER JOIN User AS u ON sh.author_id = u.id AND u.is_active = 1
//                  INNER JOIN AuthAssignment AS auth ON u.id = auth.user_id AND auth.item_name = \'RootSuperuser\'
//                  INNER JOIN Record AS r ON sh.record_id = r.id
//                WHERE sh.status_code = 1020
//                GROUP BY sh.author_id;';
        }

    }

    public function getBusNumberList() {
        $array = Record::find()
            ->select('r.bus_number')
            ->distinct()
            ->from(Record::tableName() . ' r')
            ->where(['!=', 'r.bus_number', ''])
            ->asArray()
            ->all();
        return $new_arr = ArrayHelper::getColumn($array, 'bus_number');
    }

    protected function filterByCreatedAtRange(QueryInterface &$query, $from, $to)
    {
        switch(true){
            case !empty($from) && !empty($to):
                $query->andFilterWhere(['between', 'record.created_at', strtotime($from), strtotime($to)]);
                break;
            case !empty($from):
                $query->andFilterWhere(['>=', 'record.created_at', strtotime($from)]);
                break;
            case !empty($to):
                $query->andFilterWhere(['<=', 'record.created_at', strtotime($to)]);
                break;
        }
    }

    protected function filterByBusNumber(QueryInterface &$query, $bus_number)
    {
        $query->andWhere(['record.bus_number' => $bus_number]);
    }

}