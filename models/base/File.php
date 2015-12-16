<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "File".
 *
 * @property integer $id
 * @property integer $evidence_id
 * @property integer $type
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
     * @return \yii\db\ActiveQuery
     */
    public function getEvidence()
    {
        return $this->hasOne(Evidence::className(), ['id' => 'evidence_id']);
    }
}
