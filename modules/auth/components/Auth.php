<?php

namespace app\modules\auth\components;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use \yii\base\Exception;
use yii\rbac\Role;
use yii\rbac\Permission;

class Auth extends Component
{
    /*
     * @var Role
     */
    protected $_role;

    /*
     * @var Permission[]
     */
    protected $_permissions;

    const HASH_PARAM_NAME = 'hash';

    /** @var int password length. */
    public $passwordLength = 8;

    /** @var \yii\rbac\ManagerInterface auth manager. */
    private $authManager;


    public function initParams($userId)
    {
        $this->_role = array_shift($this->authManager->getRolesByUser($userId));
        $this->_permissions = $this->authManager->getPermissionsByUser($userId);
    }

    public function getRole()
    {
        return $this->_role;
    }

    public function getPermissions()
    {
        return $this->_permissions;
    }

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