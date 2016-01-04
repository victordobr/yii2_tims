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

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'case_id', 'user_id', 'state_id', 'created_at'], 'integer'],
            [['fullName'], 'safe'],
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
                'evidence.*',
                'case.*',
                'user.*',
                "CONCAT(user.first_name,' ', user.last_name) AS fullName"
            ])
            ->from(['evidence' => static::tableName()])
            ->joinWith([
                'case' => function ($query) {
                    $query->from('PoliceCase case');
                },
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

        $dataProvider->getSort()->attributes['case.infraction_date'] = [
            'asc' => ['case.infraction_date' => SORT_ASC],
            'desc' => ['case.infraction_date' => SORT_DESC],
        ];

        $dataProvider->getSort()->attributes['created_at'] = [
            'asc' => ['evidence.created_at' => SORT_ASC],
            'desc' => ['evidence.created_at' => SORT_DESC],
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
            'license' => $this->license,
            'state_id' => $this->state_id,
            'created_at' => $this->created_at,
//            'mailed_date' => $this->mailed_date,
//            'officer_pin' => $this->officer_pin,
//            'officer_id' => $this->officer_id,
        ]);

        $query->andFilterWhere(['like', "CONCAT(user.first_name,' ', user.last_name)", $this->fullName]);

        return $dataProvider;
    }
}
