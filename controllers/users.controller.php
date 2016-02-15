<?php

class UsersController extends Controller{

    public function __construct($data = array()){
        parent::__construct($data);
        $this->model = new User();
    }

    // admin/users/login
    public function admin_login(){
        // Если пришел POST, в $_POST есть значения login и значения password
        if ( $_POST && isset($_POST['login']) && isset($_POST['password']) ){
            // Получаем юзера из БД по логину
            $user = $this->model->getByLogin($_POST['login']);
            // В $hash записываем md5 пароля, который пришел по POST, чтобы сравнить его с паролем из БД
            $hash = md5(Config::get('salt').$_POST['password']);
            // Если получили юзера с БД и этот юзер активен (is_active) и пароль с POST совпадает с паролем из БД
            if ( $user && $user['is_active'] && $hash == $user['password'] ){
                // Записываем в сессию логин юзера
                Session::set('login', $user['login']);
                // Записываем в сессию роль юзера
                Session::set('role', $user['role']);
            }
            // перенаправляем на /admin
            Router::redirect('/admin/');
        }
    }

    // admin/logout
    public function admin_logout(){
        // Уничтожаем все данные из сессии
        Session::destroy();
        // перенаправляем на /admin
        Router::redirect('/admin/');
    }

}