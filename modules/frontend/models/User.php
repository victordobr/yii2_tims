<?php
namespace app\modules\frontend\models;

use \Yii;
use \app\behaviors\PasswordAttributeBehavior;
/**
 * Model for table User
 * @package app\models
 */
class User extends \app\models\User
{
    /** @var string repeat password. */
    public $repeatPassword;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['repeatPassword', 'compare', 'compareAttribute' => 'password'],
            [['question_id'], 'integer'],
            [['officer_pin'], 'string', 'max' => 6],
            [['question_answer'], 'string', 'max' => 200],
            [['role'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => PasswordAttributeBehavior::className(),
                'attribute' => 'password',
            ],
        ];
    }

}
