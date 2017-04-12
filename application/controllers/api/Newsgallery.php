<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * This is an code of a few basic user interaction methods i have use
 * all done with a hardcoded array
 *
 * @package         Database Administrator
 * @subpackage      Rest Server
 * @category        Admin Web Server
 * @author          Shaquille Akbar Demsi
 * @license         DBA
 * @link            zakiakbardemsi@gmail.com
 */

/**
 * Description of Newsgallery
 *
 * @author Shaquille Akbar Demsi
 * 21 March 2017
 */
require APPPATH . '/libraries/REST_Controller.php';

class Newsgallery extends REST_Controller {

    function __construct() {
        // Construct the parent class
        parent::__construct();
        $this->load->model('Newsgallery_model');
    }

    public function index_get() {
        // Users from a data store e.g. database
        $action = $this->get('action');
        switch ($action) {
            case "listnewsgallery":
                $this->listnewsgallery();
                break;
            default:
                $this->not_found();
                break;
        }
    }

    public function index_post() {
        $action = $this->post('action');
        switch ($action) {
            case "insert":
                $this->insert_newsgallery();
                break;
            case "update":
                $this->update_newsgallery();
                break;
            case "delete":
                $this->delete_newsgallery();
                break;
            default:
                $this->not_found();
                break;
        }
    }

    ///////////////////////////////////////////////////////////////////////////////////

    public function listnewsgallery() {
        $idnews = $this->get('idnews');
        $listnewsgallery = $this->Newsgallery_model->listnewsgallery($idnews);
        if (!empty($listnewsgallery)) {
            $this->set_response($listnewsgallery, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->empty_data();
        }
    }
    
    ///////////////////////////////////////////////////////////////////////////////////////

    public function insert_newsgallery() { //INSERT
        $idnews = $this->post('idnews');
        $avatar = $this->post('avatar');
        $insert_newsgallery = $this->Newsgallery_model->insert_newsgallery($idnews, $avatar);
        if ($insert_newsgallery > 0) {
            $this->set_response(array(['status' => true, 'message' => 'success']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->empty_data();
        }
    }

    public function update_newsgallery() { //UPDATE
        $idnewsgallery= $this->post('idnewsgallery');
        $avatar = $this->post('avatar');
        $update_newsgallery = $this->Newsgallery_model->update_newsgallery($idnewsgallery, $avatar);
        if ($update_newsgallery > 0) {
            $this->set_response(array(['status' => true, 'message' => 'success']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->empty_data();
        }
    }

    public function delete_newsgallery() { //DELETE
        $idnewsgallery= $this->post('idnewsgallery');
        $delete_newsgallery = $this->Newsgallery_model->delete_newsgallery($idnewsgallery);
        if ($delete_newsgallery > 0) {
            $this->set_response(array(['status' => true, 'message' => 'success']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->empty_data();
        }
    }

    public function not_found() {
        $this->set_response([[
        'status' => false,
        'message' => 'not found'
            ]], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
    }

    public function empty_data() {
        $this->set_response([[
        'status' => false,
        'message' => 'empty/failed operation'
            ]], REST_Controller::HTTP_BAD_REQUEST);
    }

}
