<?php
namespace app\components;

use Yii;
use yii\base\Component;
use app\models\Log as LogModel;
use app\enums\LogEventNames;
use app\enums\CaseStatus;
use app\models\User;
use app\models\StatusHistory;
use yii\base\Exception;

class Log extends Component
{
    /**
     * Inserts a document into elasticsearch database.
     * @param array $params user email, event name and description
     * @return boolean
     */
    public static function insertLog($params)
    {
        $log = new LogModel;
        $log->ip_address =  Yii::$app->getRequest()->getUserIP();
        $log->email = $params['email'];
        $log->event_name = $params['event_name'];
        $log->description = $params['description'];
        $log->created_at = time();
        try {
            $log->insert();
        }
        catch (Exception $e) {
            return false;
        }
    }

    public static function login($event)
    {
        $user = $event->identity->getAttributes();
        self::insertLog([
            'email' => $user['email'],
            'event_name' => LogEventNames::EVENT_LOGIN,
            'description' => Yii::t('app','User {username} is login', [
                'username' => $user['email'],
            ]),
        ]);
    }

    public static function logout($event)
    {
        $user = $event->identity->getAttributes();
        self::insertLog([
            'email' => $user['email'],
            'event_name' => LogEventNames::EVENT_LOGOUT,
            'description' => Yii::t('app','User {username} is logout', [
                'username' => $user['email'],
            ]),
        ]);
    }

    public static function statusHistory($event)
    {
        $listStatus = CaseStatus::listMainText();
        $user = User::find()->where(['id' => $event->sender->author_id])->one();
        if ($event->sender->status_code == 1020) {
            $description = Yii::t('app','Record #{record_id}: changed status to \'{status}\', by user {username}', [
                'record_id' => $event->sender->record_id,
                'status' => $listStatus[$event->sender->status_code],
                'username' => $user->email,
            ]);
        }
        else {
            $statusHistory = StatusHistory::find()
                ->where(['author_id' => $event->sender->author_id, 'record_id' => $event->sender->record_id])
                ->addOrderBy(['created_at' => SORT_DESC])
                ->one();
            $description = Yii::t('app','Record #{record_id}: changed status from \'{status1}\' to \'{status2}\' , by user {username}', [
                'record_id' => $event->sender->record_id,
                'status1' => $listStatus[$statusHistory->status_code],
                'status2' => $listStatus[$event->sender->status_code],
                'username' => $user->email,
            ]);
        }

        self::insertLog([
            'email' => $user->email,
            'event_name' => LogEventNames::EVENT_STATUS_HISTORY,
            'description' => $description,
        ]);
    }
}
