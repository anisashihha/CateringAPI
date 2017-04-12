<?php

class Upload extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
    }

    public function index() {
        $this->load->view('upload_form', array('error' => ' '));
    }

    public function do_upload() {
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = 100;
        $config['max_width'] = 1024;
        $config['max_height'] = 768;
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('avatar')) {
            $error = array('error' => $this->upload->display_errors());
            $this->load->view('upload_form', $error);
        } else {
            $data = array('upload_data' => $this->upload->data(), 'file' => $this->input->avatar);
            $this->load->view('upload_success', $data);
        }
    }

    public function _remap($method) {
        if ($method == 'do_upload') {
            $this->$method();
        } else {
            $this->index();
        }
    }
}
