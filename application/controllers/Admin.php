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

    public function _remap()
    {
        //admin_model
        if ($this->session->test == 'my') {
            $this->session->unset_userdata('test');
            //$this->session->sess_destroy();
            $this->index();
        } else {
            $this->session->set_userdata(['test'=>'my']);
            $this->login();
        }
    }

    public function index()
    {
        $this->load->view('admin_view');
    }

    public function login()
    {
        echo "LOGIN";
    }

    public function authentication()
    {
    }

    public function ajax_logout()
    {
    }
}
