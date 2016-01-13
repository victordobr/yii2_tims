<?php

namespace app\modules\admin\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Owner as OwnerModel;

/**
 * Owner represents the model behind the search form about `app\models\Owner`.
 */
class Owner extends OwnerModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'state_id', 'vehicle_id', 'vehicle_year', 'vehicle_color_id', 'created_at'], 'integer'],
            [['first_name', 'middle_name', 'last_name', 'address_1', 'address_2', 'city', 'license', 'zip_code', 'email', 'phone'], 'safe'],
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
        $query = OwnerModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'state_id' => $this->state_id,
            'vehicle_id' => $this->vehicle_id,
            'vehicle_year' => $this->vehicle_year,
            'vehicle_color_id' => $this->vehicle_color_id,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'full_name', $this->first_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'address_1', $this->address_1])
            ->andFilterWhere(['like', 'address_2', $this->address_2])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'license', $this->license])
            ->andFilterWhere(['like', 'zip_code', $this->zip_code])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'phone', $this->phone]);

        return $dataProvider;
    }
}
