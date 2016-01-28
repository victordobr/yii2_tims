<?php
namespace app\components;

use app\models\StatusHistory;
use Yii;
use app\enums\Role;
use app\models\User;
use yii\base\Component;
use app\models\Reason;
use app\enums\CaseStatus as Status;

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

            $reason = new Reason();
            $reason->setAttributes([
                'code' => $code,
                'description' => $description,
            ]);
            if (!$reason->save()) {
                throw new \Exception('Reason do not saved');
            }

            $record->setAttributes([
                'status_id' => Status::AWAITING_DEACTIVATION,
            ]);
            if (!$record->save()) {
                throw new \Exception('Record status do not updated');
            }

            $parent = self::getParentHistory($id);

            $history = new StatusHistory();
            $history->setAttributes([
                'record_id' => $id,
                'author_id' => Yii::$app->user->id,
                'status_code' => Status::AWAITING_DEACTIVATION,
                'reason_code' => $reason->code,
                'created_at' => time()
            ]);
            if (!is_null($parent)) {
                $history->setAttribute('parent_id', $parent->id);
            }
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
            if (!$record->save()) {
                throw new \Exception('Record status do not updated');
            }

            $parent = self::getParentHistory($id);

            $history = new StatusHistory();
            $history->setAttributes([
                'record_id' => $id,
                'author_id' => Yii::$app->user->id,
                'status_code' => Status::DEACTIVATED_RECORD,
                'created_at' => time()
            ]);
            if (!is_null($parent)) {
                $history->setAttribute('parent_id', $parent->id);
            }
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

                $reason = new Reason();
                $reason->setAttributes([
                    'code' => $code,
                    'description' => $description,
                ]);
                if (!$reason->save()) {
                    throw new \Exception('Reason do not saved');
                }


            $record->setAttributes([
                'status_id' => Status::COMPLETE,
            ]);
            if (!$record->save()) {
                throw new \Exception('Record status do not updated');
            }

            $parent = self::getParentHistory($id);

            $history = new StatusHistory();
            $history->setAttributes([
                'record_id' => $id,
                'author_id' => Yii::$app->user->id,
                'status_code' => Status::COMPLETE,
                'reason_code' => $reason->code,
                'created_at' => time()
            ]);
            if (!is_null($parent)) {
                $history->setAttribute('parent_id', $parent->id);
            }
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
                return [Status::INCOMPLETE, Status::COMPLETE, Status::FULL_COMPLETE];
            case User::hasRole(Role::ROLE_VIDEO_ANALYST_SUPERVISOR):
                return [Status::INCOMPLETE, Status::COMPLETE, Status::FULL_COMPLETE, Status::AWAITING_DEACTIVATION];
            default:
                return [];
        }
    }

    /**
     * @param $record_id
     * @return array|null|StatusHistory
     */
    private static function getParentHistory($record_id)
    {
        return StatusHistory::find()->select('id')->where(['record_id' => $record_id])->orderBy(['id' => 'DESC'])->one();
    }

    /**
     * @param int $id
     * @return null|\app\models\Record
     */
    private function getRecord($id)
    {
        return \app\models\Record::findOne($id);
    }

}