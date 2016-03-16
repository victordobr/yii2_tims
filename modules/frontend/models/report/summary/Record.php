<?php
namespace app\modules\frontend\models\report\summary;

use app\enums\ReportGroup;
use app\models\base\User;
use app\models\StatusHistory;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\db\QueryInterface;
use app\enums\CaseStatus as Status;
use yii\helpers\ArrayHelper;

class Record extends \app\modules\frontend\models\base\report\Record
{
    const SQL_SELECT_AUTHOR = 'CONCAT_WS(", ", User.last_name, User.first_name)';
    const DEFAULT_FILTER_GROUP_ID = 1;

    public $filter_group_id = self::DEFAULT_FILTER_GROUP_ID;
    public $filter_created_at_from;
    public $filter_created_at_to;

    public $author_id;
    public $count;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['count'], 'integer'],
            [['filter_group_id'], 'integer'],
            [['filter_created_at_from', 'filter_created_at_to', 'author_id'], 'safe'],
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
                    'pageSize' => 20,
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

        switch (true) {
            case $this->filter_group_id == ReportGroup::GROUP_DAY:
                $select = [$group_attribute => 'record.' . $group_attribute] + $status_arr;
                return static::find()
                    ->select($select)
                    ->from(['record' => self::tableName()])
                    ->groupBy(['DAY(FROM_UNIXTIME(record.created_at, "%Y-%m-%d"))']);
            case $this->filter_group_id == ReportGroup::GROUP_BUS_NUMBER:
                $select = [$group_attribute => 'record.' . $group_attribute] + $status_arr;
                return static::find()
                    ->select($select)
                    ->from(['record' => self::tableName()])
                    ->groupBy(['record.' . $group_attribute]);
            case in_array($this->filter_group_id, [ReportGroup::GROUP_VIDEO_ANALYST, ReportGroup::GROUP_POLICE_OFFICER, ReportGroup::GROUP_PRINT_OPERATOR]):

                foreach ($statuses_ids as $id) {
                    $status_arr['status_' . $id] = 'sum(record.status_code=' . $id . ')';
                }
                $select = ['author_id' => 'record.author_id'] + ['author' => self::SQL_SELECT_AUTHOR] + $status_arr;

                $userQuery = (new Query())
                    ->select('user_id')
                    ->from('AuthAssignment')
                    ->where(['item_name' => $group_attribute]);

                $subQuery = (new Query())
                    ->from(StatusHistory::tableName())
                    ->where(['in', 'author_id', $userQuery])
                    ->orderBy(['created_at' => SORT_DESC])
                    ->groupBy(['record_id']);

                $query = self::find()
                    ->select($select)
                    ->from(['record' => $subQuery])
                    ->innerJoin('User', 'User.id=record.author_id')
                    ->groupBy(['record.author_id']);
                return $query;
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

    protected function filterByBusNumber(QueryInterface &$query, $bus_number)
    {
        $query->andWhere(['record.bus_number' => $bus_number]);
    }

}