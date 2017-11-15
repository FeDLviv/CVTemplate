<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Main_model extends CI_Model
{

    public function get_contacts()
    {
        return $this->config->item('contacts');
        //$this->config->set_item('contacts', array_merge($this->config->item('contacts'), array('location' => 'Kiev')));
    }

    public function set_contacts($data)
    {
        $name = "application/config/myconfig.php";
        $handle = fopen($name, "r");
        flock($handle, LOCK_EX);
        $content = fread($handle, filesize($name));
        $count = 0;
        foreach ($data as $key => $value) {
            $value = str_replace("'", "\'", $value);
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
        return true;
    }

    public function get_education()
    {
        $query = $this->db->query('SELECT * FROM education ORDER BY start;');
        return $query->result_array();
    }

    public function get_works()
    {
        $query = $this->db->query('SELECT * FROM work ORDER BY start;');
        return $query->result_array();
    }

    public function get_skills()
    {
        $query = $this->db->query('SELECT * FROM skill ORDER BY FIELD(type, "os", "technologie", "database", "language") DESC, type, id;');
        return $query->result_array();
    }

    public function get_languages()
    {
        $query = $this->db->query('SELECT * FROM language ORDER BY level;');
        return $query->result_array();
    }
}
