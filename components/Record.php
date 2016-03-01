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
    const ONE_DAY_HOURS = 24;
    const TWO_DAY_HOURS = 48;
    const THREE_DAY_HOURS = 72;

    const CLASS_WARNING = 'warning';
    const CLASS_DANGER = 'danger';

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
     * @param int $user_id
     * @return bool
     * @throws \yii\db\Exception
     */
    public function view($id, $user_id)
    {
        $transaction = Yii::$app->getDb()->beginTransaction();
        try {
            $record = self::getRecord($id);
            if ($record->status_id == Status::VIEWED_RECORD) {
                throw new \Exception('Record has same status');
            }

            $record->setAttributes([
                'status_id' => Status::VIEWED_RECORD,
            ]);
            if (!$record->save(true, ['status_id'])) {
                throw new \Exception('Record status do not updated');
            }

            $history = new StatusHistory();
            $history->setAttributes([
                'record_id' => $id,
                'author_id' => $user_id,
                'status_code' => Status::VIEWED_RECORD,
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
     * @param int $id
     * @param int $user_id
     * @param int $status_id
     * @return bool
     * @throws \yii\db\Exception
     */
    public function updateStatus($id, $user_id, $status_id)
    {
        $transaction = Yii::$app->getDb()->beginTransaction();
        try {
            $record = self::getRecord($id);
            if (!Status::exists($status_id)) {
                throw new \Exception('Wrong status code');
            }
            if ($record->status_id == $status_id) {
                throw new \Exception('Record has same status');
            }

            $record->setAttributes([
                'status_id' => $status_id,
            ]);
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
     * @param int $user_id
     * @return bool
     * @throws \yii\db\Exception
     */
    public function retrieveDMVData($id, $user_id)
    {
        $transaction = Yii::$app->getDb()->beginTransaction();
        try {
            $record = self::getRecord($id);
            if ($record->status_id == Status::DMV_DATA_RETRIEVED_COMPLETE) {
                throw new \Exception('Record has same status');
            }

            $record->setAttributes([
                'status_id' => Status::DMV_DATA_RETRIEVED_COMPLETE,
                'dmv_received_at' => time(),
            ]);
            if (!$record->save(true, ['status_id', 'dmv_received_at'])) {
                throw new \Exception('Record status do not updated');
            }

            $history = new StatusHistory();
            $history->setAttributes([
                'record_id' => $id,
                'author_id' => $user_id,
                'status_code' => Status::DMV_DATA_RETRIEVED_COMPLETE,
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

    public function approveViolation($id, $user_id)
    {
        $transaction = Yii::$app->getDb()->beginTransaction();
        try {
            $record = self::getRecord($id);
            if ($record->status_id == Status::APPROVED_RECORD) {
                throw new \Exception('Record has same status');
            }

            $record->setAttributes([
                'status_id' => Status::APPROVED_RECORD,
                'approved_at' => time(),
            ]);
            if (!$record->save(true, ['status_id', 'approved_at'])) {
                throw new \Exception('Record status do not updated');
            }

            $history = new StatusHistory();
            $history->setAttributes([
                'record_id' => $id,
                'author_id' => $user_id,
                'status_code' => Status::APPROVED_RECORD,
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

    public function rejectViolation($id, $user_id,  $code, $description)
    {
        $transaction = Yii::$app->getDb()->beginTransaction();
        try {
            $record = self::getRecord($id);
            if ($record->status_id == Status::REJECTED_RECORD) {
                throw new \Exception('Record has same status');
            }

            $record->setAttributes([
                'status_id' => Status::REJECTED_RECORD,
            ]);
            if (!$record->save(true, ['status_id'])) {
                throw new \Exception('Record status do not updated');
            }

            $history = new StatusHistory();
            $history->setAttributes([
                'record_id' => $id,
                'author_id' => $user_id,
                'status_code' => Status::REJECTED_RECORD,
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
            $record->setAttributes([
                'status_id' => $status_id,
                'printed_at' => time()
            ]);
            if (!$record->save(true, ['status_id', 'printed_at'])) {
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
            $record->setAttributes([
                'status_id' => $status_id,
                'qc_verified_at' => time()
            ]);
            if (!$record->save(true, ['status_id', 'qc_verified_at'])) {
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
        switch (Yii::$app->user->role->name)
        {
            case Role::ROLE_VIDEO_ANALYST:
                return [
                    Status::INCOMPLETE,
                    Status::COMPLETE,
                    Status::FULL_COMPLETE,
                    Status::VIEWED_RECORD,
                ];
            case Role::ROLE_SYSTEM_ADMINISTRATOR:
                return [
                    Status::INCOMPLETE,
                    Status::COMPLETE,
                    Status::FULL_COMPLETE,
                    Status::AWAITING_DEACTIVATION
                ];
            case Role::ROLE_PRINT_OPERATOR:
                return [
                    Status::DMV_DATA_RETRIEVED_COMPLETE,
                    Status::DMV_DATA_RETRIEVED_INCOMPLETE,
                    Status::OVERDUE_P1,

                    Status::PRINTED_P1,
                    Status::PRINTED_P2,
                ];
            case Role::ROLE_POLICE_OFFICER:
                return [
                    Status::COMPLETE,
                    Status::FULL_COMPLETE,
                    Status::VIEWED_RECORD
                ];
            case Role::ROLE_ROOT_SUPERUSER:
                return [
                    Status::INCOMPLETE,
                    Status::COMPLETE,
                    Status::FULL_COMPLETE,
                    Status::VIEWED_RECORD,
                    Status::AWAITING_DEACTIVATION,
                    Status::DEACTIVATED_RECORD,
                    Status::APPROVED_RECORD,
                    Status::APPROVED_RECORD_2021,
                    Status::QUERY_SUBMITTED,
                    Status::REJECTED_RECORD,
                    Status::REJECTED_RECORD_2031,
                    Status::DMV_DATA_RETRIEVED_COMPLETE,
                    Status::DMV_DATA_RETRIEVED_INCOMPLETE,
                    Status::DMV_DATA_RETRIEVED_INCOMPLETE_CRITICAL,
                    Status::DMV_DATA_CORRUPT,
                    Status::DMV_DATA_NOT_AVAILABLE,
                    Status::DMV_DATA_MULTIPLE_MATCH,
                    Status::PRINTED_P1,
                    Status::PRINTED_P2,
                    Status::VIEWED_RECORD_P1,
                    Status::VIEWED_RECORD_P2,
                    Status::PRINTED_P1,
                    Status::PAID,
                    Status::QC_BAD_P1,
                    Status::QC_BAD_P2,
                    Status::QC_CONFIRMED_GOOD_P1,
                    Status::QC_CONFIRMED_GOOD_P2,
                ];
        }

        return [];
    }

    /* event handlers */

    public static function setStatusCompleted(UploadEvent $event) {
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

    /**
     * Check timeout
     * @param integer $created_at time of created record
     * @param integer $settings_interval time interval in hours (has a default value)
     * @return bool
     */
    private static function checkTimeout($created_at, $settings_interval = self::ONE_DAY_HOURS)
    {
        $deactivate_time = $created_at + $settings_interval * 3600;
        return $deactivate_time > time();
    }

    /**
     * Check deactivate timeout
     * Option to deactivate only available within 24 hours of initial record submission to TIMS
     * (this interval is configurable in TIMS settings)
     * @param integer $created_at created date
     * @return bool
     */
    public static function checkDeactivateTimeout($created_at, $interval = self::ONE_DAY_HOURS)
    {
        return self::checkTimeout($created_at, $interval);
    }

    /**
     * Check timeout of the change determination options
     * Option to change determination only available within 24 hours of approval/rejection
     * (this interval is configurable in TIMS settings).
     * @param integer $created_at created date
     * @return bool
     */
    public static function checkChangeDeterminationTimeout($created_at, $interval = self::ONE_DAY_HOURS)
    {
        return self::checkTimeout($created_at, $interval);
    }

    /**
     * Get class name by timeout
     * @param integer $created_at
     * @param integer $amber_timeout time in hours
     * @param integer $red_timeout time in hours
     * @return string class name
     */
    public static function getRowClassByTimeout($created_at, $amber_timeout, $red_timeout) {
        switch(true) {
            case time() >= $created_at + $red_timeout * 3600:
                return self::CLASS_DANGER;
            case time() > $created_at + $amber_timeout * 3600:
                return self::CLASS_WARNING;
        }
    }

    /**
     * Get class name of Review table
     * @param integer $created_at
     * @param integer $amber_timeout
     * @param integer $red_timeout
     * @return string
     */
    public static function getReviewRowClass($created_at, $amber_timeout = self::TWO_DAY_HOURS, $red_timeout = self::THREE_DAY_HOURS) {
        return self::getRowClassByTimeout($created_at, $amber_timeout, $red_timeout);
    }

    /**
     * Get class name of Print table
     * @param integer $created_at
     * @param integer $amber_timeout
     * @param integer $red_timeout
     * @return string
     */
    public static function getPrintRowClass($created_at, $amber_timeout = self::ONE_DAY_HOURS, $red_timeout = self::TWO_DAY_HOURS) {
        return self::getRowClassByTimeout($created_at, $amber_timeout, $red_timeout);
    }

}