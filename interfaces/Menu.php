<?php
namespace app\interfaces;

/**
 * Interface Menu
 * @package app\interfaces
 */
interface Menu
{
    /**
     * @return array menu items for widget yii\bootstrap\Nav
     */
    static function getMenuItems();
}