<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "User".
 *
 * @property integer $id
 * @property integer $type_id
 * @property integer $is_active
 * @property string $email
 * @property string $password
 * @property string $recover_hash
 * @property string $activation_hash
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property string $phone
 * @property string $agency
 * @property integer $created_at
 * @property integer $last_login_at
 * @property integer $logins_count
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'User';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type_id', 'email'], 'required'],
            [['type_id', 'is_active', 'created_at', 'last_login_at', 'logins_count'], 'integer'],
            [['email', 'password', 'recover_hash', 'activation_hash', 'first_name', 'middle_name', 'last_name', 'agency'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type_id' => 'Type ID',
            'is_active' => 'Is Active',
            'email' => 'Email',
            'password' => 'Password',
            'recover_hash' => 'Recover Hash',
            'activation_hash' => 'Activation Hash',
            'first_name' => 'First Name',
            'middle_name' => 'Middle Name',
            'last_name' => 'Last Name',
            'phone' => 'Phone',
            'agency' => 'Agency',
            'created_at' => 'Created At',
            'last_login_at' => 'Last Login At',
            'logins_count' => 'Logins Count',
        ];
    }
}
