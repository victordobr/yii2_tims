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
     * @param int $id
     * @param int $code
     * @param string $description
     * @return bool
     */
    public function deactivate($id, $code, $description)
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

            $parent = StatusHistory::find()->select('id')->where(['record_id' => $id])->one();

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

}