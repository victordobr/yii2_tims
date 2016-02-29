<?php

namespace app\modules\frontend\models\setting;

use Yii;
use yii\data\ActiveDataProvider;

class Setting extends \app\models\Setting
{

    public function search($params)
    {
        $query = $this->find();

        $dataProvider = new ActiveDataProvider( [
                'query' => $query,
            ]
        );

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(
            [
                'id' => $this->id,
                'active' => $this->active,
                'section' => $this->section,
            ]
        );

        $query->andFilterWhere(['like', 'key', $this->key])
            ->andFilterWhere(['like', 'value', $this->value]);

        return $dataProvider;
    }


}