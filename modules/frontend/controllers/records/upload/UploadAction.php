<?php

namespace app\modules\frontend\controllers\records\upload;

use app\components\media\Media;
use app\enums\EventNames;
use app\enums\EvidenceFileType;
use app\events\record\Upload as UploadEvent;
use app\modules\frontend\controllers\RecordsController;
use Yii;
use yii\base\Action;
use app\models\Record;
use yii\web\Response;
use yii\widgets\ActiveForm;

class UploadAction extends Action
{

    /**
     * Create Record model or update an existing Record model. Create Files and attach to Record model.
     * If update is successful, the browser will be redirected to the 'upload' page.
     * @return array|string|Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function run()
    {
        $recordId = Yii::$app->request->get('id');

        if ($recordId) {
            $model = $this->controller()->findModel(Record::className(), $recordId);
        }
        else {
            $model = new Record();
            $model->scenario = Record::SCENARIO_UPLOAD;
        }

        $model->user_id = Yii::$app->user->id;

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        $post = Yii::$app->request->post();

        if ($model->load($post) && $model->validate()) {
            if($this->saveRecord($model, $post)){
                Yii::$app->trigger(EventNames::UPLOAD_SUCCESS, new UploadEvent([
                    'record' => $model,
                    'user_id' => Yii::$app->user->id,
                ]));
            }

            return $this->controller()->redirect(['upload', 'id' => $model->id]);
        }

        $media = self::media();
        $uploadUrl = $media->uploadRoute;
        $handleUrl = $media->handleRoute;
        $dropZone = $media->dropZone;
        $maxFileSize = $media->maxFileSize;
        $maxChunkSize = $media->maxChunkSize;
        $acceptMimeTypes = $media->acceptMimeTypes;

        $view = $recordId ? 'edit' : 'upload';

        return $this->controller()->render($view, [
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
                self::media()->assignFileToRecord($fileId, $model->primaryKey, $video_type);
            }
        }

        return $model->id;
    }

    /**
     * @return Media
     */
    private static function media()
    {
        return Yii::$app->media;
    }

    /**
     * @return RecordsController
     */
    private static function controller()
    {
        return Yii::$app->controller;
    }

}