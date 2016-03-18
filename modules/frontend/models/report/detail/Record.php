<?php
namespace app\modules\frontend\models\report\detail;

use app\base\Module;
use app\enums\report\ReportGroup;
use app\models\base\User;
use app\models\StatusHistory;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yii\db\Query;
use yii\db\QueryInterface;
use app\enums\report\ReportStatus as Status;
use yii\helpers\ArrayHelper;
use app\components\Report as ReportComponent;

class Record extends \app\modules\frontend\models\base\report\Record
{
    const SQL_SELECT_AUTHOR = 'CONCAT_WS(" ", User.first_name, User.last_name)';

    public $filter_group_id;
    public $page_filter_id;

    public $filter_bus_number;
    public $filter_video_analyst;
    public $filter_police_officer;
    public $filter_print_operator;
    public $filter_author_id;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['count'], 'integer'],
            [['filter_group_id', 'filter_author_id'], 'integer'],
            [['filter_created_at_from', 'filter_created_at_to', 'author_id'], 'safe'],
            [['filter_bus_number'], 'string'],
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
        $select = ReportComponent::createQueryDetailSelect($this->page_filter_id);

        switch (true) {
            case $this->page_filter_id == ReportGroup::GROUP_BUS_NUMBER:

                return static::find()
                    ->select($select)
                    ->from(['record' => self::tableName()])
                    ->groupBy(['DAY(FROM_UNIXTIME(record.created_at, "%Y-%m-%d"))']);

            case in_array($this->page_filter_id, [ReportGroup::GROUP_VIDEO_ANALYST, ReportGroup::GROUP_POLICE_OFFICER, ReportGroup::GROUP_PRINT_OPERATOR]):

//                $userQuery = (new Query())
//                    ->select('user_id')
//                    ->from('AuthAssignment')
//                    ->where(['in', 'item_name', []]);

                $subQuery = (new Query())
                    ->from(StatusHistory::tableName())
//                    ->where(['in', 'author_id', $userQuery])
                    ->orderBy(['created_at' => SORT_DESC])
                    ->groupBy(['record_id']);

                $query = self::find()
                    ->select($select)
                    ->from(['record' => $subQuery])
                    ->groupBy(['DAY(FROM_UNIXTIME(record.created_at, "%Y-%m-%d"))']);
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

    public function getAuthorList()
    {
        $userQuery = (new Query())
            ->select('user_id')
            ->from('AuthAssignment')
            ->where(['item_name' => ReportComponent::getGroupAttribute($this->page_filter_id)]);

        $arr = (new Query())
            ->select(['author_id' => 'id', 'author_name' => self::SQL_SELECT_AUTHOR])
            ->from('User')
            ->where(['in', 'id', $userQuery])
            ->all();
        return ArrayHelper::getColumn($arr, 'author_id', 'author_name');
    }

    protected function filterByBusNumber(QueryInterface &$query, $bus_number)
    {
        $query->andWhere(['record.bus_number' => $bus_number]);
    }

    protected function filterByAuthorID(QueryInterface &$query, $author_id)
    {
        $query->andWhere(['record.author_id' => $author_id]);
    }


}