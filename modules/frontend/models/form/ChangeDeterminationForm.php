<?php
namespace app\modules\frontend\models\form;

use app\enums\CaseStatus;
use app\models\StatusHistory;
use Yii;
use yii\base\Model;
use app\enums\Reasons;

class ChangeDeterminationForm extends Model
{
    const ACTION_APPROVE = 'approve';
    const ACTION_REJECT = 'reject';

    public static $history;

    public $action = self::ACTION_APPROVE;

    public $record_id;
    public $record_status;

    public $confirm;
    public $officer_pin;

    public $code;
    public $description;

    public $previous_determination;
    public $decision_by;

    public function init()
    {
        $this->initPreviousDetermination();
        $this->initDecisionBy();
    }

    private function initPreviousDetermination()
    {
        switch ($this->record_status) {
            case CaseStatus::APPROVED_RECORD:
                return $this->previous_determination = Yii::t('app', 'Violation');
            case CaseStatus::REJECTED_RECORD:
                return $this->previous_determination = Yii::t('app', 'Not in violation');
        }
    }

    private function initDecisionBy()
    {
        if (!($history = self::getHistory($this->record_id, $this->record_status))) {
            return null;
        }
        if (!($author = $history->author)) {
            return null;
        }

        return $this->decision_by = sprintf('%s %s / %d', $author->first_name, $author->last_name, $author->id);
    }

    /**
     * @param int $record_id
     * @param int $record_status
     * @return array|null|StatusHistory
     */
    private static function getHistory($record_id, $record_status)
    {
        if (is_null(self::$history)) {
            $condition = ['record_id' => $record_id, 'status_code' => $record_status];
            self::$history = StatusHistory::find()->where($condition)->orderBy(['id' => SORT_DESC])->one();
        }

        return self::$history;
    }

    public function actions()
    {
        return [
            self::ACTION_APPROVE => Yii::t('app', 'Violation - proceed to issue citation'),
            self::ACTION_REJECT => Yii::t('app', 'Not in violation'),
        ];
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['confirm', 'officer_pin', 'code'], 'required'],
            [['description'], 'required', 'when' => function ($model) {
                return $model->code == Reasons::OTHER;
            }],
            [['confirm'], 'compare', 'compareValue' => '1', 'message' => ''],
            [['code'], 'integer'],
            [['description'], 'string'],
            [['officer_pin'], 'string', 'max' => 16],
            [['action'], 'safe'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'action' => Yii::t('app', 'Select new determination'),
            'confirm' => Yii::t('app', 'I solemnly swear that I am a certified peace officer employed by a law enforcement agency authorized to enforce this Code section
40-6-163, and I hereby state that, based upon inspection of recorded images, the owner`s motor vehicle was operated in disregard
or disobedience of subsection (a) of this Code section and that such disregard or disobedience was not otherwise authorized by law.'),
            'code' => Yii::t('app', 'Choose reason for change'),
            'description' => Yii::t('app', 'If other, then enter description'),
            'officer_pin' => Yii::t('app', 'Enter your officer PIN to certify'),
        ];
    }

    public function validateAction($action)
    {
        return in_array($action, [
            self::ACTION_APPROVE,
            self::ACTION_REJECT,
        ]);
    }

    /**
     * @return bool
     */
    public function isRejectAction()
    {
        return $this->action == self::ACTION_REJECT;
    }

}
