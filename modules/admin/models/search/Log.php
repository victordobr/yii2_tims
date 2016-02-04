<?php

namespace app\modules\admin\models\search;

use Yii;
use yii\base\Model;
use yii\data\ArrayDataProvider;
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
            [['id', 'email', 'ip_address', 'category', 'date'], 'safe'],
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
//        $resultData = LogModel::find()->all();

        $model = new LogModel;
//        $this->load($params);
//        if ($this->category || $this->ip_address || $this->email) {
////            var_dump($this->attributes);die();
//            $resultData = $model::find()->query([
//                "wildcard" => [
////
//                    "email" => [
//                        "value" => $this->email . '*'
//                    ],
//                ],
//
////                "filtered" => [
////                    "query" => [
////                        "bool" => [
////                            "should" => [
////                                [ "match" => [ "category" => $this->category ]],
////                                [ "match_phrase" => [ "email" => $this->email ]],
////                                [ "match_phrase" => [ "ip_address" => $this->ip_address ]],
////                            ],
////                        ],
////                    ],
////                ],
////                "more_like_this" => [
////                    "fields" => ["email"],
////                    "like" => $this->email,
//////                    "*.email" => [
//////                        "like_text" => $this->email,
//////                        "min_term_freq" => 1,
//////                        "max_query_terms" => 12,
//////                    ],
////                ],
//
//            ]);
//
//        }
//        else {
//
//        }
        $resultData = $model::find();
//        var_dump($resultData);die();
        $totalCount = $resultData->search()['hits']['total'];
//        var_dump($totalCount);die();


        $page = Yii::$app->request->getQueryParam('page');
        $perPage = Yii::$app->request->getQueryParam('per-page');
        if (!$page)
            $page = 1;
        if (!$perPage)
            $perPage = 10;
        $offset = ($page - 1) * $perPage;

        $resultData = $resultData->limit($perPage);
        $resultData = $resultData->offset($offset);

        $resultData = $resultData->all();
//        var_dump($resultData);die();
//        var_dump($totalCount);die();
        $dataProvider = new ArrayDataProvider([
//            'key'=>'id',
            'allModels' => $resultData,
//            'models' => $resultData,
//            'sort' => [
//                'attributes' => [
//                    'id' => [
//                        'label' => 'ID',
//                        'default' => SORT_DESC,
//                    ],
//                    'email',
//                    'ip_address',
//                    'category',
//                    'date',
//                ],
//            ],
            'pagination' => [
                'pageSize' => $perPage,
                'offset' => $offset,
            ],
            'totalCount' => $totalCount,
        ]);
//        var_dump($dataProvider);die();
//        $dataProvider->setSort([
//            'attributes' => [
//                'id' => [
//                    'asc' => ['id' => SORT_ASC],
//                    'desc' => ['id' => SORT_DESC],
//                    'label' => 'ID',
//                    'default' => SORT_DESC,
//                ],
//                'email',
//                'ip_address',
//                'category',
//                'date',
//            ]
//        ]);
//        var_dump($id);die(1);
//        $this->load($params);
//
//        if (!$this->validate()) {
//            return $dataProvider;
//        }

        return $dataProvider;
    }
}
