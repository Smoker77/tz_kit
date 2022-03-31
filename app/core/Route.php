<?php

namespace app\core;
use Util;
use \app\exceptions\Core;
use \app\exceptions\Db;
use \app\controllers\User;

class Route
{
    private static $controller;
    private static $action;

    public function __construct(){
        User::startSession();
    }

    public function Start(){

        try {
            self::route();
        }catch (Db $e) {
            $data = [
                'text'    => 'При работе с базой данных произошла ошибка:',
                'message' => $e->getMessage(),
            ];
            include 'app/views/'.'template_error.php';
        }catch (Core $e) {
            switch ($e->getCode()) {
                case '404':
                    $data = [
                        'text'    => 'Ошибка 404',
                        'message' => $e->getMessage(),
                    ];
                    include 'app/views/'.'template_404.php';
                    break;
                default:
                    $data = [
                        'text'    => 'В приложении произошла ошибка:',
                        'message' => $e->getMessage(),
                    ];
                    include 'app/views/'.'template_error.php';
            }
        }catch (\Throwable $e) {
            $data = [
                'text'    => 'Произошла ошибка:',
                'message' => $e->getMessage(),
            ];
            include 'app/views/'.'template_error.php';
        }

    }

    private static function route(){
        preg_match_all('/^\/([^?]*)/m', $_SERVER['REQUEST_URI'], $matches);
        $paramArr = explode('/', $matches[1][0]);

        self::$controller = ucfirst(!empty($paramArr[0])?$paramArr[0]:'main');

        if(!isset($_SESSION['uID']))
            self::$action = ucfirst(!empty($paramArr[1])?$paramArr[1]:'index');
        else
            self::$action = ucfirst(!empty($paramArr[1])?$paramArr[1]:'indexReg');

        $controllerName = '\\app\\controllers\\' . self::$controller;

        $controller = new $controllerName;
        $controller->action(self::$action);
    }

}