<?php

class MessagesController extends Controller{
    public function __construct($data = array()){
        parent::__construct($data);
        $this->model = new Message();
    }
    // pages/
    public function index(){
        // Записываем в данные информацию о всех страничках из модели Messages
        $this->data['messages'] = $this->model->getList();
        $name = isset($_POST['name']);
        $email = isset($_POST['email']);
        $message = isset($_POST['message']);


      if ( $name && $email &&  $message && strlen ($_POST['name'])>0 && strlen ($_POST['email'])>0 && strlen ($_POST['message'])>0)//check if submit and post is not empy. TODO add validation of the email field
      {

            $res_post = $_POST;
            $this->model->save($res_post);
          Router::redirect('/');
      }
        }
    public function sortBy(){
        $this->data['messages']=$this->model->sortBy();
    }

    // view/{some_param}
    public function view(){
        $params = App::getRouter()->getParams(); // это кажется лишнее, так как тоже самое есть у нас в $this->params
        // Если есть {some_param} в URL
        if ( isset($this->params[0]) ){
            // Приводим {SoMe_PaRAm} в нижний регистр
            $message = strtolower($this->params[0]);
            // Из модели получаем нужную страницу {some_param}
            $this->data['messages'] = $this->model->getByMessage($message);
        }
    }
    // admin/pages
    public function admin_index(){
        // Записываем в данные информацию о всех страничках из модели Page
        $this->data['messages'] = $this->model->getList();
    }

    // admin/pages/add
    public function admin_add(){
        // Если пришел POST
        if ( $_POST ){
            // Записываем данные с $_POST в БД
            $result = $this->model->save($_POST);
            // если запись прошла успешно ($result == true)
            if ( $result ){
                Session::setFlash('Message has been saved.');
            } else {
                Session::setFlash('Error.');
            }
            // перенаправляем на admin/pages/
            Router::redirect('/admin/messages/');
        }
    }

    // admin/pages/edit/[{some_param}]
    public function admin_edit(){
        // Если пришел POST
        if ( $_POST ){
            // Если в $_POST есть значения id, то записываем его. Если нет, то null
            $id = isset($_POST['id']) ? $_POST['id'] : null;
            // Записываем данные с $_POST в БД. Если $id == null - это новая запись, если нет - изменить старую запись с id == $id
            $result = $this->model->save($_POST, $id);
            // если запись прошла успешно ($result == true)
            if ( $result ){
                Session::setFlash('Messages has been saved.');
            } else {
                Session::setFlash('Error.');
            }
            // перенаправляем на admin/pages/
            Router::redirect('/admin/messages/');
        }

        // Если пришел GET
        // если есть параметр {some_param} (например URL admin/pages/edit/1)
        if ( isset($this->params[0]) ){
            // Добавляем в данные страничку, где id == {some_param}
            $this->data['messages'] = $this->model->getById($this->params[0]);
        } else {
            // если параметра {some_param} нет - записываем сообщения об этом в сессию и редиректим на admin/pages/
            Session::setFlash('Wrong messages id.');
            Router::redirect('/admin/messages/');
        }
    }

    // admin/pages/delete/{some_param}
    public function admin_delete(){
        // если есть параметр {some_param} (например URL admin/pages/delete/1)
        if ( isset($this->params[0]) ){
            // Удаляем страничку, где id == {some_param}
            $result = $this->model->delete($this->params[0]);
            if ( $result ){
                // Если удалили
                Session::setFlash('Messages has been deleted.');
            } else {
                // Что то пошло не так!!!
                Session::setFlash('Error.');
            }
        }
        // перенаправляем на admin/pages/
        Router::redirect('/admin/messages/');
    }
}
