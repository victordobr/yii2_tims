<?php
namespace app\modules\frontend\models\report\search;

use kartik\helpers\Html;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\QueryInterface;

class Record extends \app\models\base\Record
{
    public $filter_created_at_from;
    public $filter_created_at_to;
    public $count;
    public $status;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['filter_created_at_from', 'filter_created_at_to', 'count'], 'integer'],
            [['status'], 'string'],
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
            'pagination' => false,
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

        return $dataProvider;
    }

    public function getDetailLink()
    {
        $date_from = strtotime(Yii::$app->request->getQueryParam('Record')['filter_created_at_from']);
        $date_to = strtotime(Yii::$app->request->getQueryParam('Record')['filter_created_at_to']);

        $query = [
            'report-details',
            'id' => $this->id,
            'created_from' => ($date_from == 0) ? NULL : $date_from,
            'created_to' => ($date_to == 0) ? NULL : $date_to,
        ];
        return Html::a($this->count, $query, ['class' => 'report-details-link']);
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