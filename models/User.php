<?php
namespace app\models;

use \Yii;
use \yii\helpers\ArrayHelper;
use \yii\db\Query;
use \yii\behaviors\TimestampBehavior;
use \app\behaviors\PasswordAttributeBehavior;
/**
 * Model for table User
 * @package app\models
 */
class User extends base\User
{
    const STATUS_ACTIVE = 1;
    const STATUS_NOT_ACTIVE = 0;
//    const SCENARIO_REGISTER = 'register';
    const SCENARIO_USER_MANUAL_CREATE = 'userManualCreate';

    const PRE_NAME_MR = 'mr';
    const PRE_NAME_MRS = 'mrs';
    private static $pre_names = [
        self::PRE_NAME_MR => 'Mr',
        self::PRE_NAME_MRS => 'Mrs',
    ];

    /** @var string repeat password. */
    public $repeatPassword;


    /**
     * @inheritdoc
     */
    public function afterFind()
    {
        $this->role = $this->getRole();
    }

    /**
     * @inheritdoc
     */
    public function beforeValidate()
    {
        if ($this->getIsNewRecord() && $this->scenario == self::SCENARIO_USER_MANUAL_CREATE) {
            $this->password = Yii::$app->user->generatePasswordHash($this->password);
        }

        return parent::beforeValidate();
    }

    public function getRole()
    {
        return Yii::$app->user->getRoleNameByUser($this->primaryKey);
    }

    public function attributes()
    {
        return array_merge(parent::attributes(),
            ['role']
        );
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            ['repeatPassword', 'compare', 'compareAttribute' => 'password'],
            ['is_active', 'default', 'value' => '0'],
            ['email', 'email'],
            ['email', 'unique'],
            [
                'phone',
                'yii\validators\RegularExpressionValidator',
                'pattern' => '/^\d{10}$/',
                'message' => Yii::t('app',
                    'Incorrect phone number format. Enter correct number, for example: 7809449360')
            ],
            ['logins_count', 'default', 'value' => 0],
            ['pre_name', 'in', 'range' => self::getPreNameList(true)],
            [['address'], 'string', 'max' => 50],
            [['agency'], 'string', 'max' => 255],
            [['zip_code'], 'string', 'max' => 16],
            [['state_id'], 'integer'],
            [['role'], 'safe'],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return ArrayHelper::merge(parent::scenarios(), [
            self::SCENARIO_USER_MANUAL_CREATE => array_keys($this->getAttributes())
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'repeatPassword' => Yii::t('app', 'Repeat Password'),
            'role' => Yii::t('app', 'Role'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
//            [
//                'class' => PasswordAttributeBehavior::className(),
//                'attribute' => 'password',
//            ],
            [
                'class' => TimestampBehavior::className(),
                'updatedAtAttribute' => false,
            ],
        ];
    }

    /**
     * Returns list of users' full names
     * @param int $limit records count
     * @return array list of users' names
     */
    public static function getUserList($limit = null)
    {
        $query = new Query();
        $query->select(['id', 'text' => "CONCAT(`u`.`first_name`,' ', `u`.`last_name`)"])->from(['u' => 'User']);

        if (isset($limit)) {
            $query->limit($limit);
        }

        $query->each();
        $command = $query->createCommand();

        return $command->queryAll();
    }

    /**
     * Returns list users for autocomplete widget.
     * @return array list users for autocomplete widget.
     */
    public static function getIdUsersAutocomplete()
    {
        return Yii::$app->db->createCommand("SELECT CONCAT('#', id, ' ', first_name, ' ', last_name) FROM `User`")->queryColumn();
    }

    /**
     * Returns list users for select2 widget.
     * @return array Array of type id => value for Select2 widget
     */
    public static function getSelect2Source()
    {
        $raw =  Yii::$app->db->createCommand("SELECT id, CONCAT(first_name, ' ', last_name) as fullName FROM `User`")->queryAll();
        return ArrayHelper::map($raw, 'id', 'fullName');
    }

    /**
     * Returns user full name.
     * @return string user full name.
     */
    public function getFullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * @param bool $only_values
     * @return array
     */
    public static function getPreNameList($only_values = false)
    {
        return $only_values ? array_keys(self::$pre_names) : self::$pre_names;
    }

}
