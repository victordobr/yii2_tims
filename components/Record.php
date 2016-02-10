<?php
namespace app\components;

use app\enums\CaseStage as Stage;
use app\models\StatusHistory;
use Yii;
use app\enums\Role;
use app\models\User;
use yii\base\Component;
use app\models\Reason;
use app\enums\CaseStatus as Status;
use app\events\record\Upload as UploadEvent;

/**
 * Record component to handle record statuses
 */
class Record extends Component
{
    /**
     * @param int $id record id
     * @param int $user_id user id
     * @param int $code reason code
     * @param string $description reason description
     * @return bool
     */
    public function requestDeactivation($id, $user_id, $code, $description)
    {
        $transaction = Yii::$app->getDb()->beginTransaction();
        try {
            $record = self::getRecord($id);
            if ($record->status_id == Status::AWAITING_DEACTIVATION) {
                throw new \Exception('Record has same status');
            }

            $record->setAttributes([
                'status_id' => Status::AWAITING_DEACTIVATION,
            ]);
            if (!$record->save(true, ['status_id'])) {
                throw new \Exception('Record status do not updated');
            }

            $history = new StatusHistory();
            $history->setAttributes([
                'record_id' => $id,
                'author_id' => $user_id,
                'status_code' => Status::AWAITING_DEACTIVATION,
                'created_at' => time()
            ]);
            if (!$history->save()) {
                throw new \Exception('StatusHistory do not created');
            }

            $reason = new Reason();
            $reason->setAttributes([
                'status_history_id' => $history->id,
                'code' => $code,
                'description' => $description,
            ]);
            if (!$reason->save()) {
                throw new \Exception('Reason do not saved');
            }

            $transaction->commit();
            return true;
        } catch (\Exception $e) {
            $transaction->rollBack();
            return false;
        }
    }

    /**
     * @param int $id record id
     * @param int $user_id user id
     * @return bool
     */
    public function approveDeactivate($id, $user_id)
    {
        $transaction = Yii::$app->getDb()->beginTransaction();
        try {
            $record = self::getRecord($id);
            if ($record->status_id == Status::DEACTIVATED_RECORD) {
                throw new \Exception('Record has same status');
            }

            $record->setAttributes([
                'status_id' => Status::DEACTIVATED_RECORD,
            ]);
            if (!$record->save(true, ['status_id'])) {
                throw new \Exception('Record status do not updated');
            }

            $history = new StatusHistory();
            $history->setAttributes([
                'record_id' => $id,
                'author_id' => $user_id,
                'status_code' => Status::DEACTIVATED_RECORD,
                'created_at' => time()
            ]);
            if (!$history->save()) {
                throw new \Exception('StatusHistory do not created');
            }

            $transaction->commit();
            return true;
        } catch (\Exception $e) {
            $transaction->rollBack();
            return false;
        }
    }

    /**
     * @param int $id record id
     * @param int $user_id user id
     * @param int $code reason code
     * @param string $description reason description
     * @return bool
     */
    public function rejectDeactivation($id, $user_id,  $code, $description)
    {
        $transaction = Yii::$app->getDb()->beginTransaction();
        try {
            $record = self::getRecord($id);
            if ($record->status_id == Status::FULL_COMPLETE) {
                throw new \Exception('Record has same status');
            }

            $record->setAttributes([
                'status_id' => Status::FULL_COMPLETE,
            ]);
            if (!$record->save(true, ['status_id'])) {
                throw new \Exception('Record status do not updated');
            }

            $history = new StatusHistory();
            $history->setAttributes([
                'record_id' => $id,
                'author_id' => $user_id,
                'status_code' => Status::FULL_COMPLETE,
                'created_at' => time()
            ]);
            if (!$history->save()) {
                throw new \Exception('StatusHistory do not created');
            }

            $reason = new Reason();
            $reason->setAttributes([
                'status_history_id' => $history->id,
                'code' => $code,
                'description' => $description,
            ]);
            if (!$reason->save()) {
//                var_dump($reason->getErrors()); die;
                throw new \Exception('Reason do not saved');
            }

            $transaction->commit();
            return true;
        } catch (\Exception $e) {
//            var_dump($e); die;
            $transaction->rollBack();
            return false;
        }
    }

    /**
     * @param int $id record id
     * @param int $user_id user id
     * @return bool
     */
    public function sendToPrint($id, $user_id)
    {
        $transaction = Yii::$app->getDb()->beginTransaction();
        try {
            $record = self::getRecord($id);
            if (in_array($record->status_id, [Status::PRINTED_P1, Status::PRINTED_P2])) {
                throw new \Exception('Record already printed');
            }

            switch ($record->status_id) {
                case Status::DMV_DATA_RETRIEVED_COMPLETE:
                case Status::DMV_DATA_RETRIEVED_INCOMPLETE:
                case Status::QC_BAD_P1:
                    $status_id = Status::PRINTED_P1;
                    break;
                case Status::QC_BAD_P2:
                case Status::OVERDUE_P1:
                    $status_id = Status::PRINTED_P2;
                    break;
                default:
                    throw new \Exception('Record has wrong status');
            }
            $record->setAttributes(['status_id' => $status_id]);
            if (!$record->save(true, ['status_id'])) {
                throw new \Exception('Record status do not updated');
            }

            $history = new StatusHistory();
            $history->setAttributes([
                'record_id' => $id,
                'author_id' => $user_id,
                'status_code' => $status_id,
                'created_at' => time()
            ]);
            if (!$history->save()) {
                throw new \Exception('StatusHistory do not created');
            }

            $transaction->commit();
            return true;
        } catch (\Exception $e) {
            $transaction->rollBack();
            return false;
        }
    }

