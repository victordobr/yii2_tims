<?php

namespace app\models;

use Yii;
use \yii\helpers\ArrayHelper;

/**
 * This is the model class for table "Evidence".
 */
class Evidence extends base\Evidence
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['license', 'state_id'], 'required'],
            [['case_id'], 'safe'],
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
        return ArrayHelper::merge(parent::attributeLabels(), [
            'video_lpr' => 'Video from *LPR',
            'video_overview_camera' => 'Video from Overview Camera',
            'image_lpr' => 'Still Image from *LPR',
            'image_overview_camera' => 'Still Image from Overview Camera',
            'license' => 'Tag number',
            'state_id' => 'Tag State',
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

}
