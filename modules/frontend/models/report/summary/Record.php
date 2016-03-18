<?php
namespace app\modules\frontend\models\report\summary;

use app\base\Module;
use app\enums\report\ReportGroup;
use app\models\base\User;
use app\models\StatusHistory;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\db\QueryInterface;
use app\enums\report\ReportStatus as Status;
use yii\helpers\ArrayHelper;
use app\components\Report as ReportComponent;

class Record extends \app\modules\frontend\models\base\report\Record
{
    public $filter_group_id;
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
        $select = ReportComponent::createQuerySelect($this->filter_group_id);

        switch (true) {
            case $this->filter_group_id == ReportGroup::GROUP_DAY:

                return static::find()
                    ->select($select)
                    ->from(['record' => self::tableName()])
                    ->groupBy(['DAY(FROM_UNIXTIME(record.created_at, "%Y-%m-%d"))']);
            case $this->filter_group_id == ReportGroup::GROUP_BUS_NUMBER:

                return static::find()
                    ->select($select)
                    ->from(['record' => self::tableName()])
                    ->groupBy(['record.bus_number']);
            case in_array($this->filter_group_id, [ReportGroup::GROUP_VIDEO_ANALYST, ReportGroup::GROUP_POLICE_OFFICER, ReportGroup::GROUP_PRINT_OPERATOR]):

                $userQuery = (new Query())
                    ->select('user_id')
                    ->from('AuthAssignment')
                    ->where(['item_name' => ReportComponent::getGroupAttribute($this->filter_group_id)]);

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