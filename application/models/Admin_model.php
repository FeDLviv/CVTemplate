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

    public function set_contacts($data) {
        $fname = "application/config/myconfig.php";
        $fhandle = fopen($fname,"r");
        $content = fread($fhandle, filesize($fname));
        
        foreach ($data as $key => $value) {
            //$reg = "/'".$key."' => ?/";
            $content = str_replace($key, $value, $content);    
        }
                       
        $fhandle = fopen($fname,"w");
        fwrite($fhandle,$content);
        fclose($fhandle);
        
        return true;
    }
}
