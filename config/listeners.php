<?php
use app\enums\EventNames as Event;
use \yii\web\User;

return [
    Event::UPLOAD_SUCCESS => [
        ['\app\components\Record', 'setStatusCompleted'],
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