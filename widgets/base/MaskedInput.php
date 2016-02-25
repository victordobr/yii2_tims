<?php

namespace app\widgets\base;

class MaskedInput extends \yii\widgets\MaskedInput
{
    public $mask;

    /**
     * Initializes the widget.
     */
    public function init()
    {
        if ($this->attribute == 'lat_ddm' || $this->attribute == 'lng_ddm') {
            $this->mask = '9[9[9]].9[9[9]].9[9[9[9[9]]]]a';
            parent::init();
        }
    }

}