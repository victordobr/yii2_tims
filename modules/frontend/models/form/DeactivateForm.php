<?php
namespace app\modules\frontend\models\form;

use app\enums\CaseStatus;
use app\models\StatusHistory;
use Yii;
use yii\base\Model;

class DeactivateForm extends Model
{
    const SCENARIO_APPROVE = 'approve';
    const SCENARIO_REJECT = 'reject';

    private $requested_by;
    private $review_reason;

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

    public function scenarios()
    {
        return [
            self::SCENARIO_APPROVE => ['action'],
            self::SCENARIO_REJECT => ['action', 'code', 'description'],
        ];
    }


/**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['code', 'description'], 'required', 'on' => self::SCENARIO_REJECT],
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
        return $this->action == self::SCENARIO_APPROVE;
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

        return $reason->code . ' - ' . $reason->description;
    }

    public function getRequestedBy()
    {
        $history = self::getHistoryStatus($this->record_id);
        if (!$history) {
            return false;
        }

        return $history->author->getFullName();
    }

    /**
     * @param $record_id
     * @return array|null|StatusHistory
     */
    private static function getHistoryStatus($record_id)
    {
        if (is_null(self::$history)) {
            $condition = ['record_id' => $record_id, 'status_code' => CaseStatus::AWAITING_DEACTIVATION];
            self::$history = StatusHistory::find()->where($condition)->orderBy(['id' => 'DESC'])->one();
        }

        return self::$history;
    }

    public function __get($name)
    {
        if (!property_exists(__CLASS__, $name)) {
            return null;
        }
        if (is_null($this->$name)) {
            $method = self::collectMethodName($name);
            if (method_exists($this, $method)) {
                $this->$name = $this->$method();
            }
        }

        return $this->$name;
    }

    private static function collectMethodName($property)
    {
        return 'get' . join('', array_map(function ($w) {
            return ucfirst($w);
        }, explode('_', $property)));
    }

}
