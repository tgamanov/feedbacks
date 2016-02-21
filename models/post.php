<?php
class Post extends Model
{
    public function getList()//select all messages
    {
        $sql = "select * from messages where 1 order by  date_time";
        return $this->db->query($sql);
    }
    public function getvisiblelist()//select only visible messages
    {
        $sql = "SELECT * FROM messages WHERE modified_by_admin LIKE '1' order by  date_time";
        return $this->db->query($sql);
    }
    public function write2db($name,$email,$message,$photo_path4DB)//add new messages
    {
        $name = $this->db->escape($name);
        $email = $this->db->escape($email);
        $message = $this->db->escape($message);
        $photo_path4DB =$this->db->escape($photo_path4DB) ;

        //echo $photo_path4DB;die;


        //echo $name.'<br>'.$email.'<br>'.$message.'<br>'.$photo_path4DB; die;

            $sql = "
                insert into messages
                   set name = '{$name}',
                       email = '{$email}',
                       message = '{$message}',
                       photo_path = '{$photo_path4DB}'
            ";
        return $this->db->query($sql);
    }
    public function adminupdate($id)//moderate messages status by admin
    {
        $sql = "UPDATE 'messages' SET 'modified_by_admin' = 1 WHERE 'id'= {'$id'}";
        return $this->db->query($sql);
    }
}