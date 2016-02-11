<?php
namespace app\components;

use Yii;
use yii\base\Component;
use app\models\Log as LogModel;
use app\enums\LogEvent;

class Log extends Component
{
    /**
     * Inserts a document into the attribute values of this record.
     * @param $event
     * @param $event_params
     */
    public static function insertLog($event, $event_params)
    {
        $user = $event->identity->getAttributes();
        $log = new LogModel;
        $log->ip_address =  Yii::$app->getRequest()->getUserIP();
        $log->email = $user['email'];
        $log->event_name = $event_params['event_name'];
        $log->description = $event_params['description'];
        $log->created_at = time();
        $log->insert();
    }

    public static function login($event)
    {
        self::insertLog($event, [
            'event_name' => LogEvent::EVENT_LOGIN,
            'description' => 'Thsi is login!',
        ]);
    }

    public static function logout($event)
    {
        self::insertLog($event, [
            'event_name' => LogEvent::EVENT_LOGOUT,
            'description' => 'Thsi is logout!',
        ]);
    }
}
