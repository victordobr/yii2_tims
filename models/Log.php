<?php

namespace app\models;

class Log extends \yii\elasticsearch\ActiveRecord
{
    /**
    * @return array the list of attributes for this record
    */
    public function attributes()
    {
        // path mapping for '_id' is setup to field 'id'
        return ['id', 'email', 'ip_address', 'event_name', 'description' ,'created_at'];
    }
}