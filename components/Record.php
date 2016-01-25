<?php
namespace app\components;

use Yii;
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
                'reason_id' => $reason->id,
            ]);
            if (!$record->save()) {
                throw new \Exception('Record status do not updated');
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
     * @return null|\app\models\Record
     */
    private function getRecord($id)
    {
        return \app\models\Record::findOne($id);
    }

}