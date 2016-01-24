<?php

namespace app\modules\admin\models\search;

use app\enums\States;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Owner;

/**
 * Owner represents the model behind the search form about `app\models\Owner`.
 */
class OwnerSearch extends Owner
{
    public $fullName;
    public $stateName;
    public $vehicleName;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'state_id', 'vehicle_id'], 'integer'],
            [['first_name', 'last_name', 'city', 'license', 'zip_code', 'email', 'fullName', 'stateName', 'vehicleName'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [];
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
        $query = Owner::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'attributes' => [
                'id',
                'fullName' => [
                    'asc' => ['first_name' => SORT_ASC, 'last_name' => SORT_ASC],
                    'desc' => ['first_name' => SORT_DESC, 'last_name' => SORT_DESC],
                    'default' => SORT_ASC
                ],
                'license',
                'state_id',
                'city',
                'zip_code',
                'email',
                'vehicleName' => [
                    'asc' => ['Vehicle.make' => SORT_ASC, 'Vehicle.model' => SORT_ASC],
                    'desc' => ['Vehicle.make' => SORT_DESC, 'Vehicle.model' => SORT_DESC],
                    'default' => SORT_ASC
                ],
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            $query->joinWith(['vehicle']);
            return $dataProvider;
        }

        $query->andWhere('first_name LIKE "%' . $this->fullName . '%" ' .
            'OR last_name LIKE "%' . $this->fullName . '%"'
        );

        $query->andFilterWhere([
            'id' => $this->id,
            'state_id' => $this->state_id,
        ]);

        $query->andFilterWhere(['like', 'license', $this->license])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'zip_code', $this->zip_code])
            ->andFilterWhere(['like', 'email', $this->email]);

        $query->joinWith(['vehicle' => function ($query) {
            $query->where('Vehicle.make LIKE "%' . $this->vehicleName . '%"' .
                'OR Vehicle.model LIKE "%' . $this->vehicleName . '%"');
        }]);

        return $dataProvider;
    }
}
