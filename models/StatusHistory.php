<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "StatusHistory".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property integer $record_id
 * @property integer $author_id
 * @property integer $status_code
 * @property integer $reason_code
 * @property integer $created_at
 * @property integer $expired_at
 *
 * @property CaseStatus $statusCode
 * @property Reason $reasonCode
 * @property Record $record
 * @property User $author
 */
class StatusHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'StatusHistory';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'record_id', 'author_id', 'status_code', 'created_at', 'expired_at'], 'integer'],
            [['record_id', 'author_id', 'status_code', 'created_at'], 'required'],
            [['reason_code'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent ID',
            'record_id' => 'Record ID',
            'author_id' => 'Author ID',
            'status_code' => 'Status Code',
            'reason_code' => 'Reason Code',
            'created_at' => 'Created At',
            'expired_at' => 'Expired At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatusCode()
    {
        return $this->hasOne(CaseStatus::className(), ['id' => 'status_code']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReasonCode()
    {
        return $this->hasOne(Reason::className(), ['code' => 'reason_code']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecord()
    {
        return $this->hasOne(Record::className(), ['id' => 'record_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'author_id']);
    }
}
