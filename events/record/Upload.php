<?php
namespace app\events\record;

class Upload extends \yii\base\Event
{
    public $user_id;
    public $record;
}