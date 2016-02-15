<?php

class Router{

    protected $uri;
    protected $controller;
    protected $action;
    protected $params;
    protected $route;
    protected $method_prefix;
    protected $language;
    public function getUri()
    {
        return $this->uri;
    }
    public function getController()
    {
        return $this->controller;
    }
    public function getAction()
    {
        return $this->action;
    }
    public function getParams()
    {
        return $this->params;
    }
    public function getRoute()
    {
        return $this->route;
    }
    public function getMethodPrefix()
    {
        return $this->method_prefix;
    }
    public function getLanguage()
    {
        return $this->language;
    }
    public function __construct($uri){//разбираем путь запроса на элементы
        $this->uri = urldecode(trim($uri, '/'));//urldecode - Возвращает строку, в которой все не алфавитно-числовые символы (кроме -_.) заменены на знак процентов (%) с последующими двумя 16-ричными цифрами и пробелами, кодированными как знаки плюс (+).trim — Удаляет пробелы (или другие символы) из начала и конца строки
        // Get defaults
        $routes = Config::get('routes');//запрашиваем из массива config.class.php данные заданные из config.php
        // получив routes=array('default' => '','admin'   => 'admin_',)  в переменные объекта присваеваем значения из файла /config/config.php
        $this->route = Config::get('default_route');//'default_route'=>'default'
        $this->method_prefix = isset($routes[$this->route]) ? $routes[$this->route] : '';// $method_prefix присваиваем $route=array('default' => '','admin'   => 'admin_',) либо пустоту если в значения нет
        $this->language = Config::get('default_language');//'default_language','en'from config.php
        $this->controller = Config::get('default_controller');//'default_controller', 'pages'
        $this->action = Config::get('default_action');
        $uri_parts = explode('?', $this->uri);//'default_action', 'index'//array explode ( string separator, string string [, int limit] ) -  разделили запрос символом ? на значения до и после "?" и записали их в массив 
        // Get path like /lng/controller/action/param1/param2/.../...
        $path = $uri_parts[0];//1е значение массива (кусок запроса до знака "?")
        $path_parts = explode('/', $path);//разбиваем его на составляющие между знаками "/" и записываем в массив
        if ( count($path_parts) ){//при условии наличия записей в полученном массиве
            // Get route or language at first element
            if ( in_array(strtolower(current($path_parts)), array_keys($routes)) ){ //in_array — Проверяет, присутствует ли в массиве array_keys($routes) значение current($path_parts)) и возвращает true если значение было найдено. 
                //strtolower - приводит строки к маленьким буквам 
                //current - Значение массива, на который указывает указатель 0й элемент по умолчанию)
                //array_keys() возвращает числовые и строковые ключи, содержащиеся в массиве array. 
                //В результате, если  в ключах массива $routes ('default' => '','admin'   => 'admin_',) найдено 0е значение (1й элемент из разобранного пути) мы ПЕРЕприсваиваем: 
                $this->route = strtolower(current($path_parts));//переменной объекта route = 1е слово из пути  - (default или admin) 
                $this->method_prefix = isset($routes[$this->route]) ? $routes[$this->route] : '';//если настройки  routes заданы, присваиваем method_prefix их значение (в нашем случае аrray('default'=>'','admin'=>'admin_',) 
                array_shift($path_parts);//удаляем из массива 1е значение, смещаем курсор в массиве $path_parts на  2е значение разобранного запроса 
                //$route в 1м значении массива не найден - ищем там язык
            } elseif ( in_array(strtolower(current($path_parts)), Config::get('languages')) ){//значение ключа  массива не найдено, присваиваем: 
                $this->language = strtolower(current($path_parts));//переменной объекта language значение 1го слова  из разобранного пути
                array_shift($path_parts);//смещаем курсор массива на 2е слово разобранного пути
            }
            // Get controller - (next element of array if route has been found)
            if ( current($path_parts) ){//если в пути есть значения
                $this->controller = strtolower(current($path_parts));//присваиваем 1е значение из пути в controller (2е если 1м был route или language)
                array_shift($path_parts);//удаляем текущее занчение массива и переходим к следующему значению (2му или 3му)
            }
            // Get action
            if ( current($path_parts) ){//если в пути есть значения
                $this->action = strtolower(current($path_parts));//присваиваем 2е (или 3е) значение из пути в action
                array_shift($path_parts);//удаляем текущее занчение массива и переходим к следующему значению (3му или 4му)
            }
            // Get params - all the rest
            $this->params = $path_parts;//оставшиеся
        }
       // echo "<pre>";echo "path_parts = ";print_r($path_parts); echo "route ="." ".$this->route."<br>"; echo "method_prefix ="." ".$this->method_prefix."<br>"; echo "language ="." ".$this->language."<br>";echo "controller =".$this->controller."<br>"; echo "actions = ".$this->action."<br>";echo "params = ";echo "<pre>";print_r($this->params);die;
    }
    public static function redirect($location){//используется для перенаправлению по сайту
        header("Location: $location");
    }
}