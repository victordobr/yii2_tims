<?php

namespace app\components;

use Yii;
use yii\base\Event;

class EventManager extends \yiicod\listener\components\EventManager
{
    /**
     * Init component
     */
    public function init()
    {

        $listeners = Yii::getAlias($this->listenersAlias) . '.php';
        if (!file_exists($listeners)) {
            throw new Exception($listeners . '.php file requered and must be return array!');
        }
        $listeners = include_once $listeners;

        foreach ($listeners as $key => $listener) {
            $global = true;
            if (is_string($listener[0])) {
                if(!class_exists($listener[0])) {
                    continue;
                }
                $global = false;
                $class_name = $listener[0];
            }
            foreach ($listener as $objects) {
                if (is_string($objects)) {
                    continue;
                }
                if (true === is_array($objects) && false === is_object($objects[0]) && false === class_exists($objects[0])) {
                    $objects = function() use ($objects) {
                        $component = eval('return ' . $objects[0] . ';');
                        call_user_func_array(array($component, $objects[1]), func_get_args());
                    };
                }
                if ($global) {
                    Yii::$app->on($key, $objects);
                }
                else {
                    Event::on($class_name, $key, $objects);
                }
            }
        }
    }
}