<?php

namespace app\modules\frontend\controllers\records\action;

use app\models\User;
use app\modules\frontend\controllers\RecordsController;
use app\modules\frontend\models\form\ChangeDeterminationForm;
use Yii;
use yii\base\Action;
use app\modules\frontend\models\search\Record;
use yii\web\Response;
use yii\widgets\ActiveForm;

class SendToPrintAction extends Action
{
    public $ids;
    public $user_id;

    public function run()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $sent = [];
        foreach ($this->ids as $id) {
            !self::record()->sendToPrint($id, $this->user_id) || $sent[] = $id;
        }

        return $sent;
    }

    /**
     * @return \app\components\Record
     */
    private static function record()
    {
        return Yii::$app->record;
    }

}