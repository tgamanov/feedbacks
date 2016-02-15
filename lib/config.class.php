<?php

class Config{

    protected static $settings = array();// массив для хранения настроек

    public static function get($key){//метод для вывода настроек
        return isset(self::$settings[$key]) ? self::$settings[$key] : null;//если запрашиваемых настроек нет - выводим нулл
    }

    public static function set($key, $value){//метод сохранения настроек в массив
        self::$settings[$key] = $value;
    }

}