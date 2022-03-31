<?php

namespace app\controllers;

use app\core\Controller;
use app\models\Tree as TreeModel;
use app\core\Db;
use app\exceptions\Core;

class Tree extends Controller{
    private $treeModel;
    private $chieldArr;
    public $tree;

    public function __construct(){
        parent::__construct();
        $this->treeModel = new TreeModel();
    }

    public function actionTest(){
        //echo static::get_treeTest();
        echo $this->getTree();

        //echo $this->build_selectOption(null, true);
        //echo $this->build_selectOption(5, false);
        //echo $this->build_selectOption(5, true);

        \Util::pr($this->getChieldArr(11));

        die('<br>End');
    }

    public function actionGetTree(){
        echo $this->getTree();
    }

    public function actionGetSelectOption(){
        //\Util::pr($_POST);
        $isEmpty = (trim($_POST['empty'])=='false')?false:true;
        $selected = (trim($_POST['selected'])=='null')?null:(int) $_POST['selected'];

        echo $this->build_selectOption($selected, $isEmpty);
    }

    /*
     * Добавление элемента в дерево
     * */
    public function actionAddTreeItem(){
        $msg = '';
        if(empty($_POST['name']))
            $msg .= 'Необходимо указать имя элемента'.'<br>';
        if(empty($_POST['description']))
            $msg .= 'Необходимо указать описание элемента'.'<br>';
        if(empty($_POST['parent']))
            $msg .= 'Родитель не указан'.'<br>';
        if(!empty($msg))
            echo $msg;

        $this->treeModel->name = $_POST['name'];
        $this->treeModel->description = $_POST['description'];
        $this->treeModel->parent_id = (int) $_POST['parent'];

        if ($this->treeModel->insert())
            echo 'ok';
        else
            echo 'Ошибка добавления элемента в БД';
    }

    /*
    * Редактирование элемента в дерево
    * */
    public function actionEditTreeItem(){
        $msg = '';
        if(empty($_POST['name']))
            $msg .= 'Необходимо указать имя элемента'.'<br>';
        if(empty($_POST['description']))
            $msg .= 'Необходимо указать описание элемента'.'<br>';
        if(empty($_POST['parent']))
            $msg .= 'Родитель не указан'.'<br>';
        if(empty($_POST['treeitem']))
            $msg .= 'Элемент дле редактирования не выбран'.'<br>';
        if(!empty($msg))
            echo $msg;

        $this->treeModel->name = $_POST['name'];
        $this->treeModel->description = $_POST['description'];
        $this->treeModel->parent_id = (int) $_POST['parent'];

        if ($this->treeModel->update((int) $_POST['treeitem']))
            echo 'ok';
        else
            echo 'Ошибка добавления элемента в БД';
    }

    /*
    * Редактирование элемента в дерево
    * */
    public function actionDelTreeItem(){
        $msg = '';
        if(empty($_POST['treeitem']))
            $msg .= 'Элемент дле удаления не выбран'.'<br>';
        if(!empty($msg))
            echo $msg;

        //\Util::pr('actionDelTreeItem');
        //\Util::pr($_POST['treeitem']);

        $chieldIdArr = $this->getChieldArr((int) $_POST['treeitem']);
        $chieldIdArr[] = $_POST['treeitem'];
        foreach ($chieldIdArr as $k=>$v){
            //echo 'На удаление: id='.$v.'   ('.$_POST['name'].')'.'<br>';
            if(!$this->treeModel::deleteById($v))
                $msg .= 'Ошибка удаления элемента id='.$v.'<br>';
        }

    if(empty($msg))
        echo 'ok';
    else
        echo 'Ошибка добавления элемента в БД';
    }

    public function getTree(){
        if(empty($this->tree))
            $this->build_tree();
        return $this->tree;
    }

    public function getChieldArr($parent_id = 0){
        $this->chieldArr = [];

        $this->build_chieldArr($parent_id);
        return $this->chieldArr;
    }

    /*
     * Строит массив со всеми детьми
     * */
    private function build_chieldArr($parent_id = 0){
        $result = $this->treeModel->findAllByParentId($parent_id);
        foreach ($result as $row){
            $this->chieldArr[] = $row->id;
            $this->build_chieldArr($row->id);
        }
    }


/*
 * Построение списка Option для Select
 * @param integer|null $selected id выбранного элемента или null
 * @param bool $empty Пустой элемент первый
 * */
    private function build_selectOption(int $selected = null, $empty = false){
        $optionList = '';
        $result = $this->treeModel::findAll();
        if($empty && ($empty!=false)){
            $isSelected = ($selected === 0)?true:false;
            $optionList .= $this->wrapOption(null, $isSelected);
        }
        foreach ($result as $row){
            $isSelected = ($selected && $row->id == $selected)?true:false;
            $optionList .= $this->wrapOption($row, $isSelected);
        }

        return $optionList;
    }

    /*
     * Обертка в тег Option
     * @param object|null $item  объект для оборачивания
     * @param bool $isSelected Выбран элемент или нет
     * */
    private function wrapOption($item, bool $isSelected){
        if(empty($item)){
            $this->view->id = 0;
            $this->view->name = '';
        }else{
            $this->view->id = $item->id;
            $this->view->name = $item->name;
        }
        $this->view->isSelected = $isSelected;

        return $this->view->render('','template_treeListOption.php');
    }






    private function build_tree($parent_id = 0, $prefix = ""){
        $result = $this->treeModel->findAllByParentId($parent_id);
//        foreach ($result as $row){
//            $this->tree .= $prefix.$row->name."<br>";
//            static::build_tree($row->id, $prefix."&nbsp;&nbsp;");
//        }

        $this->tree .= (count($result)==0)?'':'<ul>';
        foreach ($result as $row){
            //$this->tree .= '<li>'.$prefix.$row->name.'</li>';
            $this->tree .= $this->wrapItemLi($row, $prefix);
            $this->build_tree($row->id, $prefix."&nbsp;&nbsp;");
        }
        $this->tree .= (count($result)==0)?'':'</ul>';
    }


    private function wrapItemLi(object $item, string $prefix){
        //return '<li>'.$prefix.$item->name.'</li>';

        $this->view->id = $item->id;
        $this->view->parent_id = $item->parent_id;
        $this->view->name = $item->name;
        $this->view->description = $item->description;
        $this->view->prefix = $prefix;

        if(\app\models\User::checkAuthorized())
            return $this->view->render('','template_treeNodeReg.php');
        else
            return $this->view->render('','template_treeNodeUnReg.php');
    }
}

