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

/**
 * Behavior that ensures that the password field is updated correctly.
 *
 * @property ActiveRecord $owner
 */
class PasswordAttributeBehavior extends Behavior
{
    /**
     * @var string name of the password attribute.
     */
    public $attribute = 'password';
    /**
     * @var string holds the current password, used to detect whether the password has been changed.
     */
    protected $_passwordHash;

    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_FIND => 'afterFind',
            ActiveRecord::EVENT_BEFORE_INSERT => 'beforeSave',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeSave',
        ];
    }

    /**
     * Compares the given password against the owner's password hash.
     *
     * @param string $password password to validate.
     * @return boolean whether the password matches the one on record.
     */
    public function validatePassword($password)
    {
        return $this->getPasswordHasher()->validatePassword($password, $this->owner->{$this->attribute});
    }

    /**
     * Invoked after querying the owner of this behavior.
     *
     * @param ModelEvent $event event instance.
     */
    public function afterFind($event)
    {
        $this->_passwordHash = $event->sender->{$this->attribute};
    }

    /**
     * Invoked before saving the owner of this behavior.
     *
     * @param ModelEvent $event event instance.
     */
    public function beforeSave($event)
    {
        $password = $event->sender->{$this->attribute};
        if ($password !== $this->_passwordHash && $password !== '') {
            $passwordHash = $this->getPasswordHasher()->generatePasswordHash($password);
            $this->_passwordHash = $this->owner->{$this->attribute} = $passwordHash;
        }
    }

    /**
     * @return PasswordHasherInterface
     */
    protected function getPasswordHasher()
    {
        return Yii::$app->user;
    }
}