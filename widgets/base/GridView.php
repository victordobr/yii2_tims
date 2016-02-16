<?php
namespace app\widgets\base;

use Yii;
use app\widgets\base\assets\GridViewAsset;

class GridView extends \kartik\grid\GridView
{
    const SUMMARY_TEMPLATE = 'Showing <b>{begin, number}-{end, number}</b> of <b>{totalCount, number}</b> {totalCount, plural, one{record} other{records}}.';

    public function init()
    {
        parent::init();
        GridViewAsset::register($this->getView());

        $this->setSummary();
    }

    private function setSummary()
    {
        $this->summary = Yii::t('app', '<div class="summary">' . self::SUMMARY_TEMPLATE . '</div>');
    }

}