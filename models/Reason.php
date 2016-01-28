<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Reason".
 *
 * @property integer $code
 * @property string $description
 *
 * @property StatusHistory[] $statusHistories
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
            [['description'], 'required'],
            [['description'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'code' => 'Code',
            'description' => 'Description',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatusHistories()
    {
        return $this->hasMany(StatusHistory::className(), ['reason_code' => 'code']);
    }
}
