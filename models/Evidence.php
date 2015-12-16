<?php

namespace app\models;

use Yii;
use \yii\helpers\ArrayHelper;

/**
 * This is the model class for table "Evidence".
 */
class Evidence extends base\Evidence
{
    public $fileIds = [];
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['license', 'state_id'], 'required'],
            [['case_id'], 'safe'],
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
