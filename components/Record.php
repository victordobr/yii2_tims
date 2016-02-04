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
     * @param int $code reason code
     * @param string $description reason description
     * @return bool
     */
    public function requestDeactivation($id, $code, $description)
    {
        $transaction = Yii::$app->getDb()->beginTransaction();
        try {
            $record = $this->getRecord($id);
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
                'author_id' => Yii::$app->user->id,
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
     * @return bool
     */
    public function approveDeactivate($id)
    {
        $transaction = Yii::$app->getDb()->beginTransaction();
        try {
            $record = $this->getRecord($id);
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
                'author_id' => Yii::$app->user->id,
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
     * @param int $code reason code
     * @param string $description reason description
     * @return bool
     */
    public function rejectDeactivation($id, $code, $description)
    {
        $transaction = Yii::$app->getDb()->beginTransaction();
        try {
            $record = $this->getRecord($id);
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
                'record_id' => $id,
                'author_id' => Yii::$app->user->id,
                'status_code' => Status::COMPLETE,
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
     * @return array
     */
    public static function getAvailableStatuses()
    {
        switch (true) {
            case User::hasRole(Role::ROLE_VIDEO_ANALYST):
                return [Status::INCOMPLETE, Status::COMPLETE, Status::FULL_COMPLETE];
            case User::hasRole(Role::ROLE_VIDEO_ANALYST_SUPERVISOR):
                return [Status::INCOMPLETE, Status::COMPLETE, Status::FULL_COMPLETE, Status::AWAITING_DEACTIVATION];
            default:
                return [];
        }
    }

    /**
     * @param int $id
     * @return null|\app\models\Record
     */
    private function getRecord($id)
    {
        return \app\models\Record::findOne($id);
    }

    /* event handlers */

    public function saveInfractionDate(UploadEvent $event)
    {
        $history = StatusHistory::findOne([
            'record_id' => $event->record->id,
            'stage_id' => Stage::SET_INFRACTION_DATE
        ]);
        if (!$history) {
            $history = new StatusHistory();
            $history->setAttributes([
                'stage_id' => Stage::SET_INFRACTION_DATE,
                'record_id' => $event->record->id,
            ]);
        }
        $history->setAttributes([
            'author_id' => $event->user_id,
            'created_at' => $event->record->infraction_date
        ]);
        if (!$history->save()) {
            //todo: log errors
        }
    }

    public function saveDateUpload(UploadEvent $event)
    {
        $history = new StatusHistory();
        $history->setAttributes([
            'stage_id' => Stage::DATA_UPLOADED,
            'record_id' => $event->record->id,
            'author_id' => $event->user_id,
            'status_code' => Status::FULL_COMPLETE,
            'created_at' => time()
        ]);
        if (!$history->save()) {
            //todo: log errors
        }
    }

}