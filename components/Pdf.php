<?php
namespace app\components;

use Yii;

class Pdf extends \kartik\mpdf\Pdf
{
    const RUNTIME_SUB_DIRECTORY = '/pdf/';

    public $styles = [];

    public function init()
    {
        parent::init();

        $path = Yii::getAlias('@runtime').self::RUNTIME_SUB_DIRECTORY;
        define('_MPDF_TTFONTDATAPATH', $path);
        define('_MPDF_TEMP_PATH', $path);
    }

    public function getCss()
    {
        if (!empty($this->_css)) {
            return $this->_css;
        }
        $css .= $this->cssInline;

        $cssFile = empty($this->cssFile) ? '' : Yii::getAlias($this->cssFile);
        if (empty($cssFile) || !file_exists($cssFile)) {
            $css = '';
        } else {
            $css = file_get_contents($cssFile);
        }

//        echo '<pre>';
//        print_r(Yii::$aliases);
//        echo '</pre>';
//        die;

        foreach ($this->styles as $style) {
            $style = Yii::getAlias($style);
            if (!empty($style) && file_exists($style)) {
                $css .= file_get_contents($style);
            }
        }

        return $css;
    }

}