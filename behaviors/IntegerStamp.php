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
class IntegerStamp extends Behavior
{

    public $useAfterFind = true;

    public $attributes = [];

    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_FIND => 'afterFind',
            ActiveRecord::EVENT_BEFORE_INSERT => 'beforeSave',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeSave'
        ];
    }

    /**
     * Invoked after querying the owner of this behavior.
     * @return bool
     *
     * @param ModelEvent $event event instance.
     */
    public function afterFind($event)
    {
        if (!$this->useAfterFind) {
            return true;
        }

        foreach ($this->attributes as $attribute) {
            if(empty($event->sender->{$attribute})) {
                continue;
            }
            $dateObject = \DateTime::createFromFormat(Yii::$app->params['date.unix.format'], $event->sender->{$attribute});
            if ($dateObject instanceof \DateTime) {
                $this->owner->{$attribute} = Yii::$app->formatter->asDate($dateObject,
                    'php:' . Yii::$app->params['date.code.format']);
            } else {
                $message = "afterFind: invalid format of field '{$attribute}': {$event->sender->{$attribute}}";
                Yii::error($message);
            }
        }

    }

    /**
     * Invoked before saving the owner of this behavior.
     * @param ModelEvent $event event instance.
     * @throws \Exception
     */
    public function beforeSave($event)
    {
        foreach ($this->attributes as $attribute) {
            if ($event->sender->isAttributeChanged($attribute) && !empty($event->sender->{$attribute})) {
                $dateObject = \DateTime::createFromFormat(Yii::$app->params['date.code.format'], $event->sender->{$attribute});
                if ($dateObject instanceof \DateTime) {
                    $this->owner->{$attribute} = Yii::$app->formatter->asTimestamp($dateObject);
                } else {
                    throw new \Exception('Invalid date format!');
                }
            }
        }
    }
}