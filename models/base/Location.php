<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "Location".
 *
 * @property integer $record_id
 * @property string $lat_dd
 * @property string $lat_dms
 * @property string $lat_ddm
 * @property string $lng_dd
 * @property string $lng_dms
 * @property string $lng_ddm
 * @property integer $created_at
 *
 * @property Record $record
 */
class Location extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Location';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lat_dd', 'lat_dms', 'lat_ddm', 'lng_dd', 'lng_dms', 'lng_ddm'], 'required'],
            [['lat_dd', 'lng_dd'], 'number'],
            [['created_at'], 'integer'],
            [['lat_dms', 'lat_ddm', 'lng_dms', 'lng_ddm'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'record_id' => 'Record ID',
            'lat_dd' => 'Lat Dd',
            'lat_dms' => 'Lat Dms',
            'lat_ddm' => 'Lat Ddm',
            'lng_dd' => 'Lng Dd',
            'lng_dms' => 'Lng Dms',
            'lng_ddm' => 'Lng Ddm',
            'created_at' => 'Created At',
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
