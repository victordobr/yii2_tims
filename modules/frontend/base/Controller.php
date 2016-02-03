<?php
namespace app\modules\frontend\base;

/**
 * Base admin controller.
 * @package app\modules\admin\base
 */
class Controller extends \app\base\Controller
{
    /** @var string $layout frontend default layout. */
    public $layout = 'one-column.php';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [];
    }
}