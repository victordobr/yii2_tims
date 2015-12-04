<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "Evidence".
 *
 * @property integer $id
 * @property integer $case_id
 * @property integer $user_id
 * @property string $video_lpr
 * @property string $video_overview_camera
 * @property string $image_lpr
 * @property string $image_overview_camera
 * @property string $license
 * @property integer $state_id
 * @property integer $created_at
 *
 * @property PoliceCase $case
 * @property User $user
 */
class Evidence extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Evidence';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['case_id', 'license', 'state_id'], 'required'],
            [['case_id', 'user_id', 'state_id', 'created_at'], 'integer'],
            [['video_lpr', 'video_overview_camera', 'image_lpr', 'image_overview_camera', 'license'], 'string', 'max' => 250],
            [['case_id'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'case_id' => 'Case ID',
            'user_id' => 'User ID',
            'video_lpr' => 'Video Lpr',
            'video_overview_camera' => 'Video Overview Camera',
            'image_lpr' => 'Image Lpr',
            'image_overview_camera' => 'Image Overview Camera',
            'license' => 'License',
            'state_id' => 'State ID',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCase()
    {
        return $this->hasOne(PoliceCase::className(), ['id' => 'case_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
