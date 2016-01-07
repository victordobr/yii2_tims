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
 * @property string $lat
 * @property string $lng
 * @property integer $state_id
 * @property integer $infraction_date
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
            [['case_id', 'license', 'lat', 'lng', 'state_id'], 'required'],
            [['case_id', 'user_id', 'state_id', 'infraction_date', 'created_at'], 'integer'],
            [['license'], 'string', 'max' => 250],
            [['lat', 'lng'], 'string', 'max' => 20],
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
            'lat' => 'Lat',
            'lng' => 'Lng',
            'state_id' => 'State ID',
            'infraction_date' => 'Infraction Date',
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
