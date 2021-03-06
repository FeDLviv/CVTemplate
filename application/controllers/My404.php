<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Undocumented class
 */
class My404 extends CI_Controller
{

    /**
     * Undocumented function
     *
     * @return void
     */
    public function index()
    {
        $this->output->set_status_header('404');
        $data['head'] = $this->config->item('Head');
        $data['content'] = 'Sorry, the page you are looking for could not be found';
        $this->load->view('my404_view', $data);
    }
}
