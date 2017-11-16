<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Main_model extends CI_Model
{

    public function set_settings($data) 
    {
        $name = "application/config/myconfig.php";
        $handle = fopen($name, "r");
        flock($handle, LOCK_EX);
        $content = fread($handle, filesize($name));
        $count = 0;
        foreach ($data as $key => $value) {
            $value = str_replace("'", "\'", $value);
            if ($this->config->item($key) !== $value) {
                $reg = "{config\['".$key."'\]\s*=\s*(.+)'}";
                $val = "config['".$key."'] = '".$value."'";
                $content = preg_replace($reg, $val, $content);
                $count++;
            }
        }
        if($count) {
            $content = $this->set_last_change($content);
        }
        $handle = fopen($name, "w");
        fwrite($handle, $content);
        fclose($handle);
        return true;
    }

    public function get_contacts()
    {
        return $this->config->item('contacts');
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
                $reg = "{'".$key."'\s*=>\s*(.+)'}";
                $val = "'".$key."' => '".$value."'";
                $content = preg_replace($reg, $val, $content);
                $count++;
            }
        }
        if($count) {
            $content = $this->set_last_change($content);
        }
        $handle = fopen($name, "w");
        fwrite($handle, $content);
        fclose($handle);
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

    public function delete_language($id) {
        $this->db->delete('language', array('id' => $id));
        //if update date change
        return $this->db->affected_rows(); 
    }

    public function update_language($col, $val, $id) {
        $this->db->update('language', array($col => $val), array('id' => $id));
        //if update date change
        return $this->db->affected_rows(); 
    }

    public function set_last_change($content) {
        $reg ="{config\['Last_change'\]\s*=\s*(.+)'}";
        $val = "config['Last_change'] = '".date('Y-m-d')."'";
        return preg_replace($reg, $val, $content);
    }

    public function clean_path_to_file($key) {
        $name = "application/config/myconfig.php";
        $handle = fopen($name, "r");
        flock($handle, LOCK_EX);
        $content = fread($handle, filesize($name));
        $reg ="{config\['".$key."'\]\s*=\s*(.+)'}";
        $val = "config['".$key."'] = ''";
        $content = preg_replace($reg, $val, $content);
        $content = $this->set_last_change($content);
        $handle = fopen($name, "w");
        fwrite($handle, $content);
        fclose($handle);
        return true;
    }
}
