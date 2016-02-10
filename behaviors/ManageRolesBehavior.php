<?php
/**
 * Created by PhpStorm.
 * User: makhorin
 * Date: 03.09.15
 * Time: 13:52
 */

namespace app\behaviors;

use \Yii;
use \yii\base\Behavior;
use \yii\base\ModelEvent;
use \yii\db\ActiveRecord;
use \app\enums\UserType;

/**
 * Behavior that ensures that the password field is updated correctly.
 *
 * @property ActiveRecord $owner
 */
class ManageRolesBehavior extends Behavior
{

    public $userTypeAttribute = 'type';

    private $userTypeAttributeChanged = false;

    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'afterInsert',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterUpdate',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeUpdate',
        ];
    }

    /**
     * Invoked before saving the owner of this behavior.
     *
     * @param ModelEvent $event event instance.
     */
    public function afterInsert($event)
    {
        $this->applyRole();
    }

    public function beforeUpdate($event)
    {
        if($this->owner->isAttributeChanged($this->userTypeAttribute)) {
            $this->userTypeAttributeChanged = true;
        } else {
            $this->userTypeAttributeChanged = false;
        }
    }

    public function afterUpdate($event)
    {
        if ($this->userTypeAttributeChanged) {
            $this->applyRole();
        }
    }

    private function applyRole()
    {
        $roleId = UserType::roleData()[$this->owner->{$this->userTypeAttribute}];

        Yii::$app->user->applyRole($roleId, $this->owner->primaryKey);
    }
}