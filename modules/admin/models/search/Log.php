<?php

namespace app\modules\admin\models\search;

use Yii;
use yii\base\Model;
use app\modules\admin\components\base\ArrayDataProvider;
use app\models\Log as LogModel;

/**
 * Log represents the model behind the search form about `app\models\Log`.
 */
class Log extends LogModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'email', 'ip_address', 'event_name', 'description', 'created_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function mergeWildCard(&$query, $field, $value)
    {
        $query['filtered']['query']['bool']['must'][] = [
            "wildcard" => [
                $field => [
                    "value" => '*' . $value . '*'
                ],
            ]
        ];
    }

    public function mergeTerm(&$query, $field, $value)
    {
        $query['filtered']['query']['bool']['must'][] = [
            "term" => [
                $field => [
                    "value" => $value,
                ]
            ],
        ];
    }

    public function mergeRange(&$query, $field, $value)
    {
        $range = explode(' - ', $value);
        if (!empty($range[0]) && !empty($range[1])) {
            $query['filtered']['filter'][] = [
                "range" => [
                    $field => [
                        "gte" => (int)Yii::$app->formatter->asTimestamp($range[0]),
                        "lte" => (int)Yii::$app->formatter->asTimestamp($range[1]) + 86399,
                    ]
                ],
            ];
        }
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $model = new LogModel;
        $this->load($params);
        $query = [];

        if(!empty($this->email)) {
            $this->mergeWildCard($query, 'email', $this->email);
        }

        if(!empty($this->ip_address)) {
            $this->mergeWildCard($query, 'ip_address', $this->ip_address);
        }

        if(!empty($this->description)) {
            $this->mergeWildCard($query, 'description', $this->description);
        }

        if(!empty($this->event_name)) {
            $this->mergeTerm($query, 'event_name', $this->event_name);
        }

        if(!empty($this->created_at)) {
            $this->mergeRange($query, 'created_at', $this->created_at);
        }

        $resultData = $model::find()->query($query);

        $sort = Yii::$app->request->getQueryParam('sort');
        if (!empty($sort)) {
            if (substr($sort, 0, 1) == "-") {
                $orderBy = [substr($sort, 1) => SORT_DESC];
            }
            else {
                $orderBy = [$sort => SORT_ASC];
            }
            $resultData = $resultData->orderBy($orderBy);
        }
        else {
            $resultData = $resultData->orderBy(['created_at' => SORT_DESC]);
        }

        $totalCount = $resultData->search()['hits']['total'];
        $perPage = 10;
        $allPages = ceil($totalCount / $perPage);

        $page = Yii::$app->request->getQueryParam('page');
        if (!$page || $page > $allPages) {
            $page = 1;
        }
        $offset = ($page - 1) * $perPage;

        $resultData = $resultData->limit($perPage);
        $resultData = $resultData->offset($offset);

        $resultData = $resultData->all();

        $dataProvider = new ArrayDataProvider([
            'allModels' => $resultData,
            'sort' => [
                'attributes' => [
                    'email',
                    'ip_address',
                    'event_name',
                    'description',
                    'created_at',
                ],
            ],
            'pagination' => [
                'pageSize' => $perPage,
            ],
            'totalCount' => $totalCount,
        ]);

        return $dataProvider;
    }
}