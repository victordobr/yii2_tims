<?php
namespace app\widgets\grid;

use \Yii;
use \dosamigos\grid\ToggleColumn;

/**
 * @package app\widgets\grid
 * @version 1.0
 * @author Cyril Turkevich
 * @copyright (c) 2014-2015 KFOSoftware Team <kfosoftware@gmail.com>
 */
class UserActiveToggleColumn extends ToggleColumn
{
    /**
     * @inheritdoc
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        /* @todo use yii params instead of 1 */
        if ($model->primaryKey == 1 || $model->primaryKey == Yii::$app->user->id) {
           return '';
        }
        return parent::renderDataCellContent($model, $key, $index);
    }
} 