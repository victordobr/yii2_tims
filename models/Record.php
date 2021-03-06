<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use app\enums\EvidenceFileType;

/**
 * This is the model class for table "Record".
 */
class Record extends base\Record
{
    public $videoLprId;
    public $videoOverviewCameraId;
    public $imageLprId;
    public $imageOverviewCameraId;

    const SCENARIO_UPLOAD = 'upload';

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lat', 'lng', 'infraction_date', 'state_id', 'license', 'user_id'], 'required'],
            [['videoLprId', 'videoOverviewCameraId', 'imageLprId', 'imageOverviewCameraId'], 'required', 'on' => self::SCENARIO_UPLOAD],
            [['state_id', 'user_id', 'ticket_fee', 'status_id', 'created_at'], 'integer'],
            [['infraction_date', 'open_date', 'ticket_payment_expire_date'], 'date'],
            [['comments', 'user_plea_request'], 'string'],
            [['lat', 'lng'], 'string', 'max' => 20],
            [['license'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'lat' => 'Lat',
            'lng' => 'Lng',
            'infraction_date' => 'Infraction Date',
            'open_date' => 'Open Date',
            'state_id' => 'State ID',
            'license' => 'License',
            'user_id' => 'User ID',
            'ticket_fee' => 'Ticket Fee',
            'ticket_payment_expire_date' => 'Ticket Payment Expire Date',
            'comments' => 'Comments',
            'user_plea_request' => 'User Plea Request',
            'status_id' => 'Status ID',
            'created_at' => 'Created At',
        ]);
    }

    public function beforeValidate()
    {
        if($this->isNewRecord){
            $this->user_id = yii::$app->user->id;
        }
        return parent::beforeValidate();
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => 'yii\behaviors\TimestampBehavior',
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => null,
            ],
            [
                'class' => 'app\behaviors\IntegerStamp',
                'attributes' => ['infraction_date', 'open_date', 'ticket_payment_expire_date'],
            ],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFiles()
    {
        return $this->hasMany(File::className(), ['record_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVideoLpr()
    {
        return $this->hasOne(File::className(), ['record_id' => 'id'])->andWhere(['record_file_type' => EvidenceFileType::TYPE_VIDEO_LPR]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVideoOverviewCamera()
    {
        return $this->hasOne(File::className(), ['record_id' => 'id'])->andWhere(['record_file_type' => EvidenceFileType::TYPE_VIDEO_OVERVIEW_CAMERA]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImageLpr()
    {
        return $this->hasOne(File::className(), ['record_id' => 'id'])->andWhere(['record_file_type' => EvidenceFileType::TYPE_IMAGE_LPR]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImageOverviewCamera()
    {
        return $this->hasOne(File::className(), ['record_id' => 'id'])->andWhere(['record_file_type' => EvidenceFileType::TYPE_IMAGE_OVERVIEW_CAMERA]);
    }
}
