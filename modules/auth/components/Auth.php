<?php

namespace app\modules\auth\components;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;

class Auth extends Component
{
    const HASH_PARAM_NAME = 'hash';

    /** @var int password length. */
    public $passwordLength = 8;

    /** @var \yii\rbac\ManagerInterface auth manager. */
    private $authManager;

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->authManager = Yii::$app->authManager;
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
    static public function generatePasswordHash($password)
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
        return sha1($password) === $hash;
    }

    /**
     * Apply role to user
     * @param string $roleId from app\enums\Role
     * @param int $userId user id.
     * @param bool $revokeAll - delete or not all previous roles of this user
     * @return \yii\rbac\Assignment assignment object
     * @author Alex Makhorin
     */
    public function applyRole($roleId, $userId, $revokeAll = true)
    {
        $role = $this->authManager->getRole($roleId);
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