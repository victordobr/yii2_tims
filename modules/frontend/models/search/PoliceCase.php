<?php

namespace app\modules\frontend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PoliceCase as PoliceCaseModel;

/**
 * Evidence represents the model behind the search form about `app\models\Evidence`.
 */
class PoliceCase extends PoliceCaseModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status_id', 'created_at', 'open_date', 'infraction_date', 'officer_date', 'mailed_date', 'officer_id'], 'integer'],
            [['officer_pin'], 'string', 'max' => 250]
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
        $query = PoliceCaseModel::find()
            ->joinWith(['evidence' => function ($query) {
                $query->from('Evidence evidence');
            }])
            ;

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->getSort()->attributes += [
            'evidence.created_at' => [
                'asc' => ['evidence.created_at' => SORT_ASC],
                'desc' => ['evidence.created_at' => SORT_DESC],
            ],
        ];

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
            'infraction_date' => $this->infraction_date,
            'officer_date' => $this->officer_date,
            'mailed_date' => $this->mailed_date,
            'officer_pin' => $this->officer_pin,
            'officer_id' => $this->officer_id,
        ]);

//        $query->andFilterWhere(['like', 'video_lpr', $this->video_lpr])
//            ->andFilterWhere(['like', 'video_overview_camera', $this->video_overview_camera])
//            ->andFilterWhere(['like', 'image_lpr', $this->image_lpr])
//            ->andFilterWhere(['like', 'image_overview_camera', $this->image_overview_camera])
//            ->andFilterWhere(['like', 'license', $this->license]);

        return $dataProvider;
    }
}
