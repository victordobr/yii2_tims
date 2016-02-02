<?php

namespace app\modules\auth\models\forms;

use Yii,
    yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 * @package app\modules\auth\models\forms
 * @version 1.0
 */
class Recover extends Model
{
    public $password;

    public $repeatPassword;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['password', 'repeatPassword'], 'required'],
            [['password', 'repeatPassword'], 'string', 'max' => 255, 'min' => 6],
            ['repeatPassword', 'compare', 'compareAttribute' => 'password'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'password' => Yii::t('app', 'Password'),
            'repeatPassword' => Yii::t('app', 'Repeat Password'),
        ];
    }
}
