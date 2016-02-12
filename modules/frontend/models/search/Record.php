<?php
namespace app\modules\frontend\models\search;

use app\enums\CaseStatus as Status;
use app\models\StatusHistory;
use app\models\User;
use app\modules\frontend\models\base\RecordFilter;
use Yii;
use yii\db\ActiveQuery;
use yii\db\QueryInterface;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class Record extends \app\modules\frontend\models\base\Record implements RecordFilter
{
    const FILTER_CREATED_AT_TODAY = 1;
    const FILTER_CREATED_AT_LAST_3_DAYS = 2;
    const FILTER_CREATED_AT_LAST_X_DAYS = 3;
    const FILTER_CREATED_ALL = 4;

    const FILTER_STATUS_DISABLED = 0;
    const FILTER_STATUS_INCOMPLETE = 1;
    const FILTER_STATUS_COMPLETE = 2;

    const FILTER_SMART_SEARCH_EXACT = 1;
    const FILTER_SMART_SEARCH_PARTIAL = 2;
    const FILTER_SMART_SEARCH_WILDCARD = 3;

    const MAX_DAYS_AGO = 999;

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

    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'id' => Yii::t('app', '#'),
            'filter_author_id' => Yii::t('app', 'Uploader By'),
            'created_at' => Yii::t('app', 'Uploaded Date'),
            'license' => Yii::t('app', 'Vehicle Tag #'),
            'elapsedTime' => Yii::t('app', 'Elapsed Time'),
        ]);
    }

    public function search($params)
    {
        $provider = parent::search($params);
        $query = $provider->query;

        $this->setAttributes($params);

        // basic filters

        if (!empty($params['filter_author_id'])) {
            $this->filterByAuthorID($query, $params['filter_author_id']);
        }

        if (!empty($params['filter_created_at'])) {
            $this->filterByCreatedAt($query, $params['filter_created_at'], $params['X']);
        }

        if (!empty($params['filter_status'])) {
            $this->filterByStatus($query, $params['filter_status']);
        }

        // advanced filters

        if (!empty($params['filter_created_at_from']) && !empty($params['filter_created_at_to'])) {
            $this->filterByCreatedAtRange($query, $params['filter_created_at_from'], $params['filter_created_at_to']);
        }

        if (!empty($params['filter_elapsed_time_x_days'])) {
            $this->filterByCreatedAtDaysAgo($query, $params['filter_elapsed_time_x_days']);
        }

        if (!empty($params['filter_state'])) {
            $this->filterByRecordState($query, $params['filter_state']);
        }

        if (!empty($params['filter_case_number'])) {
            $this->filterByCaseNumber($query, $params['filter_case_number']);
        }

        if (!empty($params['filter_smart_search_type']) && !empty($params['filter_smart_search_text'])) {
            $this->filterByCreatedAtRange($query, $params['filter_smart_search_type'], $params['filter_smart_search_text']);
        }

        return $provider;
    }

    // basic filters

    private function filterByAuthorID(QueryInterface &$query, $author_id)
    {
        $query->andWhere(['StatusHistory.author_id' => $author_id]);
    }

    private function filterByStatus(QueryInterface &$query, $filter)
    {
        $statuses = [];
        if (in_array(self::FILTER_STATUS_INCOMPLETE, $filter)) {
            $statuses[] = Status::INCOMPLETE;
        }
        if (in_array(self::FILTER_STATUS_COMPLETE, $filter)) {
            $statuses[] = Status::COMPLETE;
            $statuses[] = Status::FULL_COMPLETE;
        }
        if (!empty($statuses)) {
            $query->andFilterWhere(['in', 'status_id', $statuses]);
        }
    }

    private function filterByCreatedAt(QueryInterface &$query, $filter, $days_ago)
    {
        if (!array_key_exists($filter, $this->getCreatedAtFilters())) {
            return false;
        }

        switch ($filter) {
            case self::FILTER_CREATED_AT_TODAY:
                return $query->andFilterWhere(['>', 'record.created_at', strtotime('midnight')]);
            case self::FILTER_CREATED_AT_LAST_3_DAYS:
                return $query->andFilterWhere(['>', 'record.created_at', strtotime('-3 days')]);
            case self::FILTER_CREATED_AT_LAST_X_DAYS:
                if (!is_numeric($days_ago) || $days_ago <= 0 || $days_ago > 366) {
                    return false;
                }
                return $query->andFilterWhere(['>', 'record.created_at', strtotime('-' . $days_ago . ' days')]);
        }
    }

    // advanced filters

    private function filterByCreatedAtRange(QueryInterface &$query, $from, $to)
    {
        $query->andFilterWhere(['between', 'date', $from, $to]);
    }

    private function filterByCreatedAtDaysAgo(QueryInterface &$query, $days_ago)
    {
        if (!is_numeric($days_ago) || $days_ago <= 0 || $days_ago > self::MAX_DAYS_AGO) {
            return false;
        }

        return $query->andFilterWhere(['>', 'record.created_at', strtotime('-' . $days_ago . ' days')]);
    }

    private function filterByRecordState(QueryInterface &$query, $status_id)
    {
        $query->andFilterWhere(['status_id' => $status_id]);
    }

    private function filterByCaseNumber(QueryInterface &$query, $record_id)
    {
        $query->andWhere(['id' => $record_id]);
    }

    // implemented methods

    public function getCreatedAtFilters()
    {
        $input = Html::input('text', 'Record[X]', '', ['class'=>'form-control', 'maxlength' => 3]);

        return [
            self::FILTER_CREATED_AT_TODAY => Yii::t('app', 'Today'),
            self::FILTER_CREATED_AT_LAST_3_DAYS => Yii::t('app', 'Last 3 days'),
            self::FILTER_CREATED_AT_LAST_X_DAYS => Yii::t('app', 'Last ') . $input . Yii::t('app', ' days'),
            self::FILTER_CREATED_ALL => Yii::t('app', 'All cases '),
        ];
    }

    public function getStatusFilters($action)
    {
        switch ($action) {
            case 'search':
                return [
                    [
                        'label' => Yii::t('app', 'Show only incomplete records'),
                        'value' => self::FILTER_STATUS_INCOMPLETE,
                    ],
                    [
                        'label' => Yii::t('app', 'Show only records within deactivation window'),
                        'value' => self::FILTER_STATUS_COMPLETE,
                    ],
                ];
        }
    }

    public function getAuthorFilters()
    {
        $authors = [Yii::t('app', 'all')];
        foreach ($this->getHistory() as $history) {
            $author = $history->author;
            $full_name = trim($author->getFullName());
            $authors[$author->id] = !$full_name ? '# ' . $author->id : $full_name . ' / ' . $author->id;
        }

        return $authors;
    }

    public function getSmartSearchTypes()
    {
        return [
            self::FILTER_SMART_SEARCH_EXACT => Yii::t('app', 'Exact'),
            self::FILTER_SMART_SEARCH_PARTIAL => Yii::t('app', 'Partial'),
            self::FILTER_SMART_SEARCH_WILDCARD => Yii::t('app', 'Wildcard'),
        ];
    }

    public function getRecordStatuses()
    {
        return Status::listMainText();
    }

    // private methods

    /**
     * @return array|StatusHistory[]
     */
    private function getHistory()
    {
        return StatusHistory::find()
            ->select(['sh.author_id', 'u.id', 'u.pre_name', 'u.first_name', 'u.last_name'])
            ->from(StatusHistory::tableName() . ' sh')
            ->joinWith([
                'record' => function (ActiveQuery $query) {
                    $query->from(self::tableName() . ' r');
                },
            ])
            ->joinWith([
                'author' => function (ActiveQuery $query) {
                    $query->from(User::tableName() . ' u');
                },
            ])
            ->where(['in', 'r.status_id', $this->getAvailableStatuses()])
            ->all();
    }

}