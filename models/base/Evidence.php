<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "Evidence".
 *
 * @property integer $id
 * @property integer $case_id
 * @property integer $user_id
 * @property string $license
 * @property integer $state_id
 * @property integer $created_at
 *
 * @property PoliceCase $case
 * @property User $user
 * @property File[] $files
 */
class Evidence extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Evidence';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['case_id', 'license', 'state_id'], 'required'],
            [['case_id', 'user_id', 'state_id', 'created_at'], 'integer'],
            [['license'], 'string', 'max' => 250],
            [['case_id'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'case_id' => 'Case ID',
            'user_id' => 'User ID',
            'license' => 'License',
            'state_id' => 'State ID',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCase()
    {
        return $this->hasOne(PoliceCase::className(), ['id' => 'case_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFiles()
    {
        return $this->hasMany(File::className(), ['evidence_id' => 'id']);
    }
}
