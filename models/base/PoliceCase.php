<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "PoliceCase".
 *
 * @property integer $id
 * @property integer $status_id
 * @property integer $created_at
 * @property integer $open_date
 * @property integer $officer_date
 * @property integer $mailed_date
 * @property string $officer_pin
 * @property integer $officer_id
 *
 * @property Evidence $evidence
 */
class PoliceCase extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'PoliceCase';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status_id', 'created_at', 'open_date', 'officer_date', 'mailed_date', 'officer_id'], 'integer'],
            [['officer_pin'], 'string', 'max' => 250]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Case#',
            'status_id' => 'Status ID',
            'created_at' => 'Created At',
            'open_date' => 'Open Date',
            'officer_date' => 'Officer Date',
            'mailed_date' => 'Mailed Date',
            'officer_pin' => 'Officer Pin',
            'officer_id' => 'Officer ID',
        ];
    }
}
