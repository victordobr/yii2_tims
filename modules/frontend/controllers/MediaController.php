<?php

namespace app\modules\frontend\controllers;

use app\enums\EvidenceFileType;
use app\models\PoliceCase;
use \Yii;
use \yii\base\Exception;
use \yii\web\HttpException;
use yii\web\NotFoundHttpException;
use \yii\helpers\Url;
use yii\web\BadRequestHttpException;
use \yii\helpers\Json;
use \app\modules\frontend\base\Controller;
use \app\assets\NotifyJsAsset;
use \yii\web\Response;
use \yii\widgets\ActiveForm;

use app\models\Evidence;
use app\modules\frontend\models\search\Evidence as EvidenceSearch;

/**
 * UsersController implements the CRUD actions for User model.
 * @package app\modules\frontend\controllers
 * @author Alex Makhorin
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
        $evidenceId = Yii::$app->request->get('id');

        if ($evidenceId) {
            $model = $this->findModel(Evidence::className(), $evidenceId);
        } else {
            $model = new Evidence();
            $model->scenario = Evidence::SCENARIO_UPLOAD;
        }

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        $uploadUrl = Yii::$app->media->uploadRoute;
        $handleUrl = Yii::$app->media->handleRoute;
        $dropZone = Yii::$app->media->dropZone;
        $maxFileSize = Yii::$app->media->maxFileSize;
        $maxChunkSize = Yii::$app->media->maxChunkSize;
        $acceptMimeTypes = Yii::$app->media->acceptMimeTypes;
        $currentUserId = Yii::$app->user->id;
        $post = Yii::$app->request->post();

        if ($model->load($post) && $model->validate()) {
            $this->saveEvidence($model, $post, $currentUserId);

            return $this->redirect(['upload', 'id' => $model->id]);
        }

        $view = $evidenceId ? 'edit' : 'upload';

        return $this->render($view, [
            'model' => $model,
            'handleUrl' => $handleUrl,
            'uploadUrl' => $uploadUrl,
            'dropZone' => $dropZone,
            'maxFileSize' => $maxFileSize,
            'maxChunkSize' => $maxChunkSize,
            'acceptMimeTypes' => $acceptMimeTypes,
        ]);

    }

    public function saveEvidence($model, $post, $currentUserId)
    {
        $fileIds = [];

        if (empty($post['Evidence'])) {
            return false;
        }

        if(!empty($post['Evidence']['videoLprId'])) {
            $fileIds[EvidenceFileType::TYPE_VIDEO_LPR] = $post['Evidence']['videoLprId'];
        }
        if(!empty($post['Evidence']['videoOverviewCameraId'])) {
            $fileIds[EvidenceFileType::TYPE_VIDEO_OVERVIEW_CAMERA] = $post['Evidence']['videoOverviewCameraId'];
        }
        if(!empty($post['Evidence']['imageLprId'])) {
            $fileIds[EvidenceFileType::TYPE_IMAGE_LPR] = $post['Evidence']['imageLprId'];
        }
        if(!empty($post['Evidence']['imageOverviewCameraId'])) {
            $fileIds[EvidenceFileType::TYPE_IMAGE_OVERVIEW_CAMERA] = $post['Evidence']['imageOverviewCameraId'];
        }

        $case = new PoliceCase();

        //TODO: add correct statuses
        $case->status_id = 99;

        $caseSaved = $case->save(false);

        if ($caseSaved) {
            $model->user_id = $currentUserId;
            $model->case_id = $case->id;

            $eviSaved = $model->save(false);
            if ($eviSaved && !empty($fileIds)) {
                foreach ($fileIds as $evidence_video_type => $fileId) {
                    Yii::$app->media->assignFileToEvidence($fileId, $model->primaryKey, $evidence_video_type);
                }

            }
        }

        return true;
    }

//    /**
//     * Updates an existing Evidence model.
//     * If update is successful, the browser will be redirected to the 'view' page.
//     * @param integer $id
//     * @return mixed
//     * @author Alex Makhorin
//     */
//    public function actionEdit($id)
//    {
//        $model = $this->findModel(Evidence::className(), $id);
//
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
////            return $this->redirect(['view', 'id' => $model->id]);
//        } else {
//            return $this->render('edit', [
//                'model' => $model,
//            ]);
//        }
//    }

    /**
     * Method to handle file upload
     * @return string
     * @throws HttpException
     * @author Alex Makhorin
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

        $id = Yii::$app->media->saveFileToStorage($fileData);

        Yii::$app->response->headers->set('Content-Type', 'text/html');

        return Json::encode(
            [
                'id' => $id,
            ]
        );
    }
}
