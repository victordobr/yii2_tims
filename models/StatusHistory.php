<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "StatusHistory".
 *
 * @property integer $id
 * @property integer $record_id
 * @property integer $author_id
 * @property integer $status_code
 * @property integer $created_at
 * @property integer $expired_at
 *
 * @property Reason $reason
 * @property CaseStatus $statusCode
 * @property Record $record
 * @property User $author
 */
class StatusHistory extends \yii\db\ActiveRecord
{
    private $reason;

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
            [['record_id', 'author_id', 'status_code', 'created_at'], 'required'],
            [['record_id', 'author_id', 'status_code', 'created_at', 'expired_at'], 'integer']
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
            'author_id' => 'Author ID',
            'status_code' => 'Status Code',
            'created_at' => 'Created At',
            'expired_at' => 'Expired At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReason()
    {
        return $this->hasOne(Reason::className(), ['status_history_id' => 'id']);
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
