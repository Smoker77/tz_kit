<?php

namespace app\controllers;

use app\core\Controller;
use app\exceptions\Core;

class Popup extends Controller{

    public function actionLogin(){
        //$this->view->headerText = 'Тестовое задание';
        $this->view->title = 'Вход в систему';

        $this->view->display('popup_login.php','template_popup.php');
    }

//    public function actionLogout(){
//        //$this->view->headerText = 'Тестовое задание';
//        //$this->view->title = 'Тестовое задание КИТ';
//
//
//    }

    public function actionRegister(){
        //$this->view->headerText = 'Тестовое задание';
        $this->view->title = 'Регистрация пользователя';

        $this->view->display('popup_register.php','template_popup.php');
    }
}

