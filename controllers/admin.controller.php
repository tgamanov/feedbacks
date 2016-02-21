<?php


class UsersController extends Controller
{

    public function __construct($data = array())
    {
        parent::__construct($data);
        $this->model = new User();
    }


    public function moderate()
    {
        if (isset ($_POST['send'])) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $message = $_POST['message'];
            $id = $_POST['id'];

            $message = $this->model->getById($id);

            if ($post['name'] != $name || $post['email'] != $email || $post['message'] != $message || $post['admin_redact'] == 1) {
                $redact = 1;
            }

            $visibility = ($_POST['visible'] == 'on') ? "1" : "0";

            if ($this->model->edit_post($id, $name, $email, $message, $redact, $approved)) {
                Router::redirect('/admin/posts/index');
            } else {
                throw new Exception("Не удалось сохранить изменения");
            }
        }
        $param = App::getRouter();
        $id = $param->getParams()['0'];
        $this->data = $this->model->getById($id);
    }
    public function admin_logout()
    {
        Session::destroy();
        Router::redirect('/admin/posts/');
    }


}
