<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "File".
 */
class File extends base\File
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['evidence_id', 'type', 'created_at'], 'integer'],
            [['type', 'url'], 'required'],
            [['url'], 'string', 'max' => 250]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'evidence_id' => 'Evidence ID',
            'type' => 'Type',
            'url' => 'Url',
            'created_at' => 'Created At',
        ];
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
