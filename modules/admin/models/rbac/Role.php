<?php namespace app\modules\admin\models\rbac;

use Yii;

class Role extends \johnitvn\rbacplus\models\Role
{

    public function save()
    {
        if (!parent::save()) {
            return false;
        }

        $auth = Yii::$app->authManager;
        $role = $auth->getRole($this->item->name);

        if ($this->permissions != null && is_array($this->permissions)) {
            foreach ($auth->getPermissions() as $permission) {
                if (in_array($permission->name, $this->permissions)) {
                    $permission = $auth->getPermission($permission->name);
                    $auth->hasChild($role, $permission) || $auth->addChild($role, $permission);
                } else {
                    $auth->removeChild($role, $permission);
                }
            }
        }

        return true;
    }

    public function afterSave($insert, $changedAttributes)
    {
//        parent::afterSave($insert,$changedAttributes);
    }

    public static function find($name)
    {
        $authManager = Yii::$app->authManager;
        $item = $authManager->getRole($name);

        return new self($item);
    }

    public static function getRolePermissions($name)
    {
        return Yii::$app->authManager->getPermissionsByRole($name);
    }

}
