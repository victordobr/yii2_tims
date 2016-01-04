<?php
namespace app\modules\frontend\base;

/**
 * Base admin controller.
 * @package app\modules\admin\base
 */
class Controller extends \app\base\Controller
{
    /** @var string $layout admin default layout. */
    public $layout = 'main.php';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [];
    }
}