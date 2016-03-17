<?php

namespace app\modules\frontend\controllers\records;

use app\assets\PrintAsset;
use app\components\Settings;
use app\models\base\Citation;
use Yii;
use app\models\Record;
use app\modules\frontend\controllers\RecordsController;
use yii\base\Action;
use app\enums\location\Code as LocationCode;

class PrintAction extends Action
{
    const PATH_DIR_SVG = '@webroot/svg/';
    const PATH_URL_SVG = '@web/svg/';
    const EXTENSION_SVG = '.svg';

    public function init()
    {
        parent::init();

        $this->setLayout('print');
        PrintAsset::register($this->controller()->getView());
    }

    public function run($id)
    {
        $content = '';
        foreach (self::parseId($id) as $id) {
            $record = $this->findModel($id);
            $owner = $record->owner;
            $images = [
                'img_lpr' => $record->imageLpr->url,
                'img_oc' => $record->imageOverviewCamera->url,
            ];

            if (empty($citation = $owner->citation)) {
                $citation = new Citation([
                    'record_id' => $record->id,
                    'owner_id' => $owner->id,
                    'location_code' => LocationCode::JCA,
                    'penalty' => 100, // todo: hard code
                    'fee' => 10, // todo: hard code
                    'created_at' => time(),
                ]);
                if (!$citation->save()) {
                    throw new \Exception('Citation do not created');
                }
            }

            $params = [
                'record' => $record,
                'owner' => $owner,
                'citation' => $citation,
                'vehicle' => $owner->vehicle,
                'public_host' => Yii::$app->settings->get('public.host'),
            ];

            $params['svg'] = $this->renderSvgFile('print/notice/first', $images);
            $content .= $this->controller()->renderPartial('print/notice/first', $params);
            $params['svg'] = $this->renderSvgFile('print/notice/final', $images);
            $content .= $this->controller()->renderPartial('print/notice/final', $params);
            $params['svg'] = $this->renderSvgFile('print/appendix');
            $content .= $this->controller()->renderPartial('print/appendix', $params);
            $content .= $this->controller()->renderPartial('print/separator');
        }

        return $this->controller()->renderContent($content);
    }

    private static function parseId($id)
    {
        return !is_bool(strpos($id, '-')) ? array_filter(explode('-', $id)) : [$id];
    }

    private function renderSvgFile($view, array $params = [])
    {
        $filepath = $this->controller()->getViewPath() . '/' . $view . self::EXTENSION_SVG;
        $data = $this->controller()->renderFile($filepath, $params);

        file_put_contents(self::getSvgFilePath($view), $data);

        return self::getSvgFilePath($view, true);
    }

    private static function getSvgFilePath($filename, $web = false)
    {
        $path = Yii::getAlias(!$web ? self::PATH_DIR_SVG : self::PATH_URL_SVG);

        return $path . $filename . self::EXTENSION_SVG;
    }

    /**
     * @param $id
     * @return Record
     * @throws \yii\web\NotFoundHttpException
     */
    private function findModel($id)
    {
        return $this->controller()->findModel(\app\models\base\Record::className(), $id);
    }

    /**
     * @return Settings
     */
    private static function settings()
    {
        return Yii::$app->settings;
    }

    /**
     * @param string $name
     */
    private function setLayout($name)
    {
        $this->controller()->layout = $name;
    }

    /**
     * @return RecordsController
     */
    private function controller()
    {
        return $this->controller;
    }

    /**
     * @return \app\components\Record
     */
    private static function record()
    {
        return Yii::$app->record;
    }

}