<?php

namespace app\modules\frontend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Evidence as EvidenceModel;

/**
 * Evidence represents the model behind the search form about `app\models\Evidence`.
 */
class Evidence extends EvidenceModel
{
    public $fullName;

    public $elapsedTime;

    const SQL_SELECT_FULL_NAME = "CONCAT(user.first_name,' ', user.last_name)";

    const SQL_SELECT_ELAPSED_TIME = "datediff(NOW(), FROM_UNIXTIME(evidence.infraction_date))";

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'case_id', 'user_id', 'state_id', 'infraction_date', 'created_at'], 'integer'],
            [['license', 'lat', 'lng', 'fullName', 'elapsedTime'], 'safe'],
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
        $query = $this->find()
            ->select([
                'id' => 'evidence.id',
                'case_id' => 'evidence.case_id',
                'license' => 'evidence.license',
                'lat' => 'evidence.lat',
                'lng' => 'evidence.lng',
                'state_id' => 'evidence.state_id',
                'infraction_date' => 'evidence.infraction_date',
                'created_at' => 'evidence.created_at',

                'elapsedTime' => self::SQL_SELECT_ELAPSED_TIME,
                'fullName' => self::SQL_SELECT_FULL_NAME,
            ])
            ->from(['evidence' => static::tableName()])
            ->joinWith([
//                'case',
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
            'asc' => ['evidence.created_at' => SORT_ASC],
            'desc' => ['evidence.created_at' => SORT_DESC],
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
            'case_id' => $this->case_id,
            'user_id' => $this->user_id,
            'state_id' => $this->state_id,
            'infraction_date' => $this->infraction_date,
            'evidence.created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'license', $this->license])
            ->andFilterWhere(['like', 'lat', $this->lat])
            ->andFilterWhere(['like', 'lng', $this->lng]);

        $query->andFilterWhere(['like', self::SQL_SELECT_FULL_NAME, $this->fullName]);
        $query->andFilterWhere(['like', self::SQL_SELECT_ELAPSED_TIME, $this->elapsedTime]);

        return $dataProvider;
    }
}
