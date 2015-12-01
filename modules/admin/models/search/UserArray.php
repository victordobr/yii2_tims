<?php
namespace app\modules\admin\models\search;

use \Yii;
use \yii\data\Sort;
use \yii\data\Pagination;
use \yii\db\Query;

use \app\base\ArrayDataProvider;
use \yii\helpers\ArrayHelper;

/**
 * Search for admin model.
 * @inheritdoc
 * @package app\modules\admin\models\search
 */
class UserArray extends \app\models\User
{
    /** @var string $fullName owner name. */
    public $fullName;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'id',
                    'fullName',
                    'active',
                    'type',
                    'email',
                    'first_name',
                    'last_name',
                    'phone',
                    'notes',
                    'company_name',
                    'logins_count',
                    'created_at',
                    'last_login_at'
                ],
                'safe'
            ],
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
     * @param array $params for search.
     * @return ArrayDataProvider
     */
    public function search(array $params)
    {
        $this->sort = $this->getSortAttributes($params);
        $this->setQuery();

        if ($this->load($params) && $this->validate()) {
            $this->applyFilters();
        }

        $countQuery = clone $this->query;

        $pagination = new Pagination(['totalCount' => $countQuery->count(), 'defaultPageSize' => 10]);
        $this->query->limit($pagination->limit)->offset($pagination->offset);

        $this->query->each();
        $command = $this->query->createCommand();

        return new ArrayDataProvider([
            'allModels' => $command->queryAll(),
            'key' => 'id',
            'pagination' => $pagination,
            'sort' => $this->sort,
        ]);
    }

    /**
     * Set Query.
     */
    protected function setQuery()
    {
        $this->query = new Query();
        $this->query->select([
            'id' => 'user.id',
            'fullName' => 'CONCAT(`user`.`first_name`,\' \', `user`.`last_name`)',
            'active' => 'user.active',
            'type' => 'user.type',
            'email' => 'user.email',
            'first_name' => 'user.first_name',
            'last_name' => 'user.last_name',
            'phone' => 'user.phone',
            'notes' => 'user.notes',
            'company_name' => 'user.company_name',
            'logins_count' => 'user.logins_count',
            'created_at' => 'user.created_at',
            'last_login_at' => 'user.last_login_at',
        ])
            ->from(['user' => static::tableName()]);
//            ->leftJoin('User u', 'u.id = user.owner_id');

        if ($this->sort instanceof Sort) {
            $safe = array_flip($this->safeAttributes());
            foreach ($this->sort->getOrders() as $attribute => $order) {
                $temp = explode('.', $attribute);

                if (isset($temp[1])) {
                    $attribute = $temp[1];
                }

                if (isset($safe[$attribute])) {
                    $orderBy = 'ASC';
                    if ($order == 3) {
                        $orderBy = 'DESC';
                    }

                    $this->query->addOrderBy("{$temp[0]}.{$attribute} {$orderBy}");
                }
            }
        }
    }

    /**
     * Apply filters.
     */
    public function applyFilters()
    {
        $this->query
            ->andFilterWhere([
                'user.id'           => $this->id,
                'user.type'         => $this->type,
                'user.created_at'   => $this->created_at,
                'user.last_login_at'   => $this->last_login_at,
                'user.logins_count' => $this->logins_count,
                'user.is_active'       => $this->is_active,
            ])
            ->andFilterWhere(['like', 'user.email', $this->email])
            ->andFilterWhere(['like', 'user.password', $this->password])
            ->andFilterWhere(['like', 'user.first_name', $this->first_name])
            ->andFilterWhere(['like', 'user.last_name', $this->last_name])
            ->andFilterWhere(['like', 'user.phone', $this->phone])
            ->andFilterWhere(['like', 'user.notes', $this->notes])
            ->andFilterWhere(['like', 'user.company_name', $this->company_name]);

        if (!empty($this->fullName)) {
            $this->query->andWhere('CONCAT(`user`.`first_name`,\' \', `user`.`last_name`)=:erv2',
                ['erv2' => $this->fullName]);
        }
    }

    /**
     * @param array $params for search.
     * @return Sort
     */
    public function getSortAttributes(array $params)
    {
        $sort = new Sort();
        $sort->attributes = [
            'id' => [
                'asc' => ['user.id' => SORT_ASC],
                'desc' => ['user.id' => SORT_DESC],
            ],
            'fullName' => [
                'asc' => ['user.fullName' => SORT_ASC],
                'desc' => ['user.fullName' => SORT_DESC],
            ],
            'is_active' => [
                'asc' => ['user.is_active' => SORT_ASC],
                'desc' => ['user.is_active' => SORT_DESC],
            ],
            'type' => [
                'asc' => ['user.type' => SORT_ASC],
                'desc' => ['user.type' => SORT_DESC],
            ],
            'email' => [
                'asc' => ['user.email' => SORT_ASC],
                'desc' => ['user.email' => SORT_DESC],
            ],
            'first_name' => [
                'asc' => ['user.first_name' => SORT_ASC],
                'desc' => ['user.first_name' => SORT_DESC],
            ],
            'last_name' => [
                'asc' => ['user.last_name' => SORT_ASC],
                'desc' => ['user.last_name' => SORT_DESC],
            ],
            'phone' => [
                'asc' => ['user.phone' => SORT_ASC],
                'desc' => ['user.phone' => SORT_DESC],
            ],
            'notes' => [
                'asc' => ['user.notes' => SORT_ASC],
                'desc' => ['user.notes' => SORT_DESC],
            ],
            'company_name' => [
                'asc' => ['user.company_name' => SORT_ASC],
                'desc' => ['user.company_name' => SORT_DESC],
            ],
            'logins_count' => [
                'asc' => ['user.logins_count' => SORT_ASC],
                'desc' => ['user.logins_count' => SORT_DESC],
            ],
            'created_at' => [
                'asc' => ['user.created_at' => SORT_ASC],
                'desc' => ['user.created_at' => SORT_DESC],
            ],
            'last_login' => [
                'asc' => ['user.last_login' => SORT_ASC],
                'desc' => ['user.last_login' => SORT_DESC],
            ],
        ];
        $sort->params = $params;
        $sort->sortParam = 'id-sort';
        return $sort;
    }
}