    /**
     * @param int $id record id
     * @param int $user_id user id
     * @return bool
     * @throws \yii\db\Exception
     */
    public function confirmQc($id, $user_id)
    {
        $transaction = Yii::$app->getDb()->beginTransaction();
        try {
            $record = self::getRecord($id);
            if (in_array($record->status_id, [Status::QC_CONFIRMED_GOOD_P1, Status::QC_CONFIRMED_GOOD_P2])) {
                throw new \Exception('Record already confirmed');
            }

            switch ($record->status_id) {
                case Status::PRINTED_P1:
                    $status_id = Status::QC_CONFIRMED_GOOD_P1;
                    break;
                case Status::PRINTED_P2:
                    $status_id = Status::QC_CONFIRMED_GOOD_P2;
                    break;
                default:
                    throw new \Exception('Record has wrong status');
            }
            $record->setAttributes(['status_id' => $status_id]);
            if (!$record->save(true, ['status_id'])) {
                throw new \Exception('Record status do not updated');
            }

            $history = new StatusHistory();
            $history->setAttributes([
                'record_id' => $id,
                'author_id' => $user_id,
                'status_code' => $status_id,
                'created_at' => time()
            ]);
            if (!$history->save()) {
                throw new \Exception('StatusHistory do not created');
            }

            $transaction->commit();
            return true;
        } catch (\Exception $e) {
            $transaction->rollBack();
            return false;
        }
    }

    /**
     * @param int $id record id
     * @param int $user_id user id
     * @return bool
     * @throws \yii\db\Exception
     */
    public function rejectQc($id, $user_id)
    {
        $transaction = Yii::$app->getDb()->beginTransaction();
        try {
            $record = self::getRecord($id);
            if (in_array($record->status_id, [Status::QC_BAD_P1, Status::QC_BAD_P2])) {
                throw new \Exception('Record already rejected');
            }

            switch ($record->status_id) {
                case Status::PRINTED_P1:
                    $status_id = Status::QC_BAD_P1;
                    break;
                case Status::PRINTED_P2:
                    $status_id = Status::QC_BAD_P2;
                    break;
                default:
                    throw new \Exception('Record has wrong status');
            }
            $record->setAttributes(['status_id' => $status_id]);
            if (!$record->save(true, ['status_id'])) {
                throw new \Exception('Record status do not updated');
            }

            $history = new StatusHistory();
            $history->setAttributes([
                'record_id' => $id,
                'author_id' => $user_id,
                'status_code' => $status_id,
                'created_at' => time()
            ]);
            if (!$history->save()) {
                throw new \Exception('StatusHistory do not created');
            }

            $transaction->commit();
            return true;
        } catch (\Exception $e) {
            $transaction->rollBack();
            return false;
        }
    }

    /**
     * @return array
     */
    public static function getAvailableStatuses()
    {
        switch (true) {
            case User::hasRole(Role::ROLE_VIDEO_ANALYST):
                return [
                    Status::INCOMPLETE,
                    Status::COMPLETE,
                    Status::FULL_COMPLETE
                ];
            case User::hasRole(Role::ROLE_VIDEO_ANALYST_SUPERVISOR):
                return [
                    Status::INCOMPLETE,
                    Status::COMPLETE,
                    Status::FULL_COMPLETE,
                    Status::AWAITING_DEACTIVATION
                ];
            case User::hasRole(Role::ROLE_PRINT_OPERATOR):
                return [
                    Status::DMV_DATA_RETRIEVED_COMPLETE,
                    Status::DMV_DATA_RETRIEVED_INCOMPLETE,
                    Status::QC_BAD_P1,
                    Status::QC_BAD_P2,

                    Status::PRINTED_P1,
                    Status::PRINTED_P2,
                ];
            default:
                return [];
        }
    }

    /* event handlers */

    public static function setStatusCompleted(UploadEvent $event){
        $transaction = Yii::$app->getDb()->beginTransaction();
        try {
            $record = self::getRecord($event->record->id);
            if ($record->status_id == Status::COMPLETE) {
                throw new \Exception('Record has same status');
            }

            $record->setAttributes([
                'status_id' => Status::COMPLETE,
            ]);
            if (!$record->save(true, ['status_id'])) {
                throw new \Exception('Record status do not updated');
            }

            $history = new StatusHistory();
            $history->setAttributes([
                'record_id' => $record->id,
                'author_id' => $event->user_id,
                'status_code' => Status::COMPLETE,
                'created_at' => time()
            ]);
            if (!$history->save()) {
                throw new \Exception('StatusHistory do not created');
            }

            $transaction->commit();
            return true;
        } catch (\Exception $e) {
            $transaction->rollBack();
            return false;
        }
    }

    /* private methods */

    /**
     * @param int $id
     * @return null|\app\models\Record
     */
    private static function getRecord($id)
    {
        return \app\models\Record::findOne($id);
    }

}