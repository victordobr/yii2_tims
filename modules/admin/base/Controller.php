<?php
namespace app\modules\admin\base;

/**
 * Base admin controller.
 * @package app\modules\admin\base
 * @version 1.0
 * @copyright (c) 2014-2015 KFOSoftware Team <kfosoftware@gmail.com>
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