<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use app\enums\EvidenceFileType;

/**
 * This is the model class for table "Record".
 */
class Record extends base\Record
{
    public $videoLprId;
    public $videoOverviewCameraId;
    public $imageLprId;
    public $imageOverviewCameraId;

    private $statusHistory;

    const SCENARIO_UPLOAD = 'upload';

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lat', 'lng', 'infraction_date', 'state_id', 'license', 'user_id'], 'required'],
            [['videoLprId', 'videoOverviewCameraId', 'imageLprId', 'imageOverviewCameraId'], 'required', 'on' => self::SCENARIO_UPLOAD],
            [['state_id', 'user_id', 'ticket_fee', 'status_id'], 'integer'],
            [['infraction_date', 'open_date', 'ticket_payment_expire_date'], 'date', 'format' => 'MM/dd/yy'],
            [['comments', 'user_plea_request'], 'string'],
            [['lat', 'lng'], 'string', 'max' => 20],
            [
                ['lat', 'lng'],
                'yii\validators\RegularExpressionValidator',
                'pattern' => '(([0-9]{1,3})[º ]+([0-9]{1,3})[\' ]+([0-9]{1,3})[. ]+([0-9]{1,3})[" ]+([nsewNSEW]))',
                'message' => Yii::t('app',
                    'Incorrect format. Enter correct number, for example: 36º 13\' 49.378" E')
            ],
            [['license'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'lat' => 'Latitude',
            'lng' => 'Longitude',
            'open_date' => 'Case Open date',
            'state_id' => 'State',
            'user_id' => 'Upload By',
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
                'attributes' => ['infraction_date', 'open_date', 'ticket_payment_expire_date'],
            ],
        ];
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
        return $this->hasOne(Owner::className(), ['record_id' => 'id']);
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

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getStatusHistory()
    {
        return $this->hasMany(StatusHistory::className(), ['record_id' => 'id'])
            ->orderBy(['stage_id' => SORT_ASC, 'created_at' => SORT_ASC]);
    }

}
