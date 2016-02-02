<?php
/**
 * Created by PhpStorm.
 * User: smile
 * Date: 26.11.15
 * Time: 20:03
 */

namespace app\components;

use Yii;
use yii\base\Component;
use app\models\Log as LogModel;

class Log extends Component
{
    const EVENT_LOGIN = 'login';
    const EVENT_LOGOUT = 'logout';

    public static function createLog($event, $category)
    {
        $user = $event->identity->getAttributes();
        $log = new LogModel;
        $log->ip_address =  Yii::$app->getRequest()->getUserIP();
        $log->email = $user['email'];
        $log->category = $category;
        $log->date = time();
        $log->insert();
    }

    public static function login($event){
        self::createLog($event, self::EVENT_LOGIN);
    }

    public static function logout($event){
        self::createLog($event, self::EVENT_LOGOUT);
    }
}
