<?php
namespace app\interfaces;

/**
 * Interface Menu
 * @package app\interfaces
 * @version 1.0
 * @copyright (c) 2014-2015 KFOSoftware Team <kfosoftware@gmail.com>
 */
interface Menu
{
    /**
     * @return array menu items for widget yii\bootstrap\Nav
     */
    static function getMenuItems();
}