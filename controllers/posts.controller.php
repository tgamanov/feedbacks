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
            $name = $_POST['name'];
            $email = $_POST['email'];
            $message = $_POST['message'];
            $photo_path4DB = '';
            $image = $_FILES['image'];
            $marker = true;
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

                $file_ext = explode('.', $file_name);
                $file_ext = strtolower(end($file_ext));
                $file_tmp = $image['tmp_name'];
                $file_name = random_string(7) . '.' . $file_ext;
                $photo_path4DB = DS . $location . DS . $file_name;
                $allowed_ext = array("jpg", "jpeg", "gif", "png");

                if (in_array($file_ext, $allowed_ext) === false) {//check if extension of the file is correct

                    echo '<div class="notice-box bg-danger padding-30">Extension of the photo is not allowed, please choose next type of the file:  JPEG, GIF or PNG.</div>';
                    echo "<meta http-equiv=\"refresh\" content=\"15;url=/\" />";
                    return $marker = false;
                } else {
                    move_uploaded_file($file_tmp, $location . '/' . $file_name);//upload photo to disk
                    $convert = new SimpleImage();//resize photo to 320*240
                    $convert->load($location . '/' . $file_name);
                    $convert->resize(320, 240);
                    $convert->save($location . '/' . $file_name);
                }


            }

            if ($marker) {
                $this->model->write2db($name, $email, $message, $photo_path4DB);
                Session::setFlash('Message has been sent for validation.');
                //Router::redirect('/');
                echo "<meta http-equiv=\"refresh\" content=\"3;url=/\" />";
            }
        }
        $this->data = $this->model->getvisiblelist();
    }
}
