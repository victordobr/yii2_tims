<?php
namespace app\modules\frontend\models\form;

use Yii;
use yii\base\Model;
use app\enums\Reasons;

class MakeDeterminationForm extends Model
{
    const ACTION_APPROVE = 'approve';
    const ACTION_REJECT = 'reject';

    public $action = self::ACTION_APPROVE;

    public $confirm;
    public $officer_pin;

    public $code;
    public $description;

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
            [['confirm', 'officer_pin'], 'required'],
            [['code'], 'required', 'when' => function($model) {
                return $model->action == self::ACTION_REJECT;
            }],
            [['description'], 'required', 'when' => function($model) {
                return $model->action == self::ACTION_REJECT && $model->code == Reasons::OTHER;
            }],
            [['confirm'], 'compare', 'compareValue'=>'1', 'message' => Yii::t('app', 'confirm')],
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
            'confirm' => Yii::t('app', 'I solemnly swear that I am a certified peace officer employed by a law enforcement agency authorized to enforce this Code section
40-6-163, and I hereby state that, based upon inspection of recorded images, the owner`s motor vehicle was operated in disregard
or disobedience of subsection (a) of this Code section and that such disregard or disobedience was not otherwise authorized by law.'),
            'code' => Yii::t('app', 'Choose reason for rejection'),
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
