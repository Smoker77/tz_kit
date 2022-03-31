<?php


namespace app\models;

use app\models\Tree as TreeModel;

class Tree extends Model{
    const TABLE = 'tree';

    public $name;
    public $description;
    public $parent_id;

    public function findAllByParentId(int $id){
        $this->id = null;
        $this->name = null;
        $this->description = null;
        $this->parent_id = $id;

        return $this->findAllBy();
    }

}