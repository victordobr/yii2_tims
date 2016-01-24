<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "User".
 *
 * @property integer $id
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
 * @property string $pre_name
 * @property string $address
 * @property string $zip_code
 * @property integer $state_id
 * @property integer $question_id
 * @property string $question_answer
 *
 * @property AuthAssignment[] $authAssignments
 * @property AuthItem[] $itemNames
 * @property Record[] $records
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
            [['is_active', 'created_at', 'last_login_at', 'logins_count', 'state_id', 'question_id'], 'integer'],
            [['email', 'password'], 'required'],
            [['email', 'password', 'recover_hash', 'activation_hash', 'first_name', 'middle_name', 'last_name', 'agency', 'address'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 50],
            [['pre_name'], 'string', 'max' => 3],
            [['zip_code'], 'string', 'max' => 16],
            [['question_answer'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
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
            'pre_name' => 'Pre Name',
            'address' => 'Address',
            'zip_code' => 'Zip Code',
            'state_id' => 'State ID',
            'question_id' => 'Question ID',
            'question_answer' => 'Question Answer',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthAssignments()
    {
        return $this->hasMany(AuthAssignment::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemNames()
    {
        return $this->hasMany(AuthItem::className(), ['name' => 'item_name'])->viaTable('AuthAssignment', ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecords()
    {
        return $this->hasMany(Record::className(), ['user_id' => 'id']);
    }
}
