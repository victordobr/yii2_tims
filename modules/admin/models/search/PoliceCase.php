<?php

namespace app\modules\admin\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Case represents the model behind the search form about `app\models\PoliceCase`.
 */
class PoliceCase extends \app\models\PoliceCase
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status_id', 'created_at', 'open_date', 'officer_date', 'mailed_date', 'officer_id'], 'integer'],
            [['officer_pin'], 'safe'],
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
        $query = PoliceCase::find();

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
            'status_id' => $this->status_id,
            'created_at' => $this->created_at,
            'open_date' => $this->open_date,
            'officer_date' => $this->officer_date,
            'mailed_date' => $this->mailed_date,
            'officer_id' => $this->officer_id,
        ]);

        $query->andFilterWhere(['like', 'officer_pin', $this->officer_pin]);

        return $dataProvider;
    }
}