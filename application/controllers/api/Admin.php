<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
/**
 * This is an code of a few basic user interaction methods i have use
 * all done with a hardcoded array
 *
 * @package         Database Administrator
 * @subpackage      Rest Server
 * @category        Admin Web Server
 * @author1         Anisa' Shihhatin Sholihah
 * @license         DBA
 * @link            anisashihha73@gmail.com //http://anisass.wordpress.com
 */
class Admin extends REST_Controller {
    
    /**
     * 
     */
    function __construct() {
        // Construct the parent class
        parent::__construct();

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        // $this->methods['user_get']['limit'] = 500; // 500 requests per hour per user/key
        // $this->methods['user_post']['limit'] = 100; // 100 requests per hour per user/key
        // $this->methods['user_delete']['limit'] = 50; // 50 requests per hour per user/key
      
    }

    /**
     * 
     */
    public function index_get() {
        // Admins from a data store e.g. database
        $action = $this->get('action');
        switch ($action) {
            case "tes":
                $this->set_response(array(), REST_Controller::HTTP_OK);
            break;
            case "delete":
                $this->deleteFile();
            break;
            default:
                $this->not_found();
                break;
        }
    }

    public function index_post() {
        //$action = $this->input->post('action');
        $action = $this->post('action');
        switch ($action) {
            case "login":
                $this->Admin_login();
                break;
            case "upload":
                $this->upload();
                break;
        }
    }

    public function index_delete() {
        $id = (int) $this->get('id');
        // Validate the id.

        if ($id <= 0) {
            // Set the response and exit
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        // $this->some_model->delete_something($id);
        $message = [
            'id' => $id,
            'message' => 'Deleted the resource'
        ];
        $this->set_response($message, REST_Controller::HTTP_NO_CONTENT); // NO_CONTENT (204) being the HTTP response code
    }

    public function not_found() {
        $this->set_response([
            'status' => FALSE,
            'message' => 'Admin could not be found'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
    }

    /**
     * REST API Upload using native CI Upload class.
     * @param userfile - multipart/form-data file
     * @param submit - must be non-null value.
     * @return upload data array || error string
     */
    public function upload() {
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = 100;
        $config['max_width'] = 1024;
        $config['max_height'] = 768;
        $config['file_name'] = '1';
        $this->load->library('upload', $config);
        
        if (!$this->upload->do_upload('avatar')) {
            $error = array('error' => $this->upload->display_errors());
            $this->response($error, REST_Controller::HTTP_NOT_FOUND);
        } else {
            $data = array('upload_data' => $this->upload->data());
            $this->response($data, REST_Controller::HTTP_OK);
        }
    }
    
    public function deleteFile() {
        $fileName = $this->get('fileName');
        unlink('./uploads/'.$fileName);
        $this->set_response(array('status' => true), REST_Controller::HTTP_OK);
    }

    public function Admin_login() {
        //$username = $this->input->post('username');
        //$password = $this->input->post('password');
        $username = $this->post('username');
        $password = $this->input->post('password');
        //$this->load->model('user_model');
        //$user = $this->user_model->login($username, $password);
        $user = array("username" => $username, "password" => $password);
        if (!empty($user)) {
            $this->set_response($user, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

}
