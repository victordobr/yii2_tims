<?php

namespace app\modules\frontend\controllers\records\upload;

use app\components\media\Media;
use Yii;
use yii\base\Action;
use yii\web\BadRequestHttpException;
use app\components\media\UploadHandler;

class ChunkUploadAction extends Action
{

    /**
     * Method to handle file upload
     * @return string
     * @throws HttpException
     * @author Alex Makhorin
     */
    public function run()
    {
        if (!Yii::$app->request->isPost) {
            throw new BadRequestHttpException();
        }
        (new UploadHandler([
            'upload_dir' => self::media()->tmpDirectory,
            'mkdir_mode' => 0777,
            'image_versions' => [],
        ]));
    }

    /**
     * @return Media
     */
    private static function media()
    {
        return Yii::$app->media;
    }

}