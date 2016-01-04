<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "PoliceCase".
 */
class PoliceCase extends base\PoliceCase
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status_id', 'created_at', 'open_date', 'infraction_date', 'officer_date', 'mailed_date', 'officer_id'], 'integer'],
            [['officer_pin'], 'string', 'max' => 250]
        ];
    }
}
