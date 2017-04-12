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
 * Description of Callcentre
 *
 * @author Anisa' Shihhatin Sholihah 
 * 25 Agustus 2016
 */
require APPPATH . '/libraries/REST_Controller.php';

class Callcenter extends REST_Controller {

    function __construct() {
        // Construct the parent class
        parent::__construct();
        $this->load->model('Callcenter_model');
    }

    public function index_get() {
        // Users from a data store e.g. database
        $action = $this->get('action');
        switch ($action) {
            case "retrieve_get":
                $this->retrieve_get();
                break;
            default:
                $this->not_found();
                break;
        }
    }

    public function index_post() {
        $action = $this->post('action');
        switch ($action) {
            case "insert_callcenter":
                $this->insert_callcenter();
                break;
            case "update_callcenter":
                $this->update_callcenter();
                break;
            case "delete_callcenter":
                $this->delete_callcenter();
                break;
            default:
                $this->not_found();
                break;
        }
    }

    ////////////////////////////////////////////////////////////////////////////
    public function retrieve_get() {
        $idcallcenter = $this->get('idcallcenter');
        $idcity = $this->get('idcity');

        $get = $this->Callcenter_model->retrieve_get($idcallcenter, $idcity);
        if (!empty($get)) {
            $this->set_response($get, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

   ////////////////////////////////////////////////////////////////////////////
    public function insert_callcenter() { //INSERT
        $idcity = $this->post('idcity');
        $title = $this->post('title');
        $description = $this->post('description');
        $phone = $this->post('phone');

        $insert_callcenter = $this->Callcenter_model->insert_callcenter($idcity, $title, $description, $phone);
        if ($insert_callcenter > 0) {
            $this->set_response(array(['message' => 'success']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function update_callcenter() { //UPDATE
        $idcallcenter = $this->post('idcallcenter');
        $idcity = $this->post('idcity');
        $title = $this->post('title');
        $description = $this->post('description');
        $phone = $this->post('phone');
        $update_callcenter = $this->Callcenter_model->update_callcenter($idcallcenter, $idcity, $title, $description, $phone);
        if ($update_callcenter > 0) {
            $this->set_response(array(['message' => 'success']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function delete_callcenter() { //DELETE
        $idcallcenter = $this->post('idcallcenter');
        $delete_callcenter = $this->Callcenter_model->delete_callcenter($idcallcenter);
        if ($delete_callcenter > 0) {
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
