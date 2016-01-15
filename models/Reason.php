<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Reason".
 *
 * @property integer $id
 * @property integer $code
 * @property string $description
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
            [['code'], 'integer'],
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
            'id' => 'ID',
            'code' => 'Code',
            'description' => 'Description',
        ];
    }
}
