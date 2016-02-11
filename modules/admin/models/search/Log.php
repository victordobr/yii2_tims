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
        if ($this->email || $this->ip_address || $this->event_name || $this->description || $this->created_at) {
            $query = [];
            foreach ($this->attributes as $field => $value) {
                switch ($field) {
                    case 'email':
                    case 'ip_address':
                    case 'description':
                        if (!empty($value)) {
                            $query['filtered']['query']['bool']['must'][] = [
                                "wildcard" => [
                                    $field => [
                                        "value" => '*' . $value . '*'
                                    ],
                                ]
                            ];
                        }
                        break;
                    case 'event_name':
                        if (!empty($value)) {
                            $query['filtered']['query']['bool']['must'][] = [
                                "term" => [
                                    $field => [
                                        "value" => $value,
                                    ]
                                ],
                            ];
                        }
                        break;
                    case 'created_at':
                        $range = explode(' - ', $this->created_at);
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
                        break;
                    default:
                        break;
                }

            }
            $resultData = $model::find()->query($query);
        }
        else {
            $resultData = $model::find();
        }

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