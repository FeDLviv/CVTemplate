<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Main extends CI_Controller
{

    public function index()
    {
        $data = [];
        $this->_add_settings($data);
        $data['contacts'] = $this->main_model->get_contacts();
        $data['education'] = $this->_rendererData($this->main_model->get_education());
        $data['works'] = $this->_rendererData($this->main_model->get_works());
        $data['skills'] = $this->_groupSkills($this->main_model->get_skills());
        $data['languages'] = $this->_rendererData($this->main_model->get_languages());
        $this->load->view('main_view', $data);
    }

    private function _add_settings(&$data)
    {
        $data['head'] = $this->config->item('head');
        $data['title'] = $this->config->item('title');
        $data['CV_path'] = $this->config->item('CV_path');
        $data['photo_path'] = $this->config->item('photo_path');
        $data['last_change'] = $this->config->item('last_change');
    }

    private function _rendererData($data)
    {
        foreach ($data as &$row) {
            foreach ($row as $key => $val) {
                switch ($key) {
                    case 'id':
                        unset($row[$key]);
                        break;
                    case 'start':
                        $row[$key] = date('Y', strtotime($row[$key]));
                        break;
                    case 'stop':
                        if (isset($row[$key])) {
                            $row[$key] = date('Y', strtotime($row[$key]));
                        } else {
                            $row[$key] = 'Present';
                        }
                        break;
                }
            }
        }
        return $data;
    }

    private function _groupSkills($data)
    {
        $result = [];
        foreach ($data as $row) {
            $result[$row['type']][] = [
                'name' => $row['name'],
                'level' =>  $row['level']
            ];
        }
        return $result;
    }
}
