<?php
class Moderator extends Model
{
    public function getList()//select all messages
    {

        $sql = "select * from messages where 1 order by  date_time";
        return $this->db->query($sql);
    }

    public function update_message_status2db($id,$status)//put messages to live
    {
        $id = (int)$id;
        $status = $this->db->escape($_POST['status']);
        if ($status == 1)
        {
            $sql = "UPDATE messages SET modified_by_admin = '1' WHERE id = {$id}";
        }
        else
        {
            $sql = "UPDATE messages SET modified_by_admin = '0' WHERE id = {$id}";
        }

        return $this->db->query($sql);
    }
    public function update_message2db($id,$modified_message)
    {
        $id = (int)$id;
        $modified_message = $this->db->escape ($modified_message);
        $sql = "UPDATE messages SET message = '{$modified_message}' WHERE id = {$id}";
        return $this->db->query($sql);
    }
}