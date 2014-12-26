<?php

abstract class Controller
{

    protected $data = array();
    protected $view = "";
    protected $head =
        array(
            "title" => "",
            "description" => "",
            "key_words" => ""
        );

    abstract function process($parameters);

    public function printView(){
        if($this->view){
            extract($this->data);
            require("views/" . $this->view . ".phtml");
        }
    }

    public function redirect($url){
        header("Location: /$url");
        header("Connection: Close");
        exit;
    }

}