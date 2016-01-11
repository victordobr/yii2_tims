<?php

namespace app\models;

use Yii;

/**

 * @property integer $id
 * @property string $StatusName
 * @property string $StatusDescription

 * This is the model class for table "CaseStatus". It provides the status of the current case.
 * @author Vitalii Fokov
 *

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
            [['id','StatusName', 'StatusDescription'], 'required'],
            ['id', 'unique'],
            [['StatusDescription'], 'string'],
            [['StatusName'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'StatusName' => 'Status Name',
            'StatusDescription' => 'Status Description',
        ];
    }
}
