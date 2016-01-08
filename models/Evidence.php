<?php

namespace app\models;

use Yii;
use \yii\helpers\ArrayHelper;
use app\enums\EvidenceFileType;

/**
 * This is the model class for table "Evidence".
 */
class Evidence extends base\Evidence
{
    public $videoLprId;
    public $videoOverviewCameraId;
    public $imageLprId;
    public $imageOverviewCameraId;

    public $infractionDate;

    const SCENARIO_UPLOAD = 'upload';

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['license', 'state_id', 'lat', 'lng', 'infraction_date'], 'required'],
            [['videoLprId', 'videoOverviewCameraId', 'imageLprId', 'imageOverviewCameraId'], 'required', 'on' => self::SCENARIO_UPLOAD],
            ['infractionDate', 'date', 'format' => 'php:d/m/Y', 'timestampAttribute' => 'infraction_date'],
            [['case_id'], 'safe'],
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
        return ArrayHelper::merge(parent::attributeLabels(), [
            'license' => 'Tag number',
            'state_id' => 'Tag State',
            'videoLpr' => 'Video from *LPR',
            'videoOverviewCamera' => 'Video from Overview Camera',
            'imageLpr' => 'Still Image from *LPR',
            'imageOverviewCamera' => 'Still Image from Overview Camera',
            'lat' => 'Latitude',
            'lng' => 'Longitude',
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
        ];
    }

    /**
     * @inheritdoc
     */
    public function afterFind()
    {
        $paidToDate = \DateTime::createFromFormat(Yii::$app->params['date.unix.format'], $this->infraction_date);
        if ($paidToDate instanceof \DateTime) {
            $this->infraction_date = Yii::$app->formatter->asDate($paidToDate,
                'php:' . Yii::$app->params['date.code.format']);
        } else {
            $message = 'Invalid date format!';
            Yii::error($message);
        }
    }

    /**
     * @inheritdoc
     */
    public function afterValidate()
    {
        parent::afterValidate();

        if ($this->isAttributeChanged('infraction_date') && !$this->getIsNewRecord()) {
            $dateObject = \DateTime::createFromFormat(Yii::$app->params['date.code.format'], $this->infraction_date);
            if ($dateObject instanceof \DateTime) {
                $this->infraction_date = Yii::$app->formatter->asTimestamp($dateObject);
            } else {
                throw new \Exception('Invalid date format!');
            }
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFiles()
    {
        return $this->hasMany(File::className(), ['evidence_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVideoLpr()
    {
        return $this->hasOne(File::className(), ['evidence_id' => 'id'])->andWhere(['evidence_file_type' => EvidenceFileType::TYPE_VIDEO_LPR]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVideoOverviewCamera()
    {
        return $this->hasOne(File::className(), ['evidence_id' => 'id'])->andWhere(['evidence_file_type' => EvidenceFileType::TYPE_VIDEO_OVERVIEW_CAMERA]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImageLpr()
    {
        return $this->hasOne(File::className(), ['evidence_id' => 'id'])->andWhere(['evidence_file_type' => EvidenceFileType::TYPE_IMAGE_LPR]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImageOverviewCamera()
    {
        return $this->hasOne(File::className(), ['evidence_id' => 'id'])->andWhere(['evidence_file_type' => EvidenceFileType::TYPE_IMAGE_OVERVIEW_CAMERA]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }



}
