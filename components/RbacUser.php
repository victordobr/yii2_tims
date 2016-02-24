<?php
/**
 * Created by PhpStorm.
 * User: smile
 * Date: 26.11.15
 * Time: 20:03
 */

namespace app\components;


use app\enums\ReportType;
use Yii;
use yii\base\InvalidConfigException;
use \app\models\User as UserModel;
use \yii\base\Exception;
use yii\rbac\Role;
use yii\rbac\Permission;
use app\enums\Role as RoleName;

class RbacUser extends \app\modules\auth\components\Auth
{
    /**
     * @var Role
     */
    protected $_role;

    /**
     * @var Permission[]
     */
    protected $_permissions;

    public function getRole()
    {
        if (!$this->_role) {
            $roles = $this->authManager->getRolesByUser($this->identity->id);
            $this->_role = array_shift($roles);
        }

        return $this->_role;
    }

    public function getPermissions()
    {
        if (!$this->_permissions) {
            $this->_permissions = $this->authManager->getPermissionsByUser($this->identity->id);
        }

        return $this->_permissions;
    }

    public function hasRole(array $roles)
    {
        $role = $this->getRole();

        return in_array($role->name, $roles);
    }

    public function getRoleNameByUser($userId)
    {
        $roles = $this->authManager->getRolesByUser($userId);
        $role = array_shift($roles);

        return $role ? $role->name : null;
    }

    /**
     * Complete user creation method.
     * Includes password generation, role assign (via model's behavior) and email message sending.
     * @param array $validAttributes
     * @param string $roleId
     * @param bool $activation
     * @throws Exception
     * @return bool
     * @author Alex Makhorin
     */
    public function createUser($validAttributes, $roleId, $activation = false)
    {
        $model = new UserModel();
        $model->attributes = $validAttributes;

        if ($activation) {
            $password = $this->generateNewPassword();
            $model->password = $password;
            $model->activation_hash = Yii::$app->security->generateRandomString();
        }

        if (!$model->save(false)) {
            throw new Exception(Yii::t('app', 'DB error. User was not created.'));
        }

        $this->applyRole($roleId, $model->primaryKey);

        if ($activation) {
            $activationUrl = \yii\helpers\Url::to([
                '/auth/default/activation',
                self::HASH_PARAM_NAME => $model->activation_hash
            ], true);

            $isSent = Yii::$app->mailer
                ->compose('user_registeredInTheSystem', [
                    'login' => $model->email,
                    'password' => $password,
                    'activationUrl' => $activationUrl,
                ])
                ->setTo($model->email)
                ->setFrom([Yii::$app->params['adminEmail'] => Yii::$app->params['adminFrom']])
                ->setSubject(Yii::t('app', 'TIMS - Registration'))
                ->send();

            if (!$isSent) {
                throw new Exception(Yii::t('app', 'Email sending error occurred'));
            }
        }

        return true;
    }

    public function updateUser($userId, $validAttributes, $roleId)
    {
        $model = UserModel::findOne($userId);
        $model->attributes = $validAttributes;

        if($model->getRole() != $model->role) {
            $this->applyRole($roleId, $userId);
        }

        return $model->save();
    }

    /**
     * You have permission for user delete?
     * @param int $userId user id.
     * @return bool
     */
    public function haveDeletePermission($userId)
    {
        return (Yii::$app->user->getId() != $userId);
    }

    /**
     * User deletion processing:
     * @param int $id User id
     * @return bool
     * @throws \Exception
     */
    public function deleteUser($id)
    {
        $model = UserModel::find()->where('id =:id', [':id' => $id])->one();

        return $model->delete();
    }

    public static function getReportTypesByRole()
    {
        switch (Yii::$app->user->role->name) {
            case RoleName::ROLE_OPERATIONS_MANAGER:
                return [
                    ReportType::SUMMARY_REPORTS,
                    ReportType::OPERATIONAL_REPORTS,
                ];
            case RoleName::ROLE_ACCOUNTS_RECONCILIATION:
                return [
                    ReportType::SUMMARY_REPORTS,
                    ReportType::FINANCIAL_REPORTS,
                ];
            case RoleName::ROLE_ROOT_SUPERUSER:
                return [
                    ReportType::SUMMARY_REPORTS,
                    ReportType::OPERATIONAL_REPORTS,
                    ReportType::FINANCIAL_REPORTS,];
            default:
                return [];
        }
    }
}