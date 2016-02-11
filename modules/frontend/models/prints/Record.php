<?php
namespace app\modules\frontend\models\prints;

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
    const FILTER_CREATED_AT_TODAY = 1;
    const FILTER_CREATED_AT_LAST_3_DAYS = 2;
    const FILTER_CREATED_AT_LAST_X_DAYS = 3;
    const FILTER_CREATED_ALL = 4;

    const FILTER_STATUS_DISABLED = 0;
    const FILTER_STATUS_PRINT_P1 = 1;
    const FILTER_STATUS_PRINT_P2 = 2;
    const FILTER_STATUS_PENDING_PRINT_P1 = 3;

    public $filter_created_at = self::FILTER_CREATED_ALL;
    public $filter_status = self::FILTER_STATUS_DISABLED;

    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'id' => Yii::t('app', 'Case Number #'),
            'status_id' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Uploaded Date'),
            'license' => Yii::t('app', 'Vehicle Tag #'),
            'elapsedTime' => Yii::t('app', 'Elapsed Time'),
        ]);
    }

    public function search($params)
    {
        $provider = parent::search($params);
        $query = $provider->query;

        $query->addSelect(['status_id' => 'record.status_id']);
        $provider->sort->attributes = array_merge($provider->sort->attributes, [
            'status_id' => [
                'asc' => ['status_id' => SORT_ASC],
                'desc' => ['status_id' => SORT_DESC],
            ]
        ]);

        if (!empty($params['filter_created_at'])) {
            $this->filterByInfractionDate($query, $params['filter_created_at'], $params['X']);
        }

        if (!empty($params['filter_status'])) {
            $this->filterByStatus($query, $params['filter_status']);
        }

        return $provider;
    }

    public function preview($params)
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
                'status_id' => 'record.status_id',
                'elapsedTime' => self::SQL_SELECT_ELAPSED_TIME,
            ])
            ->from(['record' => static::tableName()])
            ->joinWith([
                'owner' => function (ActiveQuery $query) {
                    $query->from('Owner owner');
                },
            ]);

        $provider = new ActiveDataProvider(['query' => $query]);

        if (!empty($params['ids'])) {
            $query->andFilterWhere(['in', 'record.id', $params['ids']]);
        }

        return $provider;
    }

    private function filterByStatus(QueryInterface &$query, $filter)
    {
        $statuses = [];
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
        if (!empty($statuses)) {
            $query->andFilterWhere(['in', 'status_id', $statuses]);
        }
    }

    private function filterByInfractionDate(QueryInterface &$query, $filter, $days_ago)
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

    public function getCreatedAtFilters()
    {
        $input = Html::input('text', 'Record[X]', '', ['maxlength' => 3]);

        return  [
            self::FILTER_CREATED_AT_TODAY => Yii::t('app', 'Today'),
            self::FILTER_CREATED_AT_LAST_3_DAYS => Yii::t('app', 'Last 3 days'),
            self::FILTER_CREATED_AT_LAST_X_DAYS => Yii::t('app', 'Last ') . $input . Yii::t('app', ' days'),
            self::FILTER_CREATED_ALL => Yii::t('app', 'All cases '),
        ];
    }

    public function getStatusFilters($action)
    {
        switch ($action) {
            case 'index':
                return [
                    [
                        'label' => Yii::t('app', 'Show only cases pending print for Period 1'),
                        'value' => self::FILTER_STATUS_PRINT_P1,
                    ],
                    [
                        'label' => Yii::t('app', 'Show only cases pending print for Period 2'),
                        'value' => self::FILTER_STATUS_PRINT_P2,
                    ],
                ];
            case 'qc':
                return [
                    [
                        'label' => Yii::t('app', 'Show only records pending print for Period 1'),
                        'value' => self::FILTER_STATUS_PENDING_PRINT_P1,
                    ],
                ];
        }
    }

    public function getAuthorFilters()
    {
        return [];
    }

}