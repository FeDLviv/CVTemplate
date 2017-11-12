<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Main_model extends CI_Model
{

    public function get_contacts()
    {
        return $this->config->item('contacts');
        //$this->config->set_item('contacts', array_merge($this->config->item('contacts'), array('location' => 'Kiev')));
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
