<?php

namespace app\models\base;

use Yii;
use yii\db\ActiveRecord;
use app\enums\EvidenceFileType;

/**
 * This is the model class for table "Record".
 *
 * @property integer $id
 * @property integer $infraction_date
 * @property integer $open_date
 * @property integer $state_id
 * @property string $license
 * @property integer $ticket_fee
 * @property integer $ticket_payment_expire_date
 * @property string $comments
 * @property string $user_plea_request
 * @property integer $status_id
 * @property integer $created_at
 * @property integer $approved_at
 * @property integer $dmv_received_at
 * @property integer $printed_at
 * @property integer $qc_verified_at
 */
class Record extends ActiveRecord
{
    public $author;
    public $elapsedTime;
    public $latitude;
    public $longitude;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Record';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['infraction_date', 'open_date', 'state_id', 'license', 'bus_number'], 'required'],
            [['infraction_date', 'open_date', 'state_id', 'ticket_fee', 'ticket_payment_expire_date', 'status_id', 'created_at', 'approved_at', 'dmv_received_at', 'printed_at', 'qc_verified_at'], 'integer'],
            [['comments', 'user_plea_request'], 'string'],
            [['license'], 'string', 'max' => 250],
            [['bus_number'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'infraction_date' => 'Infraction Date',
            'open_date' => 'Open Date',
            'state_id' => 'State ID',
            'license' => 'License',
            'ticket_fee' => 'Ticket Fee',
            'ticket_payment_expire_date' => 'Ticket Payment Expire Date',
            'comments' => 'Comments',
            'user_plea_request' => 'User Plea Request',
            'status_id' => 'Status ID',
            'created_at' => 'Created At',
            'approved_at' => 'Approved At',
            'dmv_received_at' => 'DMV Data retrieved',
            'printed_at' => 'Printed At',
            'qc_verified_at' => 'QC verified At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOwner()
    {
        return $this->hasOne(Owner::className(), ['record_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocation()
    {
        return $this->hasOne(Location::className(), ['record_id' => 'id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['record_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatusHistories()
    {
        return $this->hasMany(StatusHistory::className(), ['record_id' => 'id']);
    }

    /**
     * @return $this
     */
    public function getStatusHistory()
    {
        return $this->hasOne(StatusHistory::className(), ['record_id' => 'id', 'status_code' => 'status_id'])
            ->orderBy([StatusHistory::tableName() . '.created_at' => SORT_DESC]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFiles()
    {
        return $this->hasMany(File::className(), ['record_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVideoLpr()
    {
        return $this->hasOne(File::className(), ['record_id' => 'id'])->andWhere(['record_file_type' => EvidenceFileType::TYPE_VIDEO_LPR]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVideoOverviewCamera()
    {
        return $this->hasOne(File::className(), ['record_id' => 'id'])->andWhere(['record_file_type' => EvidenceFileType::TYPE_VIDEO_OVERVIEW_CAMERA]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImageLpr()
    {
        return $this->hasOne(File::className(), ['record_id' => 'id'])->andWhere(['record_file_type' => EvidenceFileType::TYPE_IMAGE_LPR]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImageOverviewCamera()
    {
        return $this->hasOne(File::className(), ['record_id' => 'id'])->andWhere(['record_file_type' => EvidenceFileType::TYPE_IMAGE_OVERVIEW_CAMERA]);
    }
}
