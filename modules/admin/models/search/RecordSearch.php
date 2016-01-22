<?php

namespace app\modules\admin\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Record;

/**
 * RecordSearch represents the model behind the search form about `app\models\Record`.
 */
class RecordSearch extends Record
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'infraction_date', 'open_date', 'state_id', 'user_id', 'ticket_fee', 'ticket_payment_expire_date', 'status_id', 'created_at'], 'integer'],
            [['lat', 'lng', 'license', 'comments', 'user_plea_request'], 'safe'],
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
        $query = Record::find();

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
            'infraction_date' => $this->infraction_date,
            'open_date' => $this->open_date,
            'state_id' => $this->state_id,
            'user_id' => $this->user_id,
            'ticket_fee' => $this->ticket_fee,
            'ticket_payment_expire_date' => $this->ticket_payment_expire_date,
            'status_id' => $this->status_id,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'lat', $this->lat])
            ->andFilterWhere(['like', 'lng', $this->lng])
            ->andFilterWhere(['like', 'license', $this->license])
            ->andFilterWhere(['like', 'comments', $this->comments])
            ->andFilterWhere(['like', 'user_plea_request', $this->user_plea_request]);

        return $dataProvider;
    }
}
