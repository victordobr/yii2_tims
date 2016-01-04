<?php
namespace app\models\forms;

use \Yii;
use \yii\base\Model;
use \app\models\User as UserModel;

/**
 * Password form for validate.
 * @package app\models
 */
class Password extends Model
{
    /** @var string old password. */
    public $old;

    /** @var string new password. */
    public $new;

    /** @var string repeat new password. */
    public $repeat;

    /** @var int user id. */
    public $userId;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['old', 'new', 'repeat'], 'required'],
            ['old', 'findPasswords'],
            [['new', 'repeat'], 'string', 'max' => 255, 'min' => 6],
            ['repeat', 'compare', 'compareAttribute' => 'new'],
        ];
    }

    /**
     * Old password validator.
     * @param string $attribute
     * @param array $params
     */
    public function findPasswords($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = UserModel::findOne($this->userId);
            if (!$user || !$user->validatePassword($this->old)) {
                $this->addError($attribute, Yii::t('app', 'Old password is incorrect'));
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'old'    => Yii::t('app', 'Old Password'),
            'new'    => Yii::t('app', 'New Password'),
            'repeat' => Yii::t('app', 'Repeat New Password'),
        ];
    }
}