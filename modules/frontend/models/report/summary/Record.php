<?php
namespace app\modules\frontend\models\report\summary;

use app\enums\ReportType;
use app\modules\admin\Module;
use kartik\helpers\Html;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\db\QueryInterface;
use app\enums\CaseStatus as Status;
use yii\helpers\ArrayHelper;

class Record extends \app\modules\frontend\models\base\report\Record
{
    const DEFAULT_FILTER_GROUP_ID = 1;
    public $filter_group_id;

    public $count;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['count'], 'integer'],
            [['filter_group_id'], 'integer']
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
        \app\base\Module::pa($query,1);
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

    public function getGroupAttribute()
    {
        switch ($this->filter_group_id) {
            case 'violations-by-date':
                return 'created_at';
            case 'violations-by-school-bus':
                return 'bus_number';
        }
    }

    public function listAttributes($group_id = self::DEFAULT_FILTER_GROUP_ID)
    {
        $list_attributes = [
            1 => 'created_at',
            2 => 'bus_number',
        ];
        return $list_attributes;
    }

    public function getQueryByGroup()
    {
        $statuses_ids = array_keys(Status::listStatusesReport());

        $group_attribute = $this->listAttributes($this->filter_group_id);

        $select = [$group_attribute => 'record.created_at'];
        foreach ($statuses_ids as $id) {
            $select['status_' . $id] = 'sum(record.status_id=' . $id . ')';
        }

        switch ($this->filter_group_id) {
            case 1:
                return static::find()
                    ->select($select)
                    ->from(['record' => self::tableName()])
                    ->groupBy(['DAY(FROM_UNIXTIME(record.created_at, "%Y-%m-%d"))']);
            case 2:
                array_unshift($select, [$group_attribute => 'record.' . $group_attribute]);
                return static::find()
                    ->select($select)
                    ->from(['record' => self::tableName()])
                    ->groupBy(['record.' . $group_attribute]);
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