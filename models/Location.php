<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

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
class Location extends base\Location
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lat_ddm', 'lng_ddm'], 'required'],
            [['lat_dd', 'lng_dd'], 'number'],
            [['created_at'], 'integer'],
            [['lat_dms', 'lat_ddm', 'lng_dms', 'lng_ddm'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'lat_ddm' => 'Latitude',
            'lng_ddm' => 'Longitude',
        ]);
    }
}
