<?php

namespace app\modules\frontend\controllers;

use \Yii;
use \yii\base\Exception;
use \yii\web\HttpException;
use \yii\helpers\Url;

use \app\modules\frontend\base\Controller;

/**
 * UsersController implements the CRUD actions for User model.
 * @package app\modules\frontend\controllers
 */
class MediaController extends Controller
{

    public function actionUpload()
    {

        return $this->render('upload', [
            'handleUrl' => $handleUrl,
            'uploadUrl' => $uploadUrl,
            'dropZone' => $this->galleryService->dropZone,
            'updateItemsUrl' => $updateItemsUrl,
            'itemFormId' => $galleryService::ITEM_FORM_ID,
            'itemModalId' => $galleryService::ITEM_MODAL_ID,
            'maxFileSize' => $this->galleryService->maxFileSize,
            'maxChunkSize' => $this->galleryService->maxChunkSize,
            'acceptMimeTypes' => $this->galleryService->acceptMimeTypes,
        ]);
    }

    public function actionHandleUploaded()
    {
        $fileData = Yii::$app->request->getBodyParam('file');

        if (!$fileData) {
            throw new HttpException(400, 'No data to handle');
        }

        $fileData = json_decode($fileData);
        $fileData = $fileData->image[0];
        $filename = Yii::$app->get('service|gallery')->tmpDirectory . '/' . $fileData->name;
        if (md5_file($filename) != Yii::$app->request->getBodyParam('sum')) {
            is_file($filename) && unlink($filename);
            throw new HttpException(422, Yii::t('galleryManager/main', 'File integrity is broken'));
        }

        if (strpos($fileData->type, 'video/') === 0) {
            $model = Yii::$app->get('service|gallery')->addVideo($fileData, Yii::$app->getUser()->id);
        } elseif (strpos($fileData->type, 'image/') === 0) {
            $model = Yii::$app->get('service|gallery')->addImage($fileData, Yii::$app->getUser()->id);
        } else {
            is_file($filename) && unlink($filename);
            throw new HttpException(400, 'No data to handle');
        }

        Yii::$app->response->headers->set('Content-Type', 'text/html');

        return Json::encode(
            [
                'id'      => $model->id,
                'rank'    => $model->rank,
                'name'    => (string)$model->title,
                'preview' => Yii::$app->get('service|gallery')->getPreviewUrl($model),
            ]
        );
    }
}
