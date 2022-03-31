<?php

namespace app\controllers;

use app\core\Controller;
use app\exceptions\Core;

class Main extends Controller{

//    public function action($actionName){
//        $className = __CLASS__;
//        $actionName = 'action'.$actionName;
//
//        if(!method_exists($className, $actionName))
//            throw new Core("Action {$actionName} в классе {$className} не найден.");
//
//        $this->{$actionName}();
//    }

    public function actionIndex(){
        $this->view->headerText = 'Тестовое задание';
        $this->view->title = 'Тестовое задание КИТ';


        $this->view->display('page1_unreg.php','template_unreg.php');
    }

    public function actionIndexReg(){
        $this->view->headerText = 'Тестовое задание';
        $this->view->title = 'Тестовое задание КИТ';
        $this->view->login = \app\models\User::findById($_SESSION['uID'])->login;

        $this->view->display('page1_reg.php','template_reg.php');
    }

}

