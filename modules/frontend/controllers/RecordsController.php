<?php

namespace app\modules\frontend\controllers;

use Yii;
use app\models\Record;
use app\modules\frontend\models\search\Record as RecordSearch;

use app\enums\EvidenceFileType;
use \yii\web\HttpException;
use yii\web\BadRequestHttpException;
use \yii\helpers\Json;
use \app\modules\frontend\base\Controller;
use \app\assets\NotifyJsAsset;
use \yii\web\Response;
use \yii\widgets\ActiveForm;

/**
 * RecordsController implements the actions for Record model.
 */
class RecordsController extends Controller
{
    public function init()
    {
        $view = $this->getView();
        NotifyJsAsset::register($view);
    }

    /**
     * Lists all Record models.
     * @return mixed
     */
    public function actionSearch()
    {
        $model = new RecordSearch;
        $dataProvider = $model->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = Yii::$app->params['search.page.size'];

        return $this->render('search', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Create Record model or update an existing Record model. Create Files and attach to Record model.
     * If update is successful, the browser will be redirected to the 'upload' page.
     * @return array|string|Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionUpload()
    {
        $recordId = Yii::$app->request->get('id');

        if ($recordId) {
            $model = $this->findModel(Record::className(), $recordId);
        }
        else {
            $model = new Record();
            $model->scenario = Record::SCENARIO_UPLOAD;
        }

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        $post = Yii::$app->request->post();

        if ($model->load($post) && $model->validate()) {
            $this->saveRecord($model, $post);

            return $this->redirect(['upload', 'id' => $model->id]);
        }

        $uploadUrl = Yii::$app->media->uploadRoute;
        $handleUrl = Yii::$app->media->handleRoute;
        $dropZone = Yii::$app->media->dropZone;
        $maxFileSize = Yii::$app->media->maxFileSize;
        $maxChunkSize = Yii::$app->media->maxChunkSize;
        $acceptMimeTypes = Yii::$app->media->acceptMimeTypes;

        $view = $recordId ? 'edit' : 'upload';

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

    public function saveRecord($model, $post)
    {
        $fileIds = [];

        if (empty($post['Record'])) {
            return false;
        }

        if(!empty($post['Record']['videoLprId'])) {
            $fileIds[EvidenceFileType::TYPE_VIDEO_LPR] = $post['Record']['videoLprId'];
        }
        if(!empty($post['Record']['videoOverviewCameraId'])) {
            $fileIds[EvidenceFileType::TYPE_VIDEO_OVERVIEW_CAMERA] = $post['Record']['videoOverviewCameraId'];
        }
        if(!empty($post['Record']['imageLprId'])) {
            $fileIds[EvidenceFileType::TYPE_IMAGE_LPR] = $post['Record']['imageLprId'];
        }
        if(!empty($post['Record']['imageOverviewCameraId'])) {
            $fileIds[EvidenceFileType::TYPE_IMAGE_OVERVIEW_CAMERA] = $post['Record']['imageOverviewCameraId'];
        }

        $model->save();

        if (!empty($fileIds)) {
            foreach ($fileIds as $video_type => $fileId) {
                Yii::$app->media->assignFileToRecord($fileId, $model->primaryKey, $video_type);
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
