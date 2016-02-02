<?php

namespace app\modules\frontend\controllers\records\upload;

use app\components\media\Media;
use Yii;
use yii\base\Action;
use yii\helpers\Json;
use yii\web\HttpException;

class HandleAction extends Action
{
    /**
     * Method to handle file upload
     * @return string
     * @throws HttpException
     * @author Alex Makhorin
     */
    public function run()
    {
        $fileData = Yii::$app->request->getBodyParam('file');

        if (!$fileData) {
            throw new HttpException(400, 'No data to handle');
        }

        $fileData = json_decode($fileData);
        if (empty($fileData->image[0])) {
            throw new HttpException(400, 'Upload failed with chunk size ' . self::media()->maxChunkSize . ' bytes. Try to decrease this value or configure PHP for larger size.');
        }
        $fileData = $fileData->image[0];

        $id = self::media()->saveFileToStorage($fileData);

        Yii::$app->response->headers->set('Content-Type', 'text/html');

        return Json::encode([
            'id' => $id,
        ]);
    }

    /**
     * @return Media
     */
    private static function media()
    {
        return Yii::$app->media;
    }

}