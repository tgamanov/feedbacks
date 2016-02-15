<?php

class Controller{
    protected $data; // Данные, которые потом будем использовать на view
    protected $model; // Модель, для получения данных с БД
    protected $params; // Параметры, которые пришли в URL (/<controller>/<action>/{param1}/{param2}/.../{paramN})
    public function getData(){
        return $this->data;
    }
    public function getModel(){
        return $this->model;
    }
    public function getParams(){
        return $this->params;
    }
    public function __construct($data = array()){
        $this->data = $data;
        // Параметры берем из созданого ранее роутера
        $this->params = App::getRouter()->getParams();
    }
}