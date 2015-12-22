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
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'case_id', 'user_id', 'state_id', 'created_at'], 'integer'],
//            [['video_lpr', 'video_overview_camera', 'image_lpr', 'image_overview_camera', 'license'], 'safe'],
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
        $query = EvidenceModel::find()->with('user');

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
            'case_id' => $this->case_id,
            'user_id' => $this->user_id,
            'state_id' => $this->state_id,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'video_lpr', $this->video_lpr])
            ->andFilterWhere(['like', 'video_overview_camera', $this->video_overview_camera])
            ->andFilterWhere(['like', 'image_lpr', $this->image_lpr])
            ->andFilterWhere(['like', 'image_overview_camera', $this->image_overview_camera])
            ->andFilterWhere(['like', 'license', $this->license]);

        return $dataProvider;
    }
}
