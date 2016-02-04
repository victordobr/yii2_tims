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
        return ['id', 'email', 'ip_address', 'category', 'date'];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => 'yii\behaviors\TimestampBehavior',
                'createdAtAttribute' => 'date',
                'updatedAtAttribute' => null,
            ],
        ];
    }
//
//    public function getId()
//    {
//        return $this->_id;
//    }

//    public function getPrimaryKey($asArray = false)
//    {
//        return $this->_id;
//    }

}