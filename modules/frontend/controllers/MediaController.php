<?php

namespace app\modules\frontend\controllers;

use \Yii;
use \yii\base\Exception;
use \yii\web\HttpException;
use \yii\helpers\Url;
use yii\web\BadRequestHttpException;
use \yii\helpers\Json;
use \app\modules\frontend\base\Controller;
use \app\assets\NotifyJsAsset;

/**
 * UsersController implements the CRUD actions for User model.
 * @package app\modules\frontend\controllers
 */
class MediaController extends Controller
{

    public function init()
    {
        $view = $this->getView();
        NotifyJsAsset::register($view);
    }

    public function actionUpload()
    {
//        phpinfo(); die;
//        echo Url::to(Yii::$app->media->uploadRoute); die;
        $uploadUrl = Yii::$app->media->uploadRoute;
        $handleUrl = Yii::$app->media->handleRoute;
        $dropZone = Yii::$app->media->dropZone;
        $maxFileSize = Yii::$app->media->maxFileSize;
        $maxChunkSize = Yii::$app->media->maxChunkSize;
        $acceptMimeTypes = Yii::$app->media->acceptMimeTypes;

        return $this->render('upload', [
            'handleUrl' => $handleUrl,
            'uploadUrl' => $uploadUrl,
            'dropZone' => $dropZone,
            'maxFileSize' => $maxFileSize,
            'maxChunkSize' => $maxChunkSize,
            'acceptMimeTypes' => $acceptMimeTypes,
        ]);
    }

    /**
     * Method to handle file upload thought XHR2
     * On success returns JSON object with image info.
     * @return string
     * @throws HttpException
     */
    public function actionChunkUpload()
    {
        if (!Yii::$app->request->isPost) {
            throw new BadRequestHttpException();
        }
        (new \app\components\media\UploadHandler([
            'upload_dir' => Yii::$app->media->tmpDirectory,
            'mkdir_mode' => 0777,
            'image_versions' => [],
        ]));
    }

    public function actionHandle()
    {
        $fileData = Yii::$app->request->getBodyParam('file');

        if (!$fileData) {
            throw new HttpException(400, 'No data to handle');
        }

        $fileData = json_decode($fileData);
        if (empty($fileData->image[0])) {
            throw new HttpException(400, 'Upload failed with chunk size ' . Yii::$app->media->maxChunkSize . ' bytes. Try to decrease this value or configure PHP for larger size.');
        }
        $fileData = $fileData->image[0];
//        $filename = Yii::$app->media->tmpDirectory . '/' . $fileData->name;

        $path = Yii::$app->media->saveFileToStorage($fileData);

        Yii::$app->response->headers->set('Content-Type', 'text/html');

        return Json::encode(
            [
                'path' => $path,
            ]
        );
    }
}
