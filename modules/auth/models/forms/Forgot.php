<?php

namespace app\modules\auth\models\forms;

use Yii,
    yii\base\Model,
    app\modules\auth\models\mappers\classes\UserIdentity as User;

/**
 * LoginForm is the model behind the login form.
 * @package app\modules\auth\models\forms
 * @version 1.0
 */
class Forgot extends Model
{
    /** @var string $email */
    public $email;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['email', 'required'],
            ['email', 'exist', 'targetAttribute' => 'email', 'targetClass' => User::className(), 'message' => Yii::t('app', 'This email is not registered in the system.')],
            ['email', 'email'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'email'   => Yii::t('app', 'Email'),
        ];
    }
}
