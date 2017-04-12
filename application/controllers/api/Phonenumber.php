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
 * Description of phonenumber
 *
 * @author Anisa' Shihhatin Sholihah 
 * 29 Juni 2016
 */
require APPPATH . '/libraries/REST_Controller.php';

class phonenumber extends REST_Controller {

    function __construct() {
        // Construct the parent class
        parent::__construct();
        $this->load->model('Phonenumber_model');
    }

    public function index_get() {
        // Users from a data store e.g. database
        $action = $this->get('action');
        switch ($action) {
            case "phonenumber_get":
                $this->phonenumber_get();
                break;
            default:
                $this->not_found();
                break;
        }
    }

    public function index_post() {
        $action = $this->post('action');
        switch ($action) {
            case "insert_phonenumber":
                $this->insert_phonenumber();
                break;
            case "update_phonenumber":
                $this->update_phonenumber();
                break;
            case "delete_phonenumber":
                $this->delete_phonenumber();
                break;
            default:
                $this->not_found();
                break;
        }
    }

    ////////////////////////////////////////////////////////////////////////////
    public function phonenumber_get() {
        $idphonenumber = $this->get('idphonenumber');
        $idcity = $this->get('idcity');
        $name = $this->get('name');
        $phonenumber_get = $this->Phonenumber_model->phonenumber_get($idcity);
        if (!empty($phonenumber_get)) {
            $this->set_response($phonenumber_get, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    ////////////////////////////////////////////////////////////////////////////
    public function insert_phonenumber() { //INSERT
        $idcity = $this->post('idcity');
        $name = $this->post('name');
        $phonenumber = $this->post('phonenumber');


        $insert_phonenumber = $this->Phonenumber_model->insert_phonenumber($idcity, $name, $phonenumber);
        if ($insert_phonenumber > 0) {
            $this->set_response(array(['message' => 'success']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function update_phonenumber() { //UPDATE 
        $idphonenumber = $this->post('idphonenumber');
        $idcity = $this->post('idcity');
        $name = $this->post('name');
        $phonenumber = $this->post('phonenumber');

       
        $update_phonenumber = $this->Phonenumber_model->update_phonenumber($idphonenumber, $idcity, $name, $phonenumber);
        if ($update_phonenumber > 0) {
            $this->set_response(array(['message' => 'success']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function delete_phonenumber() { //DELETE
        $idphonenumber = $this->post('idphonenumber');
        $delete_phonenumber = $this->Phonenumber_model->delete_phonenumber($idphonenumber);
        if ($delete_phonenumber > 0) {
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
