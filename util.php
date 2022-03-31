<?php
class Util{
    /*
     * Вывод отладочной информации
     * @param $var Переменная или массив для вывода на экран.
     * @param string|null $descr (optional) Строка описания
     * */
    public static function pr($var, $descr=false){
        echo '<br>';
        echo $descr?$descr.': '.'<br>':'';
        echo'<pre>';
        print_r($var);
        echo '</pre>';
    }

}
