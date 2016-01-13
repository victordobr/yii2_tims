<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;

class Owner extends base\Owner
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'address_1', 'city', 'state_id', 'license', 'zip_code', 'vehicle_id', 'vehicle_color_id'], 'required'],
            [['address_1', 'address_2'], 'string'],
            [['state_id', 'vehicle_id', 'vehicle_year', 'vehicle_color_id'], 'integer'],
            [['vehicle_year'],'number', 'min' => 1970, 'max' => 2070],
            [['license', 'email'], 'unique'],
            [['created_at'], 'date'],
            [['first_name', 'middle_name', 'last_name', 'city'], 'string', 'max' => 255],
            [['license', 'zip_code'], 'string', 'max' => 20],
            [['email', 'phone'], 'string', 'max' => 50],
            ['email', 'email'],
            [
                'phone',
                'yii\validators\RegularExpressionValidator',
                'pattern' => '/^\d{10}$/',
                'message' => Yii::t('app',
                    'Incorrect phone number format. Enter correct number, for example: 7809449360')
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'updatedAtAttribute' => false,
            ],
            [
                'class' => 'app\behaviors\IntegerStamp',
                'attributes' => ['created_at'],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'address_1' => 'Address Line 1',
            'address_2' => 'Address Line 2',
            'state_id' => 'State',
            'license' => 'Tag',
            'vehicle_id' => 'Vehicle model',
            'vehicle_color_id' => 'Vehicle Color',
            'created_at' => 'Created',
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVehicle()
    {
        return $this->hasOne(Vehicle::className(), ['id' => 'vehicle_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStates()
    {
        return $this->hasOne(Vehicle::className(), ['id' => 'vehicle_id']);
    }

    /**
     * Returns owner full name.
     * @return \yii\db\ActiveQuery
     */
    public function getFullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
