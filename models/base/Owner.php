<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "Owner".
 *
 * @property integer $id
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property string $address_1
 * @property string $address_2
 * @property string $city
 * @property integer $state_id
 * @property string $license
 * @property string $zip_code
 * @property string $email
 * @property string $phone
 * @property integer $vehicle_id
 * @property integer $vehicle_year
 * @property integer $vehicle_color_id
 * @property integer $created_at
 * @property integer $record_id
 *
 * @property Record $record
 */
class Owner extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Owner';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'address_1', 'city', 'state_id', 'license', 'zip_code', 'vehicle_id', 'vehicle_color_id', 'record_id'], 'required'],
            [['address_1', 'address_2'], 'string'],
            [['state_id', 'vehicle_id', 'vehicle_year', 'vehicle_color_id', 'created_at', 'record_id'], 'integer'],
            [['first_name', 'middle_name', 'last_name', 'city'], 'string', 'max' => 255],
            [['license', 'zip_code'], 'string', 'max' => 20],
            [['email', 'phone'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => 'First Name',
            'middle_name' => 'Middle Name',
            'last_name' => 'Last Name',
            'address_1' => 'Address 1',
            'address_2' => 'Address 2',
            'city' => 'City',
            'state_id' => 'State ID',
            'license' => 'License',
            'zip_code' => 'Zip Code',
            'email' => 'Email',
            'phone' => 'Phone',
            'vehicle_id' => 'Vehicle ID',
            'vehicle_year' => 'Vehicle Year',
            'vehicle_color_id' => 'Vehicle Color ID',
            'created_at' => 'Created At',
            'record_id' => 'Record ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecord()
    {
        return $this->hasOne(Record::className(), ['id' => 'record_id']);
    }
}
