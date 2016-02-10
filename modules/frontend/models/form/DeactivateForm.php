<?php
namespace app\modules\frontend\models\form;

use app\enums\CaseStatus;
use app\models\StatusHistory;
use Yii;
use yii\base\Model;
use app\enums\Reasons;

class DeactivateForm extends Model
{
    const SCENARIO_APPROVE = 'approve';
    const SCENARIO_REJECT = 'reject';

    public $requested_by;
    public $review_reason;

    public static $history;

    public $record_id;
    public $reason;
    public $action = self::SCENARIO_APPROVE;

    public $code;
    public $description;

    public function actions()
    {
        return [
            self::SCENARIO_APPROVE => Yii::t('app', 'Approve – deactivate record'),
            self::SCENARIO_REJECT => Yii::t('app', 'Reject deactivation request'),
        ];
    }

    public function init()
    {
        $this->requested_by = $this->getRequestedBy();
        $this->review_reason = $this->getReviewReason();
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['code'], 'required', 'when' => function($model) {
                return $model->action == self::SCENARIO_REJECT;
            }],
            [['description'], 'required', 'when' => function($model) {
                return $model->action == self::SCENARIO_REJECT && $model->code == Reasons::OTHER;
            }],
            [['code'], 'integer'],
            [['description'], 'string'],
            [['action'], 'safe'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'code' => Yii::t('app', 'Code'),
            'description' => Yii::t('app', 'Description'),
        ];
    }

    public function validateAction($action)
    {
        return in_array($action, [
            self::SCENARIO_APPROVE,
            self::SCENARIO_REJECT,
        ]);
    }

    /**
     * @return bool
     */
    public function isRejectAction()
    {
        return $this->action == self::SCENARIO_REJECT;
    }

    public function getReviewReason()
    {
        $history = self::getHistoryStatus($this->record_id);
        if (!$history) {
            return false;
        }
        $reason = $history->reason;
        if (!$reason) {
            return false;
        }

        $reasonsList = Reasons::listReasonsRequestDeactivation();

        return $reason->code == Reasons::OTHER ? $reason->description : $reasonsList[$reason->code];
    }

    public function getRequestedBy()
    {
        $history = self::getHistoryStatus($this->record_id);
        if (!$history) {
            return false;
        }

        return $history->author->getFullName() . " #{$history->author->id}";
    }

    /**
     * @param $record_id
     * @return array|null|StatusHistory
     */
    private static function getHistoryStatus($record_id)
    {
        if (is_null(self::$history)) {
            $condition = ['record_id' => $record_id, 'status_code' => CaseStatus::AWAITING_DEACTIVATION];
            self::$history = StatusHistory::find()->where($condition)->orderBy(['id' => SORT_DESC])->one();
        }

        return self::$history;
    }
}
