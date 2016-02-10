<?php

namespace app\modules\auth\models\forms;

use Yii,
    yii\base\Model;
use app\modules\auth\models\mappers\classes\UserIdentity;

/**
 * LoginForm is the model behind the login form.
 * @package app\modules\auth\models\forms
 */
class Login extends Model
{
    /** @var string $username */
    public $username;

    /** @var string $password */
    public $password;

    /** @var bool $rememberMe */
    public $rememberMe = true;

    /** @var UserIdentity|null $_user */
    private $_user = null;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username'   => Yii::t('app', 'Username'),
            'password'   => Yii::t('app', 'Password'),
            'rememberMe' => Yii::t('app', 'Remember Me'),
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {

        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, Yii::t('app', 'Incorrect username or password'));
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            Yii::$app->user->returnUrl = Yii::$app->params['url.cabinet.admin'];
            Yii::$app->defaultRoute = Yii::$app->params['url.cabinet.admin'];

            $userModel = $this->getUser();

            $success = Yii::$app->user->login($userModel, $this->rememberMe ? 3600 * 24 * 30 : 0);
            if($success) {
                $userModel->logins_count++;
                $userModel->last_login_at = time();
                $userModel->save(false);

                Yii::$app->user->initParams($userModel->primaryKey);
            }
            return $success;
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[username]]
     * @return UserIdentity|null
     */
    public function getUser()
    {
        if ($this->_user === null) {
            $this->_user = UserIdentity::findByUsername($this->username);
        }

        return $this->_user;
    }
}
