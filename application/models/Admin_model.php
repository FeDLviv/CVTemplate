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

    public function set_password($user, $oldPas, $newPas)
    {
        $query = $this->db->query('SELECT id, password FROM user WHERE name = ?;', array($user));
        if ($query->num_rows() > 0 && password_verify($oldPas, $query->row()->password)) {
            $newPas = password_hash($newPas, PASSWORD_DEFAULT);
            $this->db->update('user', array('password' => $newPas), array('id' => $query->row()->id));
            if ($this->db->affected_rows()) {
                return true;
             } else {
                return false;
            }
        } else {
            return false;
        }
    }
    
}
