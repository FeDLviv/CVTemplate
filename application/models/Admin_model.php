<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_model extends CI_Model
{

    public function get_password($user)
    {
        $query = $this->db->query('SELECT password FROM user WHERE name = ?;', array($user));
        if ($query->num_rows() > 0) {
            return $query->row()->password;
        } else {
            return null;
        }
    }

    public function set_contacts($data)
    {
        $name = "application/config/myconfig.php";
        $handle = fopen($name, "r");
        flock($handle, LOCK_EX);
        $content = fread($handle, filesize($name));
        $count = 0;
        foreach ($data as $key => $value) {
            if ($this->config->item('contacts')[$key] !== $value) {
                $reg ="{'".$key."'\s*=>\s*(.+)'}";
                $val = "'".$key."' => '".$value."'";
                $content = preg_replace($reg, $val, $content);
                $count++;
            }
        }
        $handle = fopen($name, "w");
        fwrite($handle, $content);
        fclose($handle);
        //if($count) change data
        return $count;
    }
}
