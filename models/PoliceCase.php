<?php

namespace app\models;

use app\enums\CaseStatus as Status;
use Yii;

/**
 * This is the model class for table "PoliceCase".
 */
class PoliceCase extends base\PoliceCase
{
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(CaseStatus::className(), ['id' => 'status_id']);
    }

    /**
     * @return int
     */
    public function deactivate()
    {
        return $this->updateAttributes(['status_id' => Status::COMPLETE]);
    }

    /**
     * @return string
     */
    public function renderDateOpened()
    {
        return Yii::$app->formatter->asDatetime($this->open_date);
    }

}
