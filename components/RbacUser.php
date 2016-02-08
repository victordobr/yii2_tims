<?php
/**
 * Created by PhpStorm.
 * User: smile
 * Date: 26.11.15
 * Time: 20:03
 */

namespace app\components;


use Yii;
use yii\base\InvalidConfigException;
use \app\models\User as UserModel;
use \yii\base\Exception;
use yii\rbac\Role;
use yii\rbac\Permission;

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

    public function initParams($userId)
    {
        $roles = $this->authManager->getRolesByUser($userId);
        $this->_role = array_shift($roles);
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

}