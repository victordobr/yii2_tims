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
    public $filter_created_at_from;
    public $filter_created_at_to;

    public $filter_group_by;

    public $status_1020;
    public $status_1040;
    public $status_2010;
    public $status_2020;
    public $status_2030;
    public $status_3020;
    public $status_3030;
    public $status_4010;
    public $status_4040;
    public $status_5030;
    public $status_5040;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $statuses_ids = array_keys(Status::listStatusesReport());
        foreach ($statuses_ids as $id) {
            $statuses[] = 'status_' . $id;
        }
        return [
            [['filter_created_at_from', 'filter_created_at_to', 'count'], 'integer'],
            [$statuses, 'integer'],
            [['status'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $labels['created'] = Yii::t('app', 'Date');
        $labels['filter_created_at_from'] = Yii::t('app', 'From');
        $labels['filter_created_at_to'] = Yii::t('app', 'To');
        $labels['filter_group_by'] = Yii::t('app', 'Group by');

        foreach (Status::listStatusesReport() as $id => $label) {
            $labels['status_' . $id] = $label;
        }
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

    public function getGroupAttribute()
    {
        switch ($this->filter_group_by) {
            case 'violations-by-date':
                return 'created_at';
            case 'violations-by-school-bus':
                return 'bus_number';
        }
    }

    public function getQueryByGroup()
    {
        $statuses_ids = array_keys(Status::listStatusesReport());

        $group_attribute = $this->getGroupAttribute();

        $select = [$group_attribute => 'record.created_at'];
        foreach ($statuses_ids as $id) {
            $select['status_' . $id] = 'sum(record.status_id=' . $id . ')';
        }

        switch ($this->filter_group_by) {
            case 'violations-by-date':
                return static::find()
                    ->select($select)
                    ->from(['record' => self::tableName()])
                    ->groupBy(['DAY(FROM_UNIXTIME(record.created_at, "%Y-%m-%d"))']);
            case 'violations-by-school-bus':
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