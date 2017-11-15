<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->helper('form');
    }

    public function _remap($method)
    {
        if ($method == 'logout') {
            $this->$method();
        } else {
            if (($this->session->has_userdata('user') && $this->session->browser == $this->input->user_agent() && $this->session->address == $this->input->ip_address())) {
                if ($this->input->is_ajax_request()) {
                    $this->$method();
                } else {
                    $this->index();
                }
            } else {
                $this->login();
            }
        }
    }

    public function index()
    {
        $data['settings'] = [
            'Head' => $this->config->item('Head'),
            'Title' => $this->config->item('Title'),
            'CV_path' => $this->config->item('CV_path'),
            'Photo_path' => $this->config->item('Photo_path'),
        ];
        $data['contacts'] = $this->main_model->get_contacts();
        $this->load->view('admin_view', $data);
    }

    public function login()
    {
        $this->load->model('admin_model');
        if ($this->form_validation->run() == true) {
            $pas = $this->admin_model->get_password($this->input->post('user', true));
            if (isset($pas) && password_verify($this->input->post('password', true), $pas)) {
                $this->session->set_userdata(
                    [
                        'user'=>$this->input->post('user', true),
                        'browser'=>$this->input->user_agent(),
                        'address'=>$this->input->ip_address()
                    ]
                );
                redirect('/admin');
            } else {
                $this->load->view('login_view', ['msg'=>'The username or password is incorrect']);
            }
        } else {
            $this->load->view('login_view');
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('/admin');
    }

    public function ajax_contact()
    {
        $result = [
            'complete' => false,
            'html' => null
        ];
        if ($this->form_validation->run() == true) {
            $result['complete'] = $this->main_model->set_contacts($this->input->post());
        } else {
            $result['html'] = validation_errors();
        }
        echo json_encode($result);
    }

    public function ajax_settings()
    {
        $result = [
            'complete' => false,
            'html' => null
        ];
        //update head
        if ($this->form_validation->run() == true) {
            $result['complete'] = $this->main_model->set_settings($this->input->post());
        } else {
            $result['html'] = validation_errors();
        }
        echo json_encode($result);
    }

    public function ajax_deleteFile()
    {
        switch ($this->input->post('name')) {
            case 'CV_path':
            case 'Photo_path':
                $path = $this->config->item($this->input->post('name'));
                if (file_exists($path) && unlink($path)) {
                    $this->main_model->clean_path_to_file($this->input->post('name'));
                    echo true;
                } else {
                    echo false;
                }
                break;
            default:
                echo false;
                break;
        }
    }
}
