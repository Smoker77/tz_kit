<?php

namespace app\core;

class Db{
    protected static $instance;
    protected $db;

    protected function __construct(){
        global $conf;
        try {
            $this->db = new \PDO("mysql:host={$conf['db_host']};dbname={$conf['db_name']}", $conf['db_user'], $conf['db_pass']);
        } catch (\PDOException $e) {
            throw new \app\exceptions\Db('Ошибка подключения к БД: '.$e->getMessage());
        }
    }

    public static function instance(){
        if (null === static::$instance) {
            static::$instance = new static;
        }
        return static::$instance;
    }

    /*
     * Выполнение запроса к БД
     * @param string $sql Текст запроса ('SELECT * FROM имя_таблицы WHERE id=:id')
     * @param array $params (optional) Параметры запроса ([':id' => $id])
     * @return bool Результат выполнения
     * */
    public function execute($sql, $params = []){
        $sth = $this->db->prepare($sql);
        $res = $sth->execute($params);
        //\Util::pr($res,'res');
        return $res;
    }

    /*
     * Выполнение запроса к БД
     * @param string $sql Текст запроса ('SELECT * FROM имя_таблицы WHERE id=:id')
     * @param array $params (optional) Параметры запроса ([':id' => $id])
     * @param string Полное имя класса, объект которого ожидается на выходе
     * @return array результат выборки
     * */
    public function query($sql, $params, $class){
        $sth = $this->db->prepare($sql);
        $res = $sth->execute($params);
        if (false !== $res) {
            return $sth->fetchAll(\PDO::FETCH_CLASS, $class);
        }
        return [];
    }
}