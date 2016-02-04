<?php

namespace app\widgets\mediaPopup;

use yii\base\Widget;
use app\enums\FileType;
use yii\web\HttpException;
use kartik\icons\Icon;
use app\widgets\mediaPopup\assets\MediaPopupAsset;

class MediaPopup extends Widget
{
    public $url;
    public $type;
    public $title;
    public $text;
    public $mime;

    public function init()
    {
        Icon::map($this->getView(), Icon::FA);

        $this->registerScripts();

        // Change flv type for flowplayer
        $this->mime = ($this->mime == 'video/x-flv') ? 'video/flv' : $this->mime;

        if(empty($this->url)) {
            throw new HttpException(500, 'Url property is invalid');
        }
        if(empty($this->type) || !array_key_exists($this->type, FileType::listData())) {
            throw new HttpException(500, 'Type property is invalid');
        }
    }

    public function registerScripts()
    {
        MediaPopupAsset::register($this->getView());
    }

    function run()
    {
        $icon = $this->type == FileType::TYPE_IMAGE ?
            Icon::show('camera-retro', ['class' => 'fa-3x']) :
            Icon::show('youtube-play', ['class' => 'fa-3x']);

        return $this->render('index', [
            'url' => $this->url,
            'type' => $this->type,
            'icon' => $icon,
            'title' => $this->title,
            'text' => $this->text,
            'mime' => $this->mime,
            'modalId' => 'modal-' .  $this->id,
        ]);
    }
}