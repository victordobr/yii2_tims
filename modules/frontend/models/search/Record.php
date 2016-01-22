<?php

namespace app\modules\frontend\models\search;

use Yii;
use yii\helpers\ArrayHelper;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Record as RecordModel;

/**
 * Record represents the model behind the search form about `app\models\Record`.
 */
class Record extends RecordModel
{
    public $fullName;

    public $elapsedTime;

    const SQL_SELECT_FULL_NAME = "CONCAT(user.first_name,' ', user.last_name)";

    const SQL_SELECT_ELAPSED_TIME = "datediff(NOW(), FROM_UNIXTIME(record.infraction_date))";

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'infraction_date', 'open_date', 'state_id', 'user_id', 'ticket_fee', 'ticket_payment_expire_date', 'status_id'], 'integer'],
            [['lat', 'lng', 'license', 'comments', 'user_plea_request', 'fullName', 'elapsedTime'], 'safe'],
            [['created_at'], 'date'],
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
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'fullName' => Yii::t('app', 'Full Name'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => 'app\behaviors\IntegerStamp',
                'attributes' => ['infraction_date', 'open_date', 'created_at'],
            ],
        ];
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
        $query = $this->find()
            ->select([
                'id' => 'record.id',
                'license' => 'record.license',
                'lat' => 'record.lat',
                'lng' => 'record.lng',
                'state_id' => 'record.state_id',
                'infraction_date' => 'record.infraction_date',
                'created_at' => 'record.created_at',

                'elapsedTime' => self::SQL_SELECT_ELAPSED_TIME,
                'fullName' => self::SQL_SELECT_FULL_NAME,
            ])
            ->from(['record' => static::tableName()])
            ->joinWith([
                'user' => function ($query) {
                    $query->from('User user');
                },
            ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->getSort()->attributes['fullName'] = [
            'asc' => ['fullName' => SORT_ASC],
            'desc' => ['fullName' => SORT_DESC],
        ];

        $dataProvider->getSort()->attributes['created_at'] = [
            'asc' => ['record.created_at' => SORT_ASC],
            'desc' => ['record.created_at' => SORT_DESC],
        ];

        $dataProvider->getSort()->attributes['elapsedTime'] = [
            'asc' => ['elapsedTime' => SORT_ASC],
            'desc' => ['elapsedTime' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'state_id' => $this->state_id,
            'infraction_date' => $this->infraction_date,
            'record.created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'license', $this->license])
            ->andFilterWhere(['like', 'lat', $this->lat])
            ->andFilterWhere(['like', 'lng', $this->lng]);

        $query->andFilterWhere(['like', self::SQL_SELECT_FULL_NAME, $this->fullName]);
        $query->andFilterWhere(['like', self::SQL_SELECT_ELAPSED_TIME, $this->elapsedTime]);

        return $dataProvider;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
//    public function search($params)
//    {
//        $query = $this->find()
//            ->select([
//                'elapsedTime' => self::SQL_SELECT_ELAPSED_TIME,
//                'fullName' => self::SQL_SELECT_FULL_NAME,
//            ])
//            ->from(['record' => static::tableName()])
//            ->joinWith([
//                'user' => function ($query) {
//                    $query->from('User user');
//                },
//            ]);
//
//        $dataProvider = new ActiveDataProvider([
//            'query' => $query,
//        ]);
//
//        $dataProvider->getSort()->attributes['fullName'] = [
//            'asc' => ['fullName' => SORT_ASC],
//            'desc' => ['fullName' => SORT_DESC],
//        ];
//
//        $dataProvider->getSort()->attributes['created_at'] = [
//            'asc' => ['evidence.created_at' => SORT_ASC],
//            'desc' => ['evidence.created_at' => SORT_DESC],
//        ];
//
//        $dataProvider->getSort()->attributes['elapsedTime'] = [
//            'asc' => ['elapsedTime' => SORT_ASC],
//            'desc' => ['elapsedTime' => SORT_DESC],
//        ];
//
//        $this->load($params);
//
//        if (!$this->validate()) {
//            // uncomment the following line if you do not want to return any records when validation fails
//            // $query->where('0=1');
//            return $dataProvider;
//        }
//
//        $query->andFilterWhere([
//            'id' => $this->id,
//            'case_id' => $this->case_id,
//            'user_id' => $this->user_id,
//            'state_id' => $this->state_id,
//            'infraction_date' => $this->infraction_date,
//            'evidence.created_at' => $this->created_at,
//        ]);
//
//        $query->andFilterWhere(['like', 'license', $this->license])
//            ->andFilterWhere(['like', 'lat', $this->lat])
//            ->andFilterWhere(['like', 'lng', $this->lng]);
//
//        $query->andFilterWhere(['like', self::SQL_SELECT_FULL_NAME, $this->fullName]);
//        $query->andFilterWhere(['like', self::SQL_SELECT_ELAPSED_TIME, $this->elapsedTime]);
//
//        return $dataProvider;
//    }
}
