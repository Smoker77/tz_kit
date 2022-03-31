<?php

namespace app\controllers;

use app\core\Controller;
use app\exceptions\Core;

class Test extends Controller{
    public function actionIndex(){
        \Util::pr('test / actionIndex');
    }

    public function actionTest(){
        echo 'test';

        $q = \App\Models\User::findAll();
//        \Util::pr($q,'findAll');

        $q = \App\Models\User::findById(2);
//        \Util::pr($q, 'findById');

        $q = new \App\Models\User;
        $q->email = 'qwerty';
        $q->login = 'asdfg';
        $q->pass = 'zxcvbbn';
//        $qq = $q->insert();
//        \Util::pr($qq,'insert');
        unset($q);

        $q = \App\Models\User::deleteById(20);
//        \Util::pr($q, 'deleteById');

        $q = new \App\Models\User;
        $q->email = '3';
        $q->login = '2';
        $q->pass = '2';
        $qq = $q->update(9);
        \Util::pr($qq,'update');
        unset($q);


        \Util::pr('End');

    }
}

