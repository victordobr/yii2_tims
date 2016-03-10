<?php

namespace app\models\base;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "Citation".
 *
 * @property integer $id
 * @property integer $owner_id
 * @property string $location_code
 * @property string $citation_number
 * @property string $unique_passcode
 * @property integer $status
 * @property integer $created_at
 * @property integer $penalty
 * @property integer $fee
 * @property integer $expired_at
 *
 * @property Owner $owner
 */
class Citation extends ActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_PAID = 2;
    const STATUS_REQUESTED = 3;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Citation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['owner_id', 'created_at', 'penalty', 'fee', 'expired_at'], 'required'],
            [['owner_id', 'status', 'created_at', 'penalty', 'fee', 'expired_at'], 'integer'],
            [['location_code', 'citation_number', 'unique_passcode'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'owner_id' => 'Owner ID',
            'location_code' => 'Location Code',
            'citation_number' => 'Citation Number',
            'unique_passcode' => 'Unique Passcode',
            'is_active' => 'Is Active',
            'status' => 'Status',
            'created_at' => 'Created At',
            'penalty' => 'Penalty',
            'fee' => 'Fee',
            'expired_at' => 'Expired At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOwner()
    {
        return $this->hasOne(Owner::className(), ['id' => 'owner_id']);
    }
}
