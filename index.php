<?php
$conf = include('./config.php');
include_once  'util.php';

require_once $conf['root_dir'] . '/autoload.php';

// запускаем маршрутизатор
$route = new \app\core\Route();
$route->Start();



