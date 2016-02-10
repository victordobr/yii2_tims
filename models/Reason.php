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
class Reason extends base\Reason
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code'], 'required'],
            [['code'], 'integer'],
            [['description'], 'string'],
            [['status_history_id'], 'safe'],
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
