<?php
namespace app\modules\frontend\models\update;

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

    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'id' => Yii::t('app', 'Case Number #'),
            'status_id' => Yii::t('app', 'Record Status'),
            'license' => Yii::t('app', 'Vehicle Tag #'),
            'elapsedTime' => Yii::t('app', 'Elapsed Time'),
        ]);
    }

    public function search($params)
    {
        $provider = parent::search($params);
        $query = $provider->query;

        $query->select([
            'id' => 'record.id',
            'infraction_date' => 'record.infraction_date',
            'license' => 'record.license',
            'status_id' => 'record.status_id',
            'elapsedTime' => self::SQL_SELECT_ELAPSED_TIME,
        ]);

        $provider->setSort([
            'attributes' => [
                'id',
                'infraction_date',
                'license',
                'status_id',
                'elapsedTime'
            ],
            'defaultOrder' => ['infraction_date' => SORT_DESC],
        ]);

        return $provider;
    }

    /**
     * @inheritdoc
     */
    public function getAvailableStatuses()
    {
        return [
            Status::INCOMPLETE,
            Status::COMPLETE,
            Status::FULL_COMPLETE,
            Status::VIEWED_RECORD,
            Status::AWAITING_DEACTIVATION,
            Status::DEACTIVATED_RECORD,
            Status::HOLD_1999,
            Status::VIEWED_RECORD,
            Status::APPROVED_RECORD_2021,
            Status::REJECTED_RECORD_2031,
            Status::AWAITING_CHANGE,
            Status::HOLD_2999,
            Status::APPROVED_RECORD,
            Status::REJECTED_RECORD,
            Status::QUERY_SUBMITTED,
            Status::DMV_DATA_RETRIEVED_COMPLETE,
            Status::DMV_DATA_RETRIEVED_INCOMPLETE,
            Status::DMV_DATA_RETRIEVED_INCOMPLETE_CRITICAL,
            Status::DMV_DATA_CORRUPT,
            Status::DMV_DATA_NOT_AVAILABLE,
            Status::DMV_DATA_MULTIPLE_MATCH,
            Status::HOLD_3999,
            Status::PRINTED_P1,
            Status::QC_CONFIRMED_GOOD_P1,
            Status::QC_BAD_P1,
            Status::PRINTED_P2,
            Status::QC_CONFIRMED_GOOD_P2,
            Status::QC_BAD_P2,
            Status::RECEIVED_P1,
            Status::VIEWED_RECORD_P1,
            Status::RECEIVED_P2,
            Status::VIEWED_RECORD_P2,
            Status::PAID,
            Status::COURT_DATE_REQUESTED,
            Status::COURT_DATE_SET,
            Status::COURT_VERDICT_RETURNED,
            Status::DISPUTED_AFFIDAVIT,
            Status::OVERDUE_P1,
            Status::OVERDUE_P2,
            Status::SENT_TO_COLLECTIONS,
            Status::HOLD_5999,
            Status::CLOSED_PAID,
            Status::CLOSED_UNPAID,
            Status::ARCHIVED,
            Status::RECORD_HOLD,
            Status::MARKED_FOR_PURGE_30D,
            Status::QC_BAD_P1,
            Status::QC_BAD_P2,
            Status::QC_CONFIRMED_GOOD_P1,
            Status::QC_CONFIRMED_GOOD_P2,
        ];
    }

    // implemented methods

    public function getCreatedAtFilters()
    {
        $input = Html::input('text', 'Record[X]', '', ['class'=>'form-control input-in-text', 'maxlength' => 3]);

        return [
            self::FILTER_CREATED_AT_TODAY => Yii::t('app', 'Today'),
            self::FILTER_CREATED_AT_LAST_3_DAYS => Yii::t('app', 'Last 3 days'),
            self::FILTER_CREATED_AT_LAST_X_DAYS => Yii::t('app', 'Last ') . $input . Yii::t('app', ' days'),
            self::FILTER_CREATED_ALL => Yii::t('app', 'All cases '),
        ];
    }

    public function getStatusFilters()
    {
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

    public function getAuthorFilters()
    {
        $authors = [];
        foreach ($this->getHistory() as $history) {
            if (empty($author = $history->author)) {
                $authors[0] = Yii::t('app', '# System');
                continue;
            }

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
        return Status::listCodeDescription();
    }

}