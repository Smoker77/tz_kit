<?php

namespace app\models;

use app\models\User as UserModel;

class User extends Model{
    const TABLE = 'users';

    public $email;
    public $login;
    public $pass;

    public function getEmail(){
        return $this->email;
    }

    public function getId(){
        return $this->id;
    }

    public function getLogin(){
        return $this->login;
    }

    /*
     * Выборка id по login
     * @param string $login
     * @return integer|null $id
     * */
    public static function getIdByLogin(string $login){
        $a= new UserModel();
        $a->login=$login;
        $res = $a->findAllBy();

        if(!empty($res))
            return $res[0]->id;

        return null;
    }
/*
 *  Проверка, авторизован ли пользователь
 * @return integer|bool  id пользователя или false
 * */
    public static function checkAuthorized(){
        if(isset($_SESSION['uID']))
            return $_SESSION['uID'];
        return false;
    }








}