<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Main_model extends CI_Model
{

    public function get_tables_fields_list()
    {
        $result;
        $tables = $this->db->list_tables();
        foreach ($tables as $table) {
            if ($table === 'user') {
                continue;
            } else {
                $result[$table] = $this->db->list_fields($table);
            }
        }
        return $result;
    }

    public function get_enums($table, $column)
    {
        $enums = [];
        preg_match_all("/'(.*?)'/", $this->db->query("SHOW COLUMNS FROM {$table} LIKE '{$column}'")->row()->Type, $matches);
        foreach ($matches[1] as $key => $value) {
            $enums[$value] = $value;
        }
        return $enums;
    }

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
        if ($count) {
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
        if ($count) {
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

    public function delete_row($table, $id)
    {
        $this->db->delete($table, array('id' => $id));
        $result = $this->db->affected_rows();
        if ($result) {
            $this->set_setting_by_name('Last_change', date('Y-m-d'));
        }
        return $result;
    }

    public function update_row($table, $id, $col, $val)
    {
        $this->db->update($table, array($col => $val), array('id' => $id));
        if ($this->db->affected_rows()) {
            $this->set_setting_by_name('Last_change', date('Y-m-d'));
            return true;
        } else {
            return $this->db->error()['message'];
        }
    }

    public function set_setting_by_name($key, $value)
    {
        $name = "application/config/myconfig.php";
        $handle = fopen($name, "r");
        flock($handle, LOCK_EX);
        $content = fread($handle, filesize($name));
        $reg ="{config\['".$key."'\]\s*=\s*(.+)'}";
        $val = "config['".$key."'] = '".$value."'";
        $content = preg_replace($reg, $val, $content);
        $content = $this->set_last_change($content);
        $handle = fopen($name, "w");
        fwrite($handle, $content);
        fclose($handle);
        return true;
    }

    private function set_last_change($content)
    {
        $reg ="{config\['Last_change'\]\s*=\s*(.+)'}";
        $val = "config['Last_change'] = '".date('Y-m-d')."'";
        return preg_replace($reg, $val, $content);
    }
}
