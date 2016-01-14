<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "File".
 *
 * @property integer $id
 * @property integer $evidence_id
 * @property integer $file_type
 * @property integer $evidence_file_type
 * @property string $mime_type
 * @property string $url
 * @property integer $created_at
 *
 * @property Evidence $evidence
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
            [['evidence_id', 'file_type', 'evidence_file_type', 'created_at'], 'integer'],
            [['file_type', 'evidence_file_type', 'mime_type', 'url'], 'required'],
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
            'evidence_id' => 'Evidence ID',
            'file_type' => 'File Type',
            'evidence_file_type' => 'Evidence File Type',
            'mime_type' => 'Mime Type',
            'url' => 'Url',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvidence()
    {
        return $this->hasOne(Evidence::className(), ['id' => 'evidence_id']);
    }
}
