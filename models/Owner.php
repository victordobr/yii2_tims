<?php

namespace app\models;

use app\models\base\Citation;
use Yii;
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;
use app\enums\States;

class Owner extends base\Owner
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'address_1', 'city', 'state_id', 'license', 'zip_code'], 'required'],
            [['address_1', 'address_2'], 'string'],
            [['record_id', 'state_id'], 'integer'],
            [['email'], 'unique'],
//            [['created_at'], 'date'],
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
            'fullName' => 'Full name',
            'stateName' => 'State',
            'vehicleName' => 'Vehicle',
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVehicle()
    {
        return $this->hasOne(Vehicle::className(), ['owner_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCitation()
    {
        return $this->hasOne(Citation::className(), ['owner_id' => 'id']);
    }

    /**
     * Returns owner state name. Getting state from States Enum.
     * @return \yii\db\ActiveQuery
     */
    public function getStateName()
    {
        return States::labelById($this->state_id);
    }

    /**
     * Returns owner vehicle name. Composed from make and model.
     * @return \yii\db\ActiveQuery
     */
    public function getVehicleName()
    {
        return $this->vehicle->makeModel;
    }


}
