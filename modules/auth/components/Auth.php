<?php

namespace app\modules\auth\components;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use \yii\base\Exception;
use yii\web\User;

class Auth extends User
{
    const HASH_PARAM_NAME = 'hash';

    /** @var int password length. */
    public $passwordLength = 8;

    /** @var \yii\rbac\ManagerInterface auth manager. */
    protected $authManager;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if (!empty(Yii::$app->settings->get('user.inactive_interval'))) {
            $this->setUserInactiveTimeout(Yii::$app->settings->get('user.inactive_interval'));
        }
        $this->authManager = Yii::$app->authManager;
    }

    /**
     * The number of seconds in which the user will be logged out automatically if he remains inactive
     * @param $timeout the number of seconds
     */
    private function setUserInactiveTimeout($timeout)
    {
        $this->authTimeout = $timeout;
        $this->enableAutoLogin = false;
        $this->enableSession = true;
    }

    /**
     * Gets list of all users
     * @return array list of users' full names
     */
    public function userList()
    {
        return \app\models\User::getUserList();
    }

    /**
     * Generate password hash.
     * @param string $password password.
     * @return bool
     * @author Alex Makhorin
     */
    public function generatePasswordHash($password)
    {
        return sha1($password);
    }

    /**
     * Validate password.
     * @param string $password password.
     * @param string $hash hash.
     * @return bool
     * @author Alex Makhorin
     */
    public function validatePassword($password, $hash)
    {
        return $this->generatePasswordHash($password) === $hash;
    }

    /**
     * Apply role to user
     * @param string $roleId from app\enums\Role
     * @param int $userId user id.
     * @param bool $revokeAll - delete or not all previous roles of this user
     * @return \yii\rbac\Assignment assignment object
     * @throws Exception
     *
     * @author Alex Makhorin
     */
    public function applyRole($roleId, $userId, $revokeAll = true)
    {
        $role = $this->authManager->getRole($roleId);

        if(!$role){
            throw new Exception(Yii::t('app', "The role '{$roleId}' was not found in the System. Please try another one."), 500);
        }

        if ($revokeAll) {
            $this->authManager->revokeAll($userId);
        }
        return $this->authManager->assign($role, $userId);
    }

    /**
     * Generate password.
     * @return string password.
     * @author Alex Makhorin
     */
    public function generateNewPassword()
    {
        return Yii::$app->security->generateRandomString($this->passwordLength);
    }

}