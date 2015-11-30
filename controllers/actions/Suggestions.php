<?php

namespace app\controllers\actions;

use \Yii;
use \yii\base\Action;
use \yii\web\Response;
/**
 * Universal Action to get suggestions for typeahead widgets
 * @inheritdoc
 * @package app\helpers
 * @version 1.0
 * @copyright (c) 2014-2015 KFOSoftware Team <kfosoftware@gmail.com>
 */
class Suggestions extends Action
{
    /**
     * @inheritdoc
     */
    public function run($code ,$field, $value)
    {
        $service = Yii::$app->get('service|common');
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $service->getAutoCompleteSuggestions($code, $field, $value, Yii::$app->params['common.autocomplete.limit'], Yii::$app->user->getId());
    }
}