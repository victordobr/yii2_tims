<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "VehicleModelYear".
 *
 * @property integer $id
 * @property integer $year
 * @property string $make
 * @property string $model
 */
class VehicleModelYear extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'VehicleModelYear';
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
}
