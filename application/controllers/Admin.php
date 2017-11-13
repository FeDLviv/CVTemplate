<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('admin_model');
    }

    public function _remap($method)
    {
        switch ($method) {
            case 'logout':
            case 'authentication':
                $this->$method();
                break;
            default:
                if (($this->session->has_userdata('user') && $this->session->browser == $this->input->user_agent() && $this->session->address == $this->input->ip_address())) {
                    $this->index();
                } else {
                    $this->login();
                }
                break;
        }
    }

    public function index()
    {
        $this->load->view('admin_view');
    }

    public function login()
    {
        $this->load->helper(array('form'));
        $this->load->view('login_view');
    }

    public function authentication()
    {
        $this->load->library('form_validation');
        //to config
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        
        if ($this->form_validation->run() == true) {
            $pas = $this->admin_model->get_password($this->input->post("user"));
            if (isset($pas) && password_verify($this->input->post("password"), $pas)) {
                $this->session->set_userdata(
                    [
                        'user'=>$this->input->post("user"),
                        'browser'=>$this->input->user_agent(),
                        'address'=>$this->input->ip_address()
                    ]
                );

                redirect('/admin');
            } else {
                //password not hash
                $this->load->view('login_view');
            }
        } else {
            $this->load->view('login_view');
        }
    }

    public function logout()
    {
        //$this->input->is_ajax_request();
        //$this->input->server('REQUEST_METHOD') == 'POST';
        $this->session->sess_destroy();
        redirect('/admin');
    }
}
