<?php
namespace app\modules\frontend\models\report\search;

use app\modules\admin\Module;
use kartik\helpers\Html;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\QueryInterface;
use app\enums\CaseStatus as Status;
use yii\helpers\ArrayHelper;

class Record extends \app\models\base\Record
{
    public $filter_created_at_from;
    public $filter_created_at_to;
    public $filter_group_by;
    public $filter_bus_number;

    public $count;
    public $status;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['filter_created_at_from', 'filter_created_at_to', 'count'], 'integer'],
            [['status', 'filter_bus_number'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'status' => Yii::t('app', 'Status'),
            'count' => Yii::t('app', 'Count'),
        ];
    }

    public function search($params)
    {
        $this->setAttributes($params);

        $query = static::find()
            ->select([
                'CaseStatus.id',
                'status' => 'CaseStatus.name',
                'count' => 'count(record.id)'
            ])
            ->from(['record' => self::tableName()])
            ->leftJoin('CaseStatus', 'record.status_id=CaseStatus.id')
            ->groupBy(['record.status_id']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                    'pageSize' => 20,
            ],
            'sort' => [
                'attributes' => [
                    'status',
                    'count' ,
                ],
                'defaultOrder' => ['count' => SORT_DESC],
            ],

        ]);

        if (!empty($this->filter_created_at_from) || !empty($this->filter_created_at_to)) {
            $this->filterByCreatedAtRange($query, $this->filter_created_at_from, $this->filter_created_at_to);
        }

        if (!empty($this->filter_bus_number)) {
            $this->filterByBusNumber($query, $this->filter_bus_number);
        }

        return $dataProvider;
    }

    public function getViewUrl()
    {
        $url = [
            'report-view',
            'id' => $this->id,
        ];
        return $url;
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