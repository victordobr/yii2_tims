<?php
namespace app\modules\frontend\models\base;

use app\components\Settings;
use app\enums\Role;
use Yii;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Record represents the model behind the search form about `app\models\Record`.
 */
class Record extends \app\models\Record
{
    private $status;

    public $author;
    public $elapsedTime;

    const SQL_SELECT_AUTHOR = 'CONCAT_WS(" ", User.first_name, User.last_name)';
    const SQL_SELECT_ELAPSED_TIME = 'datediff(NOW(), FROM_UNIXTIME(record.infraction_date))';

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
    public function rules()
    {
        return [
            [['id', 'infraction_date', 'open_date', 'state_id', 'ticket_fee', 'ticket_payment_expire_date', 'status_id'], 'integer'],
            [['lat', 'lng', 'license', 'comments', 'user_plea_request', 'elapsedTime'], 'safe'],
            [['created_at'], 'date'],
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
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'author' => $this->getAuthorLabelByRole(Yii::$app->user->role->name)
        ]);
    }

    public function getAuthorLabelByRole($role)
    {
        switch ($role) {
            case Role::ROLE_VIDEO_ANALYST:
            case Role::ROLE_VIDEO_ANALYST_SUPERVISOR:
            case Role::ROLE_PRINT_OPERATOR:
                return Yii::t('app', 'Uploaded By');
                break;
            case Role::ROLE_POLICE_OFFICER:
                return Yii::t('app', 'Reviewed By');
        }
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
        $query = $this->find()
            ->select([
                'id' => 'record.id',
                'license' => 'record.license',
                'lat' => 'record.lat',
                'lng' => 'record.lng',
                'state_id' => 'record.state_id',
                'infraction_date' => 'record.infraction_date',
                'created_at' => 'record.created_at',

                'author_id' => 'StatusHistory.author_id',

                'author' => self::SQL_SELECT_AUTHOR,
                'elapsedTime' => self::SQL_SELECT_ELAPSED_TIME,
            ])
            ->from(['record' => static::tableName()])
            ->joinWith([
                'statusHistory' => function (ActiveQuery $query) {
                    $query->joinWith('author');
                },
            ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'id',
                    'created_at',
                    'author',
                    'infraction_date',
                    'license',
                    'elapsedTime',
                ],
                'defaultOrder' => ['created_at' => SORT_DESC]
            ],
            'pagination' => [
                'pageSize' => self::settings()->get('search.page.size')
            ]
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
            'infraction_date' => $this->infraction_date,
            'record.created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'license', $this->license])
            ->andFilterWhere(['like', 'lat', $this->lat])
            ->andFilterWhere(['like', 'lng', $this->lng]);

        $query->andFilterWhere(['like', self::SQL_SELECT_ELAPSED_TIME, $this->elapsedTime]);

        if ($statuses = $this->getAvailableStatuses()) {
            $query->andFilterWhere(['in', 'status_id', $statuses]);
        }

        return $dataProvider;
    }

    /**
     * @return array
     */
    public function getAvailableStatuses()
    {
        return self::record()->getAvailableStatuses();
    }

    /**
     * @return \app\components\Record
     */
    private static function record()
    {
        return Yii::$app->record;
    }

    /**
     * @return Settings
     */
    private static function settings()
    {
        return Yii::$app->settings;
    }

}
