<?php
namespace app\modules\frontend\models\base;

use app\components\Settings;
use app\models\StatusHistory;
use app\models\base\User;
use Yii;
use yii\db\ActiveQuery;
use yii\db\QueryInterface;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use app\enums\CaseStatus as Status;

/**
 * Record represents the model behind the search form about `app\models\Record`.
 */
class Record extends \app\models\base\Record implements RecordFilter
{
    private $statuses = [];

    const SQL_SELECT_AUTHOR = 'CONCAT_WS(" ", User.first_name, User.last_name)';
    const SQL_SELECT_ELAPSED_TIME = 'DATEDIFF(NOW(), FROM_UNIXTIME(record.infraction_date))';

    public $filter_created_at = self::FILTER_CREATED_ALL;
    public $filter_status = self::FILTER_STATUS_DISABLED;
    public $filter_author_id;

    public $filter_created_at_from;
    public $filter_created_at_to;
    public $filter_elapsed_time_x_days;
    public $filter_state;
    public $filter_case_number;
    public $filter_smart_search_type = self::FILTER_SMART_SEARCH_EXACT;
    public $filter_smart_search_text;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [
                [
                    'filter_created_at',
                    'filter_status',
                    'filter_author_id',
                    'filter_created_at_from',
                    'filter_created_at_to',
                    'filter_elapsed_time_x_days',
                    'filter_state',
                    'filter_case_number',
                ],
                'integer'
            ],
            ['filter_smart_search_type', 'in', 'range' => [
                self::FILTER_SMART_SEARCH_EXACT,
                self::FILTER_SMART_SEARCH_PARTIAL,
                self::FILTER_SMART_SEARCH_WILDCARD,
            ]],
            ['filter_smart_search_text', 'string'],
        ]);
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
        $this->setAttributes($params);

        $query = static::find()
            ->select([
                'id' => 'record.id',
                'license' => 'record.license',
                'latitude' => 'location.lat_dd',
                'longitude' => 'location.lng_dd',
                'state_id' => 'record.state_id',
                'infraction_date' => 'record.infraction_date',
                'created_at' => 'record.created_at',
                'author_id' => 'StatusHistory.author_id',
                'author' => self::SQL_SELECT_AUTHOR,
                'elapsedTime' => self::SQL_SELECT_ELAPSED_TIME,
            ])
            ->from(['record' => self::tableName()])
            ->joinWith([
                'statusHistory' => function (ActiveQuery $query) {
                    $query->joinWith('author');
                },
            ]);

        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => self::settings()->get('search.page.size')
            ]
        ]);

        if ($statuses = $this->filterByAvailableStatuses()) {
            $query->andFilterWhere(['in', 'status_id', $statuses]);
        } else {
            $query->andFilterWhere(['status_id' => 0]);
            return $provider;
        }

        // basic filters

        if (!empty($this->filter_author_id)) {
            $this->filterByAuthorID($query, $this->filter_author_id);
        }

        if (!empty($this->filter_created_at)) {
            $this->filterByCreatedAt($query, $this->filter_created_at, $params['X']);
        }

        if (!empty($this->filter_status)) {
            $this->filterByStatus($query, $this->filter_status);
        }

        // advanced filters

        if (!empty($this->filter_created_at_from) || !empty($this->filter_created_at_to)) {
            $this->filterByCreatedAtRange($query, $this->filter_created_at_from, $this->filter_created_at_to);
        }

        if (!empty($this->filter_elapsed_time_x_days)) {
            $this->filterByCreatedAtDaysAgo($query, $this->filter_elapsed_time_x_days);
        }

        if (!empty($this->filter_state)) {
            $this->filterByRecordState($query, $this->filter_state);
        }

        if (!empty($this->filter_case_number)) {
            $this->filterByCaseNumber($query, $this->filter_case_number);
        }

        if (!empty($this->filter_smart_search_type) && !empty($this->filter_smart_search_text)) {
            $this->filterBySmartSearch($query, $this->filter_smart_search_type, $this->filter_smart_search_text);
        }

        return $provider;
    }

    // basic filters

    protected function filterByAuthorID(QueryInterface &$query, $author_id)
    {
        $query->andWhere([StatusHistory::tableName() . '.author_id' => $author_id]);
    }

    protected function filterByStatus(QueryInterface &$query, $filter)
    {
        $statuses = [];
        if (in_array(self::FILTER_STATUS_INCOMPLETE, $filter)) {
            $statuses[] = Status::INCOMPLETE;
        }
        if (in_array(self::FILTER_STATUS_COMPLETE, $filter)) {
            $statuses[] = Status::COMPLETE;
            $statuses[] = Status::FULL_COMPLETE;
        }
        if (in_array(self::FILTER_STATUS_VIEWED, $filter)) {
            $statuses[] = Status::VIEWED_RECORD;
        }
        if (in_array(self::FILTER_STATUS_DETERMINED, $filter)) {
            $statuses[] = Status::APPROVED_RECORD;
            $statuses[] = Status::REJECTED_RECORD;
        }
        if (in_array(self::FILTER_STATUS_PRINT_P1, $filter)) {
            $statuses[] = Status::DMV_DATA_RETRIEVED_COMPLETE;
            $statuses[] = Status::DMV_DATA_RETRIEVED_INCOMPLETE;
        }
        if (in_array(self::FILTER_STATUS_PRINT_P2, $filter)) {
            $statuses[] = Status::QC_BAD_P1;
        }
        if (in_array(self::FILTER_STATUS_PENDING_PRINT_P1, $filter)) {
            $statuses[] = Status::PRINTED_P1;
        }

        $query->andFilterWhere(['in', 'status_id', $statuses]);
    }

    protected function filterByCreatedAt(QueryInterface &$query, $filter, $days_ago)
    {
        if (!array_key_exists($filter, $this->getCreatedAtFilters())) {
            return false;
        }

        switch ($filter) {
            case self::FILTER_CREATED_AT_TODAY:
                $query->andFilterWhere(['>', 'record.created_at', strtotime('midnight')]);
                break;
            case self::FILTER_CREATED_AT_LAST_3_DAYS:
                $query->andFilterWhere(['>', 'record.created_at', strtotime('-3 days')]);
                break;
            case self::FILTER_CREATED_AT_LAST_X_DAYS:
                if (!is_numeric($days_ago) || $days_ago <= 0 || $days_ago > self::MAX_DAYS_AGO) {
                    return false;
                }
                $query->andFilterWhere(['>', 'record.created_at', strtotime('-' . $days_ago . ' days')]);
                break;
        }
    }

    // advanced filters

    protected function filterByCreatedAtRange(QueryInterface &$query, $from, $to)
    {
        switch(true){
            case !empty($from) && !empty($to):
                $query->andFilterWhere(['between', 'record.created_at', strtotime($from), strtotime($to)]);
                break;
            case !empty($from):
                $query->andFilterWhere(['>=', 'record.created_at', strtotime($from)]);
                break;
            case !empty($to):
                $query->andFilterWhere(['<=', 'record.created_at', strtotime($to)]);
                break;
        }
    }

    protected function filterByCreatedAtDaysAgo(QueryInterface &$query, $days_ago)
    {
        if (!is_numeric($days_ago) || $days_ago <= 0 || $days_ago > self::MAX_DAYS_AGO) {
            return false;
        }

        return $query->andFilterWhere(['>', 'record.created_at', strtotime('-' . $days_ago . ' days')]);
    }

    protected function filterByRecordState(QueryInterface &$query, $status_id)
    {
        $query->andFilterWhere(['status_id' => $status_id]);
    }

    protected function filterByCaseNumber(QueryInterface &$query, $record_id)
    {
        $query->andWhere(['record.id' => $record_id]);
    }

    protected function filterBySmartSearch(QueryInterface &$query, $type, $text)
    {
        switch ($type) {
            case self::FILTER_SMART_SEARCH_EXACT:
                $query->andFilterWhere(['OR',
                    ['record.id' => $text],
                    ['record.license' => $text],
                ]);
                break;
            case self::FILTER_SMART_SEARCH_PARTIAL:
                $query->andFilterWhere(['OR',
                    ['like', 'record.id', $text],
                    ['like', 'record.license', $text],
                ]);
                break;
            case self::FILTER_SMART_SEARCH_WILDCARD:
                $text = str_replace('*', '%', $text);
                $text = str_replace('?', '_', $text);
                $query->andFilterWhere(['OR',
                    'record.id LIKE \''.$text.'\'',
                    'record.license LIKE \''.$text.'\'',
                ]);
                break;
        }
    }

    /**
     * @return array
     */
    public function filterByAvailableStatuses()
    {
        if (!$this->statuses) {
            $this->statuses = array_intersect(
                $this->getAvailableStatuses(),
                self::record()->getAvailableStatuses()
            );
        }

        return $this->statuses;
    }

    // implemented methods

    public function getCreatedAtFilters()
    {
        return [];
    }

    public function getStatusFilters()
    {
        return [];
    }

    public function getAuthorFilters()
    {
        return [];
    }

    public function getSmartSearchTypes()
    {
        return [];
    }

    public function getRecordStatuses()
    {
        return [];
    }

    public function getAvailableStatuses()
    {
        return [];
    }

    // private methods

    /**
     * @return array|StatusHistory[]
     */
    protected function getHistory()
    {
        return StatusHistory::find()
            ->select(['sh.author_id', 'u.id', 'u.pre_name', 'u.first_name', 'u.last_name'])
            ->from(StatusHistory::tableName() . ' sh')
            ->joinWith([
                'record' => function (ActiveQuery $query) {
                    $query->from(self::tableName() . ' r');
                },
                'author' => function (ActiveQuery $query) {
                    $query->from(User::tableName() . ' u');
                },
            ])
            ->where(['in', 'r.status_id', $this->getAvailableStatuses()])
            ->all();
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
    protected static function settings()
    {
        return Yii::$app->settings;
    }

}
