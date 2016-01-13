<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "CaseStatus".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 */
class CaseStatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'CaseStatus';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'name', 'description'], 'required'],
            [['id'], 'integer'],
            ['id', 'unique'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
        ];
    }
}
