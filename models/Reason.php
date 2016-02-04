<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Reason".
 *
 * @property integer $status_history_id
 * @property integer $code
 * @property string $description
 *
 * @property StatusHistory $statusHistory
 */
class Reason extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Reason';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status_history_id', 'code', 'description'], 'required'],
            [['code'], 'integer'],
            [['description'], 'string'],
            ['status_history_id', 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'status_history_id' => 'Status History ID',
            'code' => 'Code',
            'description' => 'Description',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatusHistory()
    {
        return $this->hasOne(StatusHistory::className(), ['id' => 'status_history_id']);
    }
}
