<?php

namespace app\widgets\mediaPopup;

use yii\base\Widget;
use app\enums\FileType;
use yii\web\HttpException;

class MediaPopup extends Widget
{
    public $url;
    public $type;

    public function init()
    {
        if(empty($this->url)) {
            throw new HttpException(500, 'Url property is invalid');
        }
        if(empty($this->type) || !array_key_exists($this->type, FileType::listData())) {
            throw new HttpException(500, 'Type property is invalid');
        }
    }

    function run()
    {
        return $this->render('index', [
            'url' => $this->url,
            'type' => $this->type,
            'modalId' => 'modal-' .  $this->id,

        ]);
    }

}

