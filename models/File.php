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
            [['record_id', 'file_type', 'record_file_type', 'created_at'], 'integer'],
            [['file_type', 'url'], 'required'],
            [['mime_type'], 'string', 'max' => 50],
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
            'record_id' => 'Record ID',
            'file_type' => 'File Type',
            'mime_type' => 'Mime Type',
            'record_file_type' => 'Record File Type',
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
