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
class Transpass extends REST_Controller {

    function __construct() {
        // Construct the parent class
        parent::__construct();

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        // $this->methods['user_get']['limit'] = 500; // 500 requests per hour per user/key
        // $this->methods['user_post']['limit'] = 100; // 100 requests per hour per user/key
        // $this->methods['user_delete']['limit'] = 50; // 50 requests per hour per user/key
        
        $this->load->model('Transpass_model');
    }

    /**
     * 
     */
    public function index_get() {
        // Users from a data store e.g. database
        $action = $this->get('action');
        switch ($action) {
            case "update":
            $this->update();
            break;
            default:
            $this->not_found();
            break;
        }
    }

    /**
     * 
     */
    public function index_post() {
        $action = $this->input->post('action');
        switch ($action) {
            default :
            $this->not_found();
            break;
        }
    }

    /**
     * 
     */

    public function update() {
        $fidaccount = $this->get('fid');
        $lidaccount = $this->get('lid');

        $update = $this->Transpass_model->update($fidaccount, $lidaccount);
        if ($update>0) {
            $this->set_response(array(['message' => 'success']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->set_response(array(['message' => 'failed']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }
    }

    public function not_found() {
        $this->set_response([[
            'status' => FALSE,
            'message' => 'not found'
            ]], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
    }

}
