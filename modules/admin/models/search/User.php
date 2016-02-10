<?php

namespace app\modules\admin\models\search;

use \Yii;
use \yii\base\Model;
use \yii\data\ActiveDataProvider;
use \yii\helpers\ArrayHelper;
use \app\models\traits\ColumnFilter;

/**
 * User represents the model behind the search form about `app\models\User`.
 * @package app\modules\admin\models\search
 */
class User extends \app\models\base\User
{
    const SQL_SELECT_FULL_NAME = "CONCAT(user.first_name,' ', user.last_name)";
    const SQL_SELECT_ROLE = "authAssignment.item_name";

    use ColumnFilter {
        getSuggestions as traitGetSuggestions;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'logins_count', 'is_active'], 'integer'],
            [['email', 'password', 'first_name', 'last_name', 'phone', 'created_at', 'last_login_at', 'fullName', 'role'], 'safe'],
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
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = static::find()
            ->select([
                'id' => 'user.id',
                'fullName' => self::SQL_SELECT_FULL_NAME,
                'role' => self::SQL_SELECT_ROLE,
                'phone' => 'user.phone',
                'email' => 'user.email',
                'logins_count' => 'user.logins_count',
                'created_at' => 'user.created_at',
                'last_login_at' => 'user.last_login_at',
                'is_active' => 'user.is_active',
            ])
            ->from(['user' => static::tableName()])
            ->joinWith([
                'authAssignment' => function ($query) {
                    $query->from('AuthAssignment authAssignment');
                },
            ]);
            ;

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->getSort()->attributes['fullName'] = [
            'asc' => ['fullName' => SORT_ASC],
            'desc' => ['fullName' => SORT_DESC],
        ];

        $dataProvider->getSort()->attributes['role'] = [
            'asc' => ['role' => SORT_ASC],
            'desc' => ['role' => SORT_DESC],
        ];


        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'user.id' => $this->id,
            'user.logins_count' => $this->logins_count,
            'user.is_active' => $this->is_active,
        ]);
        $query->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'user.password', $this->password])
            ->andFilterWhere(['like', self::SQL_SELECT_FULL_NAME, $this->fullName])
            ->andFilterWhere(['like', self::SQL_SELECT_ROLE, $this->role])
            ->andFilterWhere(['like', 'user.phone', $this->phone])
            ;

        if (!empty($this->created_at)) {
            $range = explode(' - ', $this->created_at);

            if (!empty($range[0]) && !empty($range[1])) {
                $query->andWhere('user.created_at BETWEEN :prt1 AND :prt2', [
                    ':prt1' => strtotime($range[0]),
                    ':prt2' => strtotime($range[1]),
                ]);
            }
        }

        if (!empty($this->last_login_at)) {
            $range = explode(' - ', $this->last_login_at);

            if (!empty($range[0]) && !empty($range[1])) {
                $query->andWhere('user.last_login_at BETWEEN :prt3 AND :prt4', [
                    ':prt3' => strtotime($range[0]),
                    ':prt4' => strtotime($range[1]),
                ]);
            }
        }

        return $dataProvider;
    }

    /**
     * Overriding ColumnFilter method to create custom suggestions query
     * @param string $field field name
     * @param string $value field value
     * @param int $limit records count
     * @param int $user_id Id of a user
     * @return mixed list of suggestions
     */
    public function getSuggestions($field, $value, $limit, $user_id)
    {
        $callback = null;
        if ($field == 'fullName') {
            $callback = function ($query, $field, $value, $limit) {

                /** @var \yii\db\Query $query */
                $query->select([
                    'value' => "DISTINCT(CONCAT(`r`.`first_name`, ' ' ,`r`.`last_name`))",
                ])
                    ->from(['r' => 'User'])
                    ->having("value LIKE :value", ['value' => "%{$value}%"])
                    ->limit($limit);

                return $query;
            };
        }

        return $this->traitGetSuggestions($field, $value, $limit, $user_id, $callback);
    }
}
