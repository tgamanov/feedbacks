<?php

class ModeratorsController extends Controller
{
    public function __construct($data = array())
    {
        parent::__construct($data);
        $this->model = new Moderator();
    }

    public function who_are_you()
    {
        if (Session::get('moderator')) {
            Router::redirect('/moderators/index');
        }
        if (isset($_POST['login']) && isset($_POST['password'])) {

            $login = $_POST['login'];
            $password = md5($_POST['password']);
            if ($login == Config::get('admin_login') && $password == Config::get('admin_password')) {
                Session::set('moderator', true);
                Router::redirect('/moderators/index');
            } else {
                Router::redirect('/moderators/who_are_you');
            }
        }
    }

    public function index()
    {
        if (Session::get('moderator')) {
            $this->data = $this->model->getList();
            if (isset($_POST['update'])) {
                $id = $_POST['id_of_the_post'];
                $status = $_POST['status'];
                $this->model->update2db($id, $status);
                Router::redirect('/moderators/index');
            }
        } else {
            Router::redirect('/posts/index');
        }
    }

    public function logout()
    {
        Session::destroy();
        Router::redirect('/');
    }
}