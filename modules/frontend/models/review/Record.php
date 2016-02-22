<?php
namespace app\modules\frontend\models\review;

use app\enums\CaseStatus as Status;
use app\modules\frontend\models\base\RecordFilter;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class Record extends \app\modules\frontend\models\base\Record implements RecordFilter
{

    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'id' => Yii::t('app', 'Case Number #'),
            'filter_author_id' => Yii::t('app', 'Reviewed By'),
            'author' => Yii::t('app', 'Reviewed By'),
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
            'created_at' => 'record.created_at',
            'author' => self::SQL_SELECT_AUTHOR,
            'elapsedTime' => self::SQL_SELECT_ELAPSED_TIME,
        ]);

        $provider->setSort([
            'attributes' => [
                'id',
                'infraction_date',
                'license',
                'created_at',
                'author',
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
            Status::COMPLETE,
            Status::FULL_COMPLETE,
            Status::VIEWED_RECORD,
            Status::REJECTED_RECORD,
        ];
    }

    // implemented methods

    public function getCreatedAtFilters()
    {
        $input = Html::input('text', 'Record[X]', '', ['class' => 'form-control input-in-text', 'maxlength' => 3]);

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
                'label' => Yii::t('app', 'Show only viewed cases without a determination'),
                'value' => self::FILTER_STATUS_VIEWED,
            ],
            [
                'label' => Yii::t('app', 'Show only records within change window'),
                'value' => self::FILTER_STATUS_DETERMINED,
            ],
        ];

    }

    public function getAuthorFilters()
    {
        $authors = [];
        foreach ($this->getHistory() as $history) {
            $author = $history->author;
            $full_name = trim($author->getFullName());
            $authors[$author->id] = !$full_name ?
                '# ' . $author->id :
                $full_name . ' / ' . $author->id;
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