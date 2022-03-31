<?php

/*
 * Автоподключение классов
 * @param string $class Имя класса (app\models\User)
 * */
function autoloader($class){
    global $conf;
    $fName = $conf['root_dir'] . '/' .str_replace('\\', '/', $class) . '.php';
    if (!is_readable($fName))
        throw new \app\exceptions\Core('Файл не найден: '.$fName, '404');
    require $fName;
}

spl_autoload_register('autoloader');
