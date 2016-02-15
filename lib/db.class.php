<?php

class DB{
    protected $connection;//содержит информацию для подключения к базе
    public function __construct($host, $user, $password, $db_name){//метод для подключения к базе
        $this->connection = new mysqli($host, $user, $password, $db_name);
        if( mysqli_connect_error() ){//при наличчи ошибок, выводим сообщение
            throw new Exception('Could not connect to DB');//сообщение
        }
    }
    public function query($sql){//метод обращение к базе данных
        if ( !$this->connection ){//при отсутствии подключения к базе
            return false;//сообщение
        }
        $result = $this->connection->query($sql);
        if ( mysqli_error($this->connection) ){
            throw new Exception(mysqli_error($this->connection));
        }
        if ( is_bool($result) ){
            return $result;
        }
        $data = array();
        while( $row = mysqli_fetch_assoc($result) ){//mysqli_fetch_assoc возвращает значения базы данных в виде массива
            $data[] = $row;//запись очередного значения из базы в массив
        }
        return $data;//массив значений из базы
    }
    public function escape($str){
        return mysqli_escape_string($this->connection, $str);//mysqli_escape_string экранирует все спец-символы в unescaped_string
    }
}