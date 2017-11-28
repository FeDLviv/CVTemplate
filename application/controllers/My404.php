<?php
defined('BASEPATH') or exit('No direct script access allowed');

class My404 extends CI_Controller
{

    public function index()
    {
        $this->output->set_status_header('404');
        $data['head'] = $this->config->item('Head');
        $data['content'] = 'Sorry, the page you are looking for could not be found';
        $this->load->view('my404_view', $data);
    }
}
