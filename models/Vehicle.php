<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "Vehicle".
 *
 * @property integer $id
 * @property integer $year
 * @property string $make
 * @property string $model
 */
class Vehicle extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Vehicle';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['year', 'model'], 'required'],
            [['year'], 'integer'],
            [['make', 'model'], 'string', 'max' => 50],
            [['year', 'make', 'model'], 'unique', 'targetAttribute' => ['year', 'make', 'model'], 'message' => 'The combination of Year, Make and Model has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'year' => 'Year',
            'make' => 'Make',
            'model' => 'Model',
        ];
    }

    /**
     * Get list of Vehicle models
     *
     *
     * @return array $array - List of Vehicle models
     */
    public static function getVehicleList()
    {
        $cars = self::find()->orderBy('make, model')->all();
        $array = ArrayHelper::map($cars, 'id', 'makeModel');

        return $array;
    }

    /**
     * Get joined fields: make and model.
     * @return string
     */
    public function getMakeModel()
    {
        return $this->make . ' ' . $this->model;
    }
}
