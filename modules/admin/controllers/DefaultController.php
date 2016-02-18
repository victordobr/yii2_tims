<?php


namespace app\modules\admin\controllers;

use \app\modules\admin\base\Controller;
use \Yii;
use \yii\filters\VerbFilter;

/**
 * Class DefaultController
 * @package app\modules\frontend\controllers
 * @author Alex Makhorin
 */
class DefaultController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

}