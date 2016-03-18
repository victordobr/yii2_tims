<?php

namespace app\modules\frontend\models\base\report;

use Yii;
use yii\data\ActiveDataProvider;
use app\enums\CaseStatus as Status;

class Record extends \app\models\Record
{
    public $filter_created_at_from;
    public $filter_created_at_to;

    public $count;

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
            [['count'], 'integer'],
            [['filter_group_id'], 'integer'],
            [['filter_created_at_from', 'filter_created_at_to', 'count'], 'integer'],
            [$statuses, 'integer'],
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
        $labels['filter_group_id'] = Yii::t('app', 'Group by');

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
                    'pageSize' => 5,
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

        $group_attribute = $this->getGroupAttribute();

        $select = [$group_attribute => 'record.bus_number'];
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



}