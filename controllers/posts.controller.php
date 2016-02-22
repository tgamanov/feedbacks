<?php

class PostsController extends Controller
{
    public function __construct($data = array())
    {
        parent::__construct($data);
        $this->model = new Post();
    }

    public function index()
    {
        if (isset($_POST['submit']))//check if submit button has been pressed
        {
            $this->data['post'] = $this->model->getvisiblelist();
            $name = isset($_POST['name'])?$_POST['name']:null;
//            $name = $_POST['name'];
            $email = isset($_POST['email'])?$_POST['email']:null;
//            $email = $_POST['email'];
            $message = isset( $_POST['message'])? $_POST['message']:null ;
//            $message = $_POST['message'];
            $photo_path4DB = isset($photo_path4DB)?'':null;
//            $photo_path4DB = '';
            $image = isset( $_FILES['image'])? $_FILES['image']:null ;
//            $image = $_FILES['image'];

            if (isset($image))//check if file has been uploaded
            {

                $file_name = $image['name'];
                $location = 'images';

                function random_string($length)
                {
                    $key = '';
                    $keys = array_merge(range(0, 9), range('a', 'z'));

                    for ($i = 0; $i < $length; $i++) {
                        $key .= $keys[array_rand($keys)];
                    }

                    return $key;
                }
                $file_ext = isset($file_name)?explode('.',$file_name):null;
                $file_ext = strtolower(end($file_ext));
                $file_tmp = isset($image['tmp_name'])?$image['tmp_name']:null;
                $file_name = isset($file_ext)?random_string(7) . '.' . $file_ext:null;
                $photo_path4DB = isset($file_name)?DS . $location . DS . $file_name:null;

                move_uploaded_file($file_tmp, $location . '/' . $file_name);//upload photo to disk

                $convert = new SimpleImage();//resize photo to 320*240
                $convert->load($location . '/' . $file_name);
                $convert->resize(320, 240);
                $convert->save($location . '/' . $file_name);
            }
                $this->model->write2db($name, $email, $message, $photo_path4DB);
                Session::setFlash('Message has been sent for validation.');
                //Router::redirect('/');
                echo "<meta http-equiv=\"refresh\" content=\"3;url=/\" />";
        }
        $this->data = $this->model->getvisiblelist();
    }
}
