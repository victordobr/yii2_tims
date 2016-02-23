<?php
namespace app\modules\frontend\models\prints\qc;

use app\enums\CaseStatus as Status;
use app\modules\frontend\models\base\RecordFilter;
use Yii;
use yii\data\ActiveDataProvider;
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
            'status_id' => Yii::t('app', 'Case Status'),
            'created_at' => Yii::t('app', 'Uploaded Date'),
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
            'created_at' => 'record.created_at',
            'elapsedTime' => self::SQL_SELECT_ELAPSED_TIME,
        ]);

        $provider->setSort([
            'attributes' => [
                'id',
                'infraction_date',
                'license',
                'status_id',
                'created_at',
                'elapsedTime'
            ],
            'defaultOrder' => ['created_at' => SORT_DESC],
        ]);

        return $provider;
    }

    /**
     * @return array
     */
    public function getAvailableStatuses()
    {
        return [
            Status::PRINTED_P1,
            Status::PRINTED_P2,
        ];
    }

    public function getCreatedAtFilters()
    {
        $input = Html::input('text', 'Record[X]', '', ['class' => 'form-control input-in-text', 'maxlength' => 3]);

        return  [
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
                'label' => Yii::t('app', 'Show only records pending print for Period 1'),
                'value' => self::FILTER_STATUS_PENDING_PRINT_P1,
            ],
        ];
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