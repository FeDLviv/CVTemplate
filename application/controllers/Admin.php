<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Undocumented class
 */
class Admin extends CI_Controller
{
    
    /**
     * Undocumented function
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->helper('form');
    }

    /**
     * Undocumented function
     *
     * @param [type] $method
     * @return void
     */
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

    /**
     * Undocumented function
     *
     * @return void
     */
    public function index()
    {
        $data['settings'] = [
        'Head' => $this->config->item('Head'),
        'Title' => $this->config->item('Title'),
        'CV_path' => $this->config->item('CV_path'),
        'Photo_path' => $this->config->item('Photo_path'),
        ];
        $data['contacts'] = $this->main_model->get_contacts();
        $data['tables'] = $this->main_model->get_tables_fields_list();
        $data['education'] = $this->main_model->get_education();
        $data['works'] = $this->main_model->get_works();
        $data['skills'] = $this->main_model->get_skills();
        $data['languages'] = $this->main_model->get_languages();
        $this->load->view('admin_view', $data);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
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

    /**
     * Undocumented function
     *
     * @return void
     */
    public function logout()
    {
        $this->session->sess_destroy();
        redirect('/admin');
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function ajax_settings()
    {
        $this->load->library('upload');
        $result = [
        'complete' => false,
        'html' => null,
        'cv' => '',
        'photo' => ''
        ];
        if ($this->form_validation->run() == true) {
            $cv = $this->_upload_file('CV_path');
            $photo = $this->_upload_file('Photo_path');
            if ($cv['path'] !== null && $photo['path'] !== null) {
                $data = $this->input->post();
                $data['CV_path'] = $cv['path'];
                $data['Photo_path'] = $photo['path'];
                $result['cv'] = $data['CV_path'];
                $result['photo'] = $data['Photo_path'];
                $result['complete'] = $this->main_model->set_settings($data);
            } else {
                $result['html'] = $cv['html'];
                $result['html'] .= $photo['html'];
            }
        } else {
            $result['html'] = validation_errors();
        }
            echo json_encode($result);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function ajax_delete_file()
    {
        switch ($this->input->post('name')) {
            case 'CV_path':
            case 'Photo_path':
                $path = $this->config->item($this->input->post('name'));
                if (file_exists($path) && unlink($path)) {
                    $this->main_model->set_setting_by_name($this->input->post('name'), '');
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

    /**
     * Undocumented function
     *
     * @return void
     */
    public function ajax_change_password() {
        $result = [
            'complete' => false,
            'html' => null
        ];
        if ($this->form_validation->run() == true) {
            $user = $this->input->post('user');
            $oldPas = $this->input->post('oldPas');
            $newPas = $this->input->post('newPas');
            $this->load->model('admin_model');
            $result['complete'] = $this->admin_model->set_password($user, $oldPas, $newPas);
        } else {
            $result['html'] = validation_errors();
        }
        echo json_encode($result);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
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

    /**
     * Undocumented function
     *
     * @return void
     */
    public function ajax_insert_education() 
    {
        if ($this->form_validation->run() == true) {
            $data = $this->input->post();
            $data['speciality'] = empty($data['speciality']) ? null : $data['speciality'];
            $data['specialization'] = empty($data['specialization']) ? null : $data['specialization'];
            $data['stop'] = empty($data['stop']) ? null : $data['stop'];
            $result = $this->main_model->insert_education($data);
            if (is_array($result)) {
                echo json_encode($result);
            } else {
                $this->output->set_status_header('400');
                echo $result;
            }
        } else {
            $this->output->set_status_header('400');
            echo $this->form_validation->error_string();
        }
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function ajax_insert_work() 
    {
        if ($this->form_validation->run() == true) {
            $data = $this->input->post();
            $data['stop'] = empty($data['stop']) ? null : $data['stop'];
            $result = $this->main_model->insert_work($data);
            if (is_array($result)) {
                echo json_encode($result);
            } else {
                $this->output->set_status_header('400');
                echo $result;
            }
        } else {
            $this->output->set_status_header('400');
            echo $this->form_validation->error_string();
        }
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function ajax_insert_skill()
    {
        if ($this->form_validation->run() == true) {
            $result = $this->main_model->insert_skill($this->input->post());
            if (is_array($result)) {
                echo json_encode($result);
            } else {
                $this->output->set_status_header('400');
                echo $result;
            }
        } else {
            $this->output->set_status_header('400');
            echo $this->form_validation->error_string();
        }
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function ajax_insert_language()
    {
        if ($this->form_validation->run() == true) {
            $result = $this->main_model->insert_language($this->input->post());
            if (is_array($result)) {
                echo json_encode($result);
            } else {
                $this->output->set_status_header('400');
                echo $result;
            }
        } else {
            $this->output->set_status_header('400');
            echo $this->form_validation->error_string();
        }
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function ajax_skill_type_enum()
    {
        echo json_encode($this->main_model->get_enums('skill', 'type'));
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function ajax_skill_level_enum()
    {
        echo json_encode($this->main_model->get_enums('skill', 'level'));
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function ajax_language_enum()
    {
        echo json_encode($this->main_model->get_enums('language', 'level'));
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function ajax_delete_row()
    {
        $table = $this->input->post('table');
        $id = $this->input->post('id');
        echo $this->main_model->delete_row($table, $id);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function ajax_update_row()
    {
        $table = $this->input->post('table');
        $id = $this->input->post('pk');
        $col = $this->input->post('name');
        switch ($col) {
            case 'speciality':
            case 'specialization':
            case 'stop':
                $val = empty($this->input->post('value'))? null : $this->input->post('value');
                break;
            default:
                $val = $this->input->post('value');
                break;
        }
        $result = $result = $this->main_model->update_row($table, $id, $col, $val);
        if ($result === true) {
            echo date('Y-m-d H:i:s');
        } else {
            $this->output->set_status_header('400');
            echo $result;
        }
    }

    /**
     * Undocumented function
     *
     * @param [type] $key
     * @return void
     */
    private function _upload_file($key)
    {
        $result = [
            'path' => null,
            'html' => null
        ];
        if ($_FILES[$key]['size'] <= 0) {
            $result['path'] = $this->config->item($key);
        } else {
            $tmp = null;
            $config['overwrite'] = true;
            $config['max_size'] = 2000;
            switch ($key) {
                case 'CV_path':
                    $config['upload_path']  = './files/';
                    $config['allowed_types'] = 'pdf';
                    $config['file_name'] = 'cv';
                    $tmp = 'files/cv.pdf';
                    break;
                case 'Photo_path':
                    $config['upload_path']  = './images/';
                    $config['allowed_types'] = 'png';
                    $config['file_name'] = 'photo';
                    $tmp = 'img/photo.png';
                    break;
                default:
                    break;
            }
            $this->upload->initialize($config);
            if ($this->upload->do_upload($key)) {
                $result['path'] = $tmp;
            } else {
                $result['html'] = $this->upload->display_errors();
            }
        }
        return $result;
    }

    /**
     * Undocumented function
     *
     * @param [type] $val
     * @return boolean
     */
    public function is_date($val)
    {
        if(preg_match('/[^A-Za-z0-9\.\/\\\\]|\..*\.|\.$/', $val)) {
            $test  = explode('-', $val);
            if (checkdate($test[1], $test[2], $test[0])) {
                return true;
            } else {
                $this->form_validation->set_message('is_date', 'The {field} field is not a date.');
                return false;
            }
        } else if($val !== '') {
            $this->form_validation->set_message('is_date', 'The {field} is not in the correct format.');
            return false;
        } else {
            return true;
        }
    }
}
