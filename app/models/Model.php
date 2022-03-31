<?php

namespace app\models;

use app\core\Db;

abstract class Model{
    const TABLE = '';

    public $id;

    /*
     * Выборка всех записей
     * @return array[object] результат выборки ожидаемых класса
     * */
    public static function findAll(){
        $db = Db::instance();
        return $db->query(
            'SELECT * FROM ' . static::TABLE,
            [],
            static::class
        );
    }


    /*
     * Выборка записей по id из БД
     * @param integer $id
     * @return object результат выборки ожидаемого класса | []
     * */
    public static function findById($id){
        $db = Db::instance();
        $res = $db->query(
            'SELECT * FROM ' . static::TABLE . ' WHERE id=:id',
            [':id' => $id],
            static::class
        );
        if(count($res)!=0){
            return $res[0];
        }else{
            return [];
        }
    }

    /*
     * Выборка всех записей удовлетворяюших условиям
     * @return array[object] результат выборки ожидаемых класса
     * */
    public function findAllBy(){
        $db = Db::instance();

        $selectFields = [];
        $valuesArr = [];
        foreach ($this as $k => $v) {
            if (empty($v) && $v !==0)
                continue;
            $selectFields[] = $k.'=:'.$k;
            $valuesArr[':'.$k] =$v;
        }
        //\Util::pr($selectFields);
        //\Util::pr($valuesArr);

        return $db->query(
            'SELECT * FROM ' . static::TABLE . ' WHERE ('.implode(' AND ', $selectFields).')',
            $valuesArr,
            static::class
        );
    }

    /*
     * Вставка новой записи
     * @return boll результат операции
     * */
    public function insert(){
        $columns = [];
        $values = [];
        foreach ($this as $k => $v) {
            if ('id' == $k) {
                continue;
            }
            $columns[] = $k;
            $values[':'.$k] = $v;
        }

        $sql = '
            INSERT INTO ' . static::TABLE . '
                (' . implode(',', $columns) . ')
            VALUES
                (' . implode(',', array_keys($values)) . ')
        ';

        $db = Db::instance();
        return $db->execute($sql, $values);
    }

    /*
     * Удаление записи по id
     * @param integer $id
     * @return boll результат операции
     * */
    public static function deleteById($id){
        $db = Db::instance();
        return $db->execute(
            'DELETE FROM ' . static::TABLE . ' WHERE id=:id',
            [':id' => $id],
            static::class
        );
    }

    /*
     * Изменение записи
     * @param integer $id
     * @return boll результат операции
     * */
    public function update($id){
        $values = [];
        $updateFields = [];
        foreach ($this as $k => $v) {
            if ('id' == $k || empty($v)) {
                continue;
            }
            $values[':'.$k] = $v;
            $updateFields[] = $k.' = :'.$k;
        }
        $values[':id'] = $id;

        $sql = '
            UPDATE ' . static::TABLE . '
            SET
                ' . implode(',', $updateFields) . '
            WHERE
                id = :id
        ';

        //\Util::pr($values,'values');
        //\Util::pr($sql);
        $db = Db::instance();
        return $db->execute($sql, $values);
    }

}