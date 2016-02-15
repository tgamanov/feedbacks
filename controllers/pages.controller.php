<?php

class PagesController extends Controller{
    public function __construct($data = array()){
        parent::__construct($data);
        $this->model = new Page();
    }
    // pages/
    public function index(){
        // Записываем в данные информацию о всех страничках из модели Page
        $this->data['pages'] = $this->model->getList();
    }
    // view/{some_param}
    public function view(){
//        $params = App::getRouter()->getParams(); // это кажется лишнее, так как тоже самое есть у нас в $this->params
        // Если есть {some_param} в URL
        if ( isset($this->params[0]) ){
            // Приводим {SoMe_PaRAm} в нижний регистр
            $alias = strtolower($this->params[0]);
            // Из модели получаем нужную страницу {some_param}
            $this->data['page'] = $this->model->getByAlias($alias);
        }
    }
    // admin/pages
    public function admin_index(){
        // Записываем в данные информацию о всех страничках из модели Page
        $this->data['pages'] = $this->model->getList();
    }

    // admin/pages/add
    public function admin_add(){
        // Если пришел POST
        if ( $_POST ){
            // Записываем данные с $_POST в БД
            $result = $this->model->save($_POST);
            // если запись прошла успешно ($result == true)
            if ( $result ){
                Session::setFlash('Page was saved.');
            } else {
                Session::setFlash('Error.');
            }
            // перенаправляем на admin/pages/
            Router::redirect('/admin/pages/');
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
                Session::setFlash('Page was saved.');
            } else {
                Session::setFlash('Error.');
            }
            // перенаправляем на admin/pages/
            Router::redirect('/admin/pages/');
        }

        // Если пришел GET
        // если есть параметр {some_param} (например URL admin/pages/edit/1)
        if ( isset($this->params[0]) ){
            // Добавляем в данные страничку, где id == {some_param}
            $this->data['page'] = $this->model->getById($this->params[0]);
        } else {
            // если параметра {some_param} нет - записываем сообщения об этом в сессию и редиректим на admin/pages/
            Session::setFlash('Wrong page id.');
            Router::redirect('/admin/pages/');
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
                Session::setFlash('Page was deleted.');
            } else {
                // Что то пошло не так!!!
                Session::setFlash('Error.');
            }
        }
        // перенаправляем на admin/pages/
        Router::redirect('/admin/pages/');
    }
}