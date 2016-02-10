<?php

namespace app\controllers\actions;

use \Yii;
use \yii\base\Action;
use \yii\web\Response;
/**
 * Universal Action to get suggestions for typeahead widgets
 * @inheritdoc
 * @package app\helpers
 */
class Suggestions extends Action
{
    /**
     * @inheritdoc
     */
    public function run($code ,$field, $value)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return Yii::$app->common->getAutoCompleteSuggestions($code, $field, $value, Yii::$app->params['common.autocomplete.limit'], Yii::$app->user->getId());
    }
}