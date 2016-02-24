<?php

namespace app\modules\frontend\controllers\records\action;

use Yii;
use yii\base\Action;
use yii\web\Response;

class RejectQcAction extends Action
{
    public $ids;
    public $user_id;

    public function run()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $rejected = [];
        foreach ($this->ids as $id) {
            !self::record()->rejectQc($id, $this->user_id) || $rejected[] = $id;
        }

        return $rejected;
    }

    /**
     * @return \app\components\Record
     */
    private static function record()
    {
        return Yii::$app->record;
    }

}