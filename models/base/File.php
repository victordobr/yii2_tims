<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "File".
 *
 * @property integer $id
 * @property integer $record_id
 * @property integer $file_type
 * @property integer $record_file_type
 * @property string $mime_type
 * @property string $url
 * @property integer $created_at
 *
 * @property Evidence $record
 */
class File extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'File';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['record_id', 'file_type', 'record_file_type', 'created_at'], 'integer'],
            [['file_type', 'record_file_type', 'mime_type', 'url'], 'required'],
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
            'record_file_type' => 'Record File Type',
            'mime_type' => 'Mime Type',
            'url' => 'Url',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecord()
    {
        return $this->hasOne(Evidence::className(), ['id' => 'record_id']);
    }
}
