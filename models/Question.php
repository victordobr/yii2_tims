<?php

namespace app\models;

use Yii;

/**
 *
 * Question class implements the component to handle security questions functional.
 * @author Vitalii Fokov

 * This is the model class for table "Question".
 *
 * @property integer $id
 * @property string $text
 */
class Question extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Question';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['text'], 'required'],
            [['text'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'text' => 'Text',
        ];
    }
}
