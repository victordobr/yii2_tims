<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Citation".
 *
 * @property integer $id
 * @property integer $record_id
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
class Citation extends \app\models\base\Citation
{

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
            'status' => 'Status',
            'created_at' => 'Created At',
            'penalty' => 'Penalty',
            'fee' => 'Fee',
            'expired_at' => 'Expired At',
        ];
    }

    public function beforeValidate()
    {
        if($this->isNewRecord){
            $this->citation_number = $this->location_code . sprintf("-%06d", $this->record_id);
            $this->expired_at = $this->calcExpiredDate();
            $this->unique_passcode = substr(md5(rand()), 0, 12);
        }

        return parent::beforeValidate();
    }

    /**
     * @return int
     */
    private function calcExpiredDate()
    {
        switch ($this->status) {
            case self::STATUS_INACTIVE:
                return strtotime('+36 months', $this->created_at);
            case self::STATUS_REQUESTED:
                return strtotime('+12 months', $this->created_at);
            case self::STATUS_PAID:
                return strtotime('+3 months', $this->created_at);
        }
    }

    /**
     * @param bool $sign
     * @param int $mode
     * @return string
     */
    public function getTotalPayment($sign = false, $mode = PHP_ROUND_HALF_UP)
    {
        return (!$sign ? '' : '$') . round($this->penalty * (100 + $this->fee) / 100, $mode);
    }

    /**
     * @param int $mode
     * @return float
     */
    public function getProcessingFee($mode = PHP_ROUND_HALF_UP)
    {
        return round($this->penalty * $this->fee / 100, $mode);
    }

    // relations

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOwner()
    {
        return $this->hasOne(Owner::className(), ['id' => 'owner_id']);
    }

}
