<?php

namespace app\models;

use app\base\Module;
use Yii;
use yii\helpers\ArrayHelper;
use app\enums\EvidenceFileType;
use app\enums\CaseStatus as Status;

/**
 * This is the model class for table "Record".
 */
class Record extends base\Record
{
    public $videoLprId;
    public $videoOverviewCameraId;
    public $imageLprId;
    public $imageOverviewCameraId;

    const SCENARIO_UPLOAD = 'upload';

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['infraction_date', 'state_id', 'license', 'bus_number'], 'required'],
            [['videoLprId', 'videoOverviewCameraId', 'imageLprId', 'imageOverviewCameraId'], 'required', 'on' => self::SCENARIO_UPLOAD],
            [['state_id', 'owner_id', 'ticket_fee', 'status_id', 'approved_at', 'dmv_received_at', 'printed_at', 'qc_verified_at'], 'integer'],
            [['infraction_date'],  'filter', 'filter' => function ($value) {
                // TODO
//                if(time($value)<=time() && time($value)>=mktime(0, 0, 0, date("m"), date("d")-10, date("Y"))) {

                    return $value;
//                }
            }, 'on' => self::SCENARIO_UPLOAD],
            [['infraction_date', 'ticket_payment_expire_date'], 'date', 'format' => 'MM/dd/yy'],

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
        return ArrayHelper::merge(parent::attributeLabels(), [
            'open_date' => 'Case Open date',
            'state_id' => 'State',
            'status_id' => 'Status',
            'statusName' => 'Status name',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => 'yii\behaviors\TimestampBehavior',
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => null,
            ],
            [
                'class' => 'app\behaviors\IntegerStamp',
                'attributes' => ['infraction_date', 'ticket_payment_expire_date'],
            ],
        ];
    }

    /**
     * @return bool
     */
    public function beforeValidate()
    {
        $this->updateCaseTimeline();

        return parent::beforeValidate();
    }

    /**
     * @return void
     */
    public function updateCaseTimeline()
    {
        switch(true)
        {
            case $this->status_id < Status::UPLOAD_HOLD:
                $this->setAttributes([
                    'approved_at' => null,
                    'dmv_received_at' => null,
                    'printed_at' => null,
                    'qc_verified_at' => null,
                ]);
                break;
            case $this->status_id < Status::REVIEW_HOLD:
                if ($this->status_id == Status::APPROVED_RECORD) {
                    $this->setAttributes([
                        'approved_at' => time(),
                    ]);
                } elseif (in_array($this->status_id, [Status::VIEWED_RECORD, Status::REJECTED_RECORD])) {
                    $this->setAttributes([
                        'approved_at' => null,
                    ]);
                }

                $this->setAttributes([
                    'dmv_received_at' => null,
                    'printed_at' => null,
                    'qc_verified_at' => null,
                ]);
                break;
            case $this->status_id < Status::DMV_DATA_HOLD:
                if (Status::isDmvDataRequested($this->status_id)) {
                    $this->setAttributes([
                        'dmv_received_at' => null,
                    ]);
                } elseif (Status::isDmvDataRetrieved($this->status_id)) {
                    $this->setAttributes([
                        'dmv_received_at' => time(),
                    ]);
                } else {
                    $this->setAttributes([
                        'dmv_received_at' => 0,
                    ]);
                }


                $this->setAttributes([
                    'printed_at' => null,
                    'qc_verified_at' => null,
                ]);
                break;
            case Status::isPrinted($this->status_id):
                $this->setAttributes([
                    'printed_at' => time(),
                    'qc_verified_at' => null,
                ]);
                break;
            case Status::isQcConfirmed($this->status_id):
                $this->setAttributes([
                    'qc_verified_at' => time(),
                ]);
                break;
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['record_id' => 'id']);
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
    public function getOwner()
    {
        return $this->hasOne(Owner::className(), ['id' => 'owner_id']);
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCaseStatus()
    {
        return $this->hasOne(CaseStatus::className(), ['id' => 'status_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatusName()
    {
        return $this->caseStatus->name;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(CaseStatus::className(), ['id' => 'status_id']);
    }

    /**
     * @return $this
     */
    public function getStatusHistory()
    {
        return $this->hasOne(StatusHistory::className(), ['record_id' => 'id', 'status_code' => 'status_id'])
            ->orderBy([StatusHistory::tableName() . '.created_at' => SORT_DESC])
            ->groupBy('record_id');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocation()
    {
        return $this->hasOne(Location::className(), ['record_id' => 'id']);
    }

}
