<?php


namespace app\controllers;

use app\core\Controller;
use app\models\User as UserModel;
use app\exceptions\Core;

class User extends Controller{
    public function actionLogin(){
        if(!isset($_POST['login']) || !isset($_POST['password']))
            throw new \app\exceptions\Core('Не достаточно входящих данных в actionlogin');

        $msg = '';
        if(empty($_POST['login']) || empty($_POST['password']))
            $msg.= 'Все поля формы должны быть заполнены!'.'<br>';

        $id = UserModel::getIdByLogin($_POST['login']);
        if (!$id){
            $msg.= 'Пользователь с таким именем не существует!'.'<br>';
            die($msg);
        }

        $userModel = new UserModel();
        $user = $userModel::findById($id);
        if(!self::comparePassHash($_POST['password'], $user->pass)){
            $msg.= 'Пользователь с таким именем и паролем не существует!'.'<br>';
            die($msg);
        }

        if (!empty($msg))
            die($msg);

        $_SESSION['uID'] = $user->id;

        die('ok');
    }

    public function actionRegister(){
        if(!isset($_POST['login']) || !isset($_POST['email']) || !isset($_POST['password']) || !isset($_POST['password2']))
            throw new \app\exceptions\Core('Не достаточно входящих данных в actionRegister');

        $msg = '';
        if(empty($_POST['login']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['password2']))
            $msg.= 'Все поля формы должны быть заполнены!'.'<br>';

        if($_POST['password'] != $_POST['password2'])
            $msg.= 'Пароли не совпадают!'.'<br>';

        if (!empty(UserModel::getIdByLogin($_POST['login'])))
            $msg.= 'Пользователь с таким именем уже существует!'.'<br>';

        if (!empty($msg))
            die($msg);

        $userModel = new UserModel();
        $userModel->login = $_POST['login'];
        $userModel->email = $_POST['email'];
        $userModel->pass = static::generateHash($_POST['password']);
        $qq = $userModel->insert();
        if (!$qq)
            die('Ошибка вставки в БД. Не удалось добавить данные пользователя.');

        $_SESSION['uID'] = UserModel::getIdByLogin($_POST['login']);

        die('ok');
    }

    public function actionLogout(){
        self::destroySession();
        die('ok');
    }




    /*
     * Генерация хеша пароля
     * @param string $password
     * @return string
     * */
    private static function generateHash(string $password){
        return password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
    }

    /*
     * Проверка хеша пароля
     * @param string $password
     * @param string $hash
     * @return bool
     * */
    private static function comparePassHash(string $password, string $hash){
        if (password_verify($password, $hash))
            return true;
        return false;
    }
/*
 * Запуск сессии, если ее нет
 * @return  bool Удачно или нет
 * */
    static function startSession() {
        if (!session_id())
            return session_start();
    }
/*
 * Уничтожает сессию и куки
 * */
    static function destroySession() {
        if ( session_id() ) {
            setcookie(session_name(), session_id(), time()-60*60*24);
            session_unset();
            session_destroy();
        }
    }
}