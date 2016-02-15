<?php

class ContactsController extends Controller{

    public function __construct($data = array()){
        parent::__construct($data);
        // Добавляем модель к этому контроллеру
        $this->model = new Message();
    }

    // contacts/
    public function index(){
        // Если запрос пришел через POST
        if ( $_POST ){
            // Сохраняем данные с $_POST в БД
            if ( $this->model->save($_POST) ){
                // Если данные сохранились - записываем в сессию сообщения
                Session::setFlash('Thank you! Your message was sent successfully!');
            }
        }
    }

    // Страница контактов с роутом admin (/admin/contacts)
    public function admin_index(){
        // Записать в массив $data список сообщений
        $this->data = $this->model->getList();
    }
}