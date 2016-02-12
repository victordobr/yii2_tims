<?php
use app\enums\EventNames as Event;
use yii\web\User;
use yii\db\ActiveRecord;
use app\models\StatusHistory;

return [
    Event::UPLOAD_SUCCESS => [
        ['\app\components\Record', 'setStatusCompleted'],
    ],

    ActiveRecord::EVENT_BEFORE_INSERT => [
        StatusHistory::className(),
        ['\app\components\Log', 'statusHistory'],
    ],
    User::EVENT_BEFORE_LOGIN => [
        User::className(),
        ['\app\components\Log', 'login'],
    ],
    User::EVENT_AFTER_LOGOUT => [
        User::className(),
        ['\app\components\Log', 'logout'],
    ],
];