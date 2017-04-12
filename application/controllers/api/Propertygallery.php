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
 * @author1         Anisa' Shihhatin Sholihah
 * @license         DBA
 * @link            anisashihha73@gmail.com //http://anisass.wordpress.com
 */

/**
 * Description of Propertygallery
 *
 * @author Anisa' Shihhatin Sholihah 
 * 27 Juni 2016
 */
require APPPATH . '/libraries/REST_Controller.php';

class Propertygallery extends REST_Controller {

    function __construct() {
        // Construct the parent class
        parent::__construct();
        $this->load->model('Propertygallery_model');
    }

    public function index_get() {
        // Users from a data store e.g. database
        $action = $this->get('action');
        switch ($action) {
            
            case "listpropertygallery":
                $this->listpropertygallery();
                break;
            default:
                $this->not_found();
                break;
        }
    }

    public function index_post() {
        $action = $this->post('action');
        switch ($action) {
            case "insert_propertygallery":
                $this->insert_propertygallery();
                break;
            case "update_propertygallery":
                $this->update_propertygallery();
                break;
            case "delete_propertygallery":
                $this->delete_propertygallery();
                break;
            default:
                $this->not_found();
                break;
        }
    }

    ///////////////////////////////////////////////////////////////////////////////////

    public function listpropertygallery() {
        $idproperty = $this->get('idproperty');
        $listpropertygallery = $this->Propertygallery_model->listpropertygallery($idproperty);
        if (!empty($listpropertygallery)) {
            $this->set_response($listpropertygallery, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }
    

///////////////////////////////////////////////////////////////////////////////////////
    public function insert_propertygallery() { //INSERT
        $idproperty = $this->post('idproperty');
        $title = $this->post('title');
        $avatar = $this->post('avatar');
        $insert_propertygallery = $this->Propertygallery_model->insert_propertygallery($idproperty, $title, $avatar);
        if ($insert_propertygallery > 0) {
            $this->set_response(array(['message' => 'success']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function update_propertygallery() { //UPDATE
        $idpropertygallery= $this->post('idpropertygallery');
        $title = $this->post('title');
        $avatar = $this->post('avatar');
        $update_propertygallery = $this->Propertygallery_model->update_propertygallery($idpropertygallery, $title, $avatar);
        if ($update_propertygallery > 0) {
            $this->set_response(array(['message' => 'success']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function delete_propertygallery() { //DELETE
        $idpropertygallery= $this->post('idpropertygallery');
        $delete_propertygallery = $this->Propertygallery_model->delete_propertygallery($idpropertygallery);
        if ($delete_propertygallery > 0) {
            $this->set_response(array(['message' => 'success']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function not_found() {
        $this->set_response([[
        'status' => FALSE,
        'message' => 'not found'
            ]], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
    }

}
