<?php

define('DS', DIRECTORY_SEPARATOR);//разделитель папок для разных операционных систем (‘/‘ или ‘\’)
define('ROOT', dirname(dirname(__FILE__)));//путь на корневую папку
define('VIEWS_PATH', ROOT.DS.'views');

require_once(ROOT.DS.'lib'.DS.'init.php');

session_start();

App::run($_SERVER['REQUEST_URI']);