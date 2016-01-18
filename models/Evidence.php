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
//            ['infractionDate', 'date', 'format' => 'php:d/m/Y', 'timestampAttribute' => 'infraction_date'],
            [['infraction_date', 'created_at'], 'date'],
            [['case_id'], 'safe'],
            [['case_id', 'user_id', 'state_id'], 'integer'],
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
            'lat' => 'GPS Latitude',
            'lng' => 'GPS Longitude',
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
                'attributes' => ['infraction_date'],
            ],
        ];
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

    /**
     * @return string
     */
    public function renderInfractionDate()
    {
        $infraction_date = Yii::$app->formatter->asDatetime($this->infraction_date, 'php:d-m-Y');
        $elapsed = $this->toElapsedString(Yii::$app->formatter->asTimestamp(Yii::$app->formatter->asDatetime($this->infraction_date, 'php:d/m/Y')));

        return sprintf('%s (%s)', $infraction_date, $elapsed);
    }

    /**
     * @param $timestamp
     * @return string
     */
    public function toElapsedString($timestamp)
    {
        $time = time() - $timestamp;

        if ($time < 1) {
            return '0 seconds';
        }

        $a = [
            365 * 24 * 60 * 60 => 'year',
            30 * 24 * 60 * 60 => 'month',
            24 * 60 * 60 => 'day',
            60 * 60 => 'hour',
            60 => 'minute',
            1 => 'second'
        ];
        $a_plural = ['year' => 'years',
            'month' => 'months',
            'day' => 'days',
            'hour' => 'hours',
            'minute' => 'minutes',
            'second' => 'seconds'
        ];

        foreach ($a as $secs => $str) {
            $d = $time / $secs;
            if ($d >= 1) {
                $r = round($d);
                return $r . ' ' . ($r > 1 ? $a_plural[$str] : $str) . ' ago';
            }
        }
    }

}
