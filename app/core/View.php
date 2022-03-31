<?php


namespace app\core;


class View implements \Countable{

    protected $data = [];

    public function __set($k, $v){
        $this->data[$k] = $v;
    }

    public function __get($k){
        return $this->data[$k];
    }

    public function render($contentView, $templateView = 'template_unreg.php'){
        ob_start();
            if(is_array($this->data)) {
                extract($this->data);
            }
            if (!is_readable('app/views/'.$templateView))
                throw new \app\exceptions\Core('Файл не найден: '.'app/views/'.$templateView, '404');
            include 'app/views/'.$templateView;
            $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }

    public function display($contentView, $templateView = 'template_unreg.php'){
        echo $this->render($contentView, $templateView);
    }

    public function count(){
        return count($this->data);
    }
}