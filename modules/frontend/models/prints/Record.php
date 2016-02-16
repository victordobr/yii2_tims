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
            'author' => self::SQL_SELECT_AUTHOR,
            'elapsedTime' => self::SQL_SELECT_ELAPSED_TIME,
        ]);

        $provider->setSort([
            'attributes' => [
                'id',
                'infraction_date',
                'license',
                'status_id',
                'created_at',
                'author',
                'elapsedTime'
            ],
            'defaultOrder' => ['created_at' => SORT_ASC],
        ]);

        return $provider;
    }

    public function preview($params)
    {
        $query = $this->find()
            ->select([
                'id' => 'record.id',
                'license' => 'record.license',
                'latitude' => 'location.lat_dd',
                'longitude' => 'location.lng_dd',
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
                'location' => function (ActiveQuery $query) {
                    $query->from('Location location');
                },
            ]);

        $provider = new ActiveDataProvider(['query' => $query]);

        if (!empty($params['ids'])) {
            $query->andFilterWhere(['in', 'record.id', $params['ids']]);
        }

        return $provider;
    }

    /**
     * @return array
     */
    public function getAvailableStatuses()
    {
        switch (Yii::$app->controller->action->id) {
            case 'qc':
                return [
                    Status::PRINTED_P1,
                    Status::PRINTED_P2,
                ];
            default:
                return [ // index
                    Status::DMV_DATA_RETRIEVED_COMPLETE,
                    Status::DMV_DATA_RETRIEVED_INCOMPLETE,
                    Status::OVERDUE_P1,
                ];
        }
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
            default:
                return [];
        }
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