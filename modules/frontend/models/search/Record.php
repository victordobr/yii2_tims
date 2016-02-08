<?php
namespace app\modules\frontend\models\search;

use app\enums\CaseStatus as Status;
use app\models\User;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\db\QueryInterface;
use yii\helpers\Html;

class Record extends \app\modules\frontend\models\base\Record
{
    const CREATED_AT_TODAY = 1;
    const CREATED_AT_LAST_3_DAYS = 2;
    const CREATED_AT_LAST_X_DAYS = 3;
    const CREATED_ALL = 4;

    const STATUS_INCOMPLETE = 1;
    const STATUS_COMPLETE_WITH_DEACTIVATION_WINDOW = 2;
    const STATUS_PRINT_P1 = 3;
    const STATUS_RE_PRINT = 4;

    public $filter_created_at_list = [];
    public $uploader_list = [];

    public $filter_created_at = self::CREATED_ALL;
    public $filter_status = 0;
    public $filter_status_incomplete = 0;
    public $filter_status_complete = 0;
    public $filter_uploaded_by = 0;

    public $by_infraction_date;
    public $by_status;
    public $uploaded_by;


    public function search($params)
    {
        if (empty($params['Record']['user_id'])) {
            $params['Record']['user_id'] = null;
        }

        $provider = parent::search($params);
        $query = $provider->query;

        if (!empty($params['Record'])) {
            $params = $params['Record'];
        }


        $this->setAttributes($params);

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
                'fullName' => self::SQL_SELECT_FULL_NAME,
            ])
            ->from(['record' => static::tableName()])
            ->joinWith([
                'user' => function ($query) {
                    $query->from('User user');
                },
                'owner' => function ($query) {
                    $query->from('Owner owner');
                },
            ]);

        $dataProvider = new ActiveDataProvider(['query' => $query]);


        $query->andFilterWhere(['like', self::SQL_SELECT_FULL_NAME, $this->fullName]);
        $query->andFilterWhere(['like', self::SQL_SELECT_ELAPSED_TIME, $this->elapsedTime]);

        if (!empty($params['ids'])) {
            $query->andFilterWhere(['in', 'record.id', $params['ids']]);
        }

        return $dataProvider;
    }

    private function filterByStatus(QueryInterface &$query, $filter)
    {
        $statuses = [];
        if (in_array(self::STATUS_INCOMPLETE, $filter)) {
            $statuses[] = Status::INCOMPLETE;
        }
        if (in_array(self::STATUS_COMPLETE_WITH_DEACTIVATION_WINDOW, $filter)) {
            $statuses[] = Status::COMPLETE;
            $statuses[] = Status::FULL_COMPLETE;
        }
        if (in_array(self::STATUS_PRINT_P1, $filter)) {
            $statuses[] = Status::DMV_DATA_RETRIEVED_COMPLETE;
            $statuses[] = Status::DMV_DATA_RETRIEVED_INCOMPLETE;
        }
        if (in_array(self::STATUS_RE_PRINT, $filter)) {
            $statuses[] = Status::QC_BAD_P1;
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
            case self::CREATED_AT_TODAY:
                return $query->andFilterWhere(['>', 'record.created_at', strtotime('midnight')]);
            case self::CREATED_AT_LAST_3_DAYS:
                return $query->andFilterWhere(['>', 'record.created_at', strtotime('-3 days')]);
            case self::CREATED_AT_LAST_X_DAYS:
                if (!is_numeric($days_ago) || $days_ago <= 0 || $days_ago > 366) {
                    return false;
                }
                return $query->andFilterWhere(['>', 'record.created_at', strtotime('-' . $days_ago . ' days')]);
        }
    }

    private function initCreatedAtFilters()
    {
        $input = Html::input('text', 'Record[X]', '', ['maxlength' => 3]);

        return $this->filter_created_at_list = [
            self::CREATED_AT_TODAY => Yii::t('app', 'Today'),
            self::CREATED_AT_LAST_3_DAYS => Yii::t('app', 'Last 3 days'),
            self::CREATED_AT_LAST_X_DAYS => Yii::t('app', 'Last ') . $input . Yii::t('app', ' days'),
            self::CREATED_ALL => Yii::t('app', 'All cases '),
        ];
    }

    public function getCreatedAtFilters()
    {
        if (!$this->filter_created_at_list) {
            $this->initCreatedAtFilters();
        }

        return $this->filter_created_at_list;
    }

    private function initUploaderList()
    {
        $this->uploader_list[0] = 'all';
        foreach ($this->getUploaders() as $user) {
            $full_name = trim($user->getFullName());
            $this->uploader_list[$user->id] = !$full_name ?
                '# ' . $user->id :
                $user->getFullName() . ' / ' . $user->id;
        }

        return $this->uploader_list;
    }

    /**
     * @return array|User[]
     */
    private function getUploaders()
    {
        return User::find()
            ->from('User u')
            ->joinWith([
                'record' => function ($query) {
                    $query->from('Record r');
                },
            ])
            ->select(['u.id', 'u.pre_name', 'u.first_name', 'u.last_name'])
            ->where(['in', 'r.status_id', $this->getAvailableStatuses()])
            ->all();
    }

    public function getUploaderList()
    {
        if (!$this->uploader_list) {
            $this->initUploaderList();
        }

        return $this->uploader_list;
    }
}