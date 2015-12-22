<?php

namespace app\models;

use Yii;
use \yii\helpers\ArrayHelper;
use app\enums\EvidenceFileType;

/**
 * This is the model class for table "Evidence".
 */
class Evidence extends base\Evidence
{
    public $videoLprId;
    public $videoOverviewCameraId;
    public $imageLprId;
    public $imageOverviewCameraId;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['license', 'state_id', 'videoLprId', 'videoOverviewCameraId', 'imageLprId', 'imageOverviewCameraId'], 'required'],
            [['case_id', 'userEmail'], 'safe'],
            [['case_id', 'user_id', 'state_id', 'created_at'], 'integer'],
            [['license'], 'string', 'max' => 250],
            [['case_id'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'license' => 'Tag number',
            'state_id' => 'Tag State',

            'videoLpr' => 'Video from *LPR',
            'videoOverviewCamera' => 'Video from Overview Camera',
            'imageLpr' => 'Still Image from *LPR',
            'imageOverviewCamera' => 'Still Image from Overview Camera',
            'userEmail' => 'User Email'
        ]);
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFiles()
    {
        return $this->hasMany(File::className(), ['evidence_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVideoLpr()
    {
        return $this->hasOne(File::className(), ['evidence_id' => 'id'])->andWhere(['evidence_file_type' => EvidenceFileType::TYPE_VIDEO_LPR]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVideoOverviewCamera()
    {
        return $this->hasOne(File::className(), ['evidence_id' => 'id'])->andWhere(['evidence_file_type' => EvidenceFileType::TYPE_VIDEO_OVERVIEW_CAMERA]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImageLpr()
    {
        return $this->hasOne(File::className(), ['evidence_id' => 'id'])->andWhere(['evidence_file_type' => EvidenceFileType::TYPE_IMAGE_LPR]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImageOverviewCamera()
    {
        return $this->hasOne(File::className(), ['evidence_id' => 'id'])->andWhere(['evidence_file_type' => EvidenceFileType::TYPE_IMAGE_OVERVIEW_CAMERA]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }



}
