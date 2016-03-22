<?php
namespace app\widgets\base;

use Yii;
use app\widgets\base\assets\GridViewAsset;

class GridView extends \kartik\grid\GridView
{
    const SUMMARY_TEMPLATE = '<b>{begin, number}-{end, number}</b> of <b>{totalCount, number}</b><span>{totalCount, plural, one{record} other{records}}<span>';

    public $bordered = false;
//    public $striped = false;

    public function init()
    {
        parent::init();
        GridViewAsset::register($this->getView());

        $this->setSummary();
        $this->setLayout();
    }

    /**
     * @return string
     */
    private function setLayout()
    {
        return $this->layout = "{summary}\n{items}\n{pager}";
    }

    /**
     * @return string
     */
    private function setSummary()
    {
        return $this->summary = Yii::t('app', '<div class="summary">' . self::SUMMARY_TEMPLATE . '</div>');
    }

}