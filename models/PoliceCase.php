<?php

namespace app\models;

use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "PoliceCase".
 */
class PoliceCase extends base\PoliceCase
{
    const STATUS_INCOMPLETE_ID = 1010;
    const STATUS_COMPLETE_ID = 1020;
    const STATUS_FULL_COMPLETE_ID = 1021;

    private $status;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status_id', 'officer_id'], 'integer'],
            [['created_at', 'open_date', 'officer_date', 'mailed_date'], 'date'],
            [['officer_pin'], 'string', 'max' => 250],
        ];
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
                'attributes' => ['open_date', 'officer_date', 'mailed_date'],
            ],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvidence()
    {
        return $this->hasOne(Evidence::className(), ['case_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCaseStatus()
    {
        return $this->hasOne(CaseStatus::className(), ['id' => 'status_id']);
    }

    public function getStatus()
    {
        return $this->hasOne(CaseStatus::className(), ['id' => 'status_id']);
    }

    public function deactivate()
    {
        return $this->updateAttributes(['status_id' => self::STATUS_COMPLETE_ID]);
    }

}
