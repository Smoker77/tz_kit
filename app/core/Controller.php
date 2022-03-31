<?php

namespace app\core;

use app\core\View;
use app\exceptions\Core;

class Controller{
    public $model;
    public $view;

    function __construct(){
        $this->view = new View();
    }

    public function action($actionName){
        $className =static::class;
        $actionName = 'action'.$actionName;

        if(!method_exists($className, $actionName))
            throw new Core("Action {$actionName} в классе {$className} не найден.");

        $this->{$actionName}();
    }
}