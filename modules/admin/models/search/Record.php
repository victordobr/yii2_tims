<?php

namespace app\modules\admin\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Record as RecordModel;

/**
 * Record represents the model behind the search form about `app\models\Record`.
 */
class Record extends RecordModel
{
    public $statusName;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'state_id', 'status_id'], 'integer'],
            [['statusName'], 'safe'],
            [['license'], 'string', 'max' => 250],
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
        $query = RecordModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $query->joinWith(['caseStatus']);

        $dataProvider->setSort([
            'attributes' => [
                'id',
                'infraction_date',
                'state_id',
                'license',
                'status_id' => [
                    'asc' => ['CaseStatus.name' => SORT_ASC],
                    'desc' => ['CaseStatus.name' => SORT_DESC],
                    'label' => 'Status'
                ],
                'created_at',
            ]
        ]);
        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'Record.id' => $this->id,
            'infraction_date' => $this->infraction_date,
            'state_id' => $this->state_id,
            'license' => $this->license,
            'status_id' => $this->status_id,
        ]);

        // filter by country name
        $query->joinWith(['caseStatus' => function ($q) {
            $q->where('CaseStatus.name LIKE "%' . $this->statusName . '%"');
        }]);

        return $dataProvider;
    }
}
