<?php
use app\enums\EventNames as Event;

return [
    Event::UPLOAD_SUCCESS => [
        ['\app\components\Record', 'setStatusCompleted'],
    ]
];