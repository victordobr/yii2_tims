<?php

namespace app\modules\frontend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use \yii\helpers\ArrayHelper;
use app\models\PoliceCase as PoliceCaseModel;

/**
 * Evidence represents the model behind the search form about `app\models\Evidence`.
 */
class PoliceCase extends PoliceCaseModel
{
    public $fullName;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status_id', 'created_at', 'open_date', 'officer_date', 'mailed_date', 'officer_id'], 'integer'],
            [['officer_pin'], 'string', 'max' => 250],
            [['fullName'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'fullName' => Yii::t('app', 'Full Name'),
        ]);
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
            ->select([
                'policeCase.*',
                'evidence.*',
                'user.*',
                "CONCAT(user.first_name,' ', user.last_name) AS fullName"
            ])
            ->from(['policeCase' => static::tableName()])
            ->joinWith([
                'evidence' => function ($query) {
                    $query->from('Evidence evidence');
                },
                'evidence.user' => function ($query) {
                    $query->from('User user');
                },
            ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->getSort()->attributes += [
            'evidence.created_at' => [
                'asc' => ['evidence.created_at' => SORT_ASC],
                'desc' => ['evidence.created_at' => SORT_DESC],
            ],
            'fullName' => [
                'asc' => ['fullName' => SORT_ASC],
                'desc' => ['fullName' => SORT_DESC],
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
            'officer_date' => $this->officer_date,
            'mailed_date' => $this->mailed_date,
            'officer_pin' => $this->officer_pin,
            'officer_id' => $this->officer_id,
        ]);

        $query->andFilterWhere(['like', "CONCAT(user.first_name,' ', user.last_name)", $this->fullName]);

        return $dataProvider;
    }
}
