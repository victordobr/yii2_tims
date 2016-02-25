<?php

namespace app\models;

use app\helpers\GpsHelper;
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
            [['lat_dms', 'lng_dms'], 'string', 'max' => 20],
            [
                'lat_ddm',
                'yii\validators\RegularExpressionValidator',
                'pattern' => '/^(\d{1,3}.\d{1,3}.\d{1,9}[nsNS])$/',
                'message' => Yii::t('app',
                    'Incorrect latitude format. Enter correct value, for example: 49.2.66200N')
            ],
            [
                'lng_ddm',
                'yii\validators\RegularExpressionValidator',
                'pattern' => '/^(\d{1,3}.\d{1,3}.\d{1,9}[ewEW])$/',
                'message' => Yii::t('app',
                    'Incorrect longitude format. Enter correct value, for example: 122.21.73060W')
            ],
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

    /**
     * This method convert coordinates at the beginning of inserting or updating a record.
     * @param bool $insert whether this method called while inserting a record.
     * @return bool whether the insertion or updating should continue.
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->lat_dd = Yii::$app->formatter->asDecimalCoord($this->lat_ddm);
            $this->lng_dd = Yii::$app->formatter->asDecimalCoord($this->lng_ddm);
            $this->lat_dms = Yii::$app->formatter->asDMS($this->lat_ddm);
            $this->lng_dms = Yii::$app->formatter->asDMS($this->lng_ddm);
            return true;
        }
        else {
            return false;
        }
    }
}
