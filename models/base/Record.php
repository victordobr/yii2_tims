<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "Record".
 *
 * @property integer $id
 * @property string $lat
 * @property string $lng
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
 */
class Record extends \yii\db\ActiveRecord
{
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
            [['infraction_date', 'open_date', 'state_id', 'ticket_fee', 'ticket_payment_expire_date', 'status_id', 'created_at'], 'integer'],
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
}
