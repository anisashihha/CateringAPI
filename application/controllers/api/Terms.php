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
 * Description of Terms
 *
 * @author Anisa' Shihhatin Sholihah 
 * 29 Juli 2016
 */
require APPPATH . '/libraries/REST_Controller.php';

class Terms extends REST_Controller {

    function __construct() {
        // Construct the parent class
        parent::__construct();
        $this->load->model('Terms_model');
    }

    public function index_get() {
        // Users from a data store e.g. database
        $action = $this->get('action');
        switch ($action) {
            case "list":
            $this->listterms();
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
            $this->insert_terms();
            break;
            case "update":
            $this->update_terms();
            break;
            case "delete":
            $this->delete_terms();
            break;
            default:
            $this->not_found();
            break;
        }
    }

    ////////////////////////////////////////////////////////////////////////////

    public function listterms() {
        $idcity = $this->get('idcity');

        $listterms = $this->Terms_model->listterms($idcity);
        if (!empty($listterms)) {
            $this->set_response($listterms, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->set_response(array(['status' => false]), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }
    }

    ////////////////////////////////////////////////////////////////////////////

    public function insert_terms() { //INSERT
        $idcity = $this->post('idcity');
        $linkfile = $this->post('linkfile');
        $title = $this->post('title');

        $insert = $this->Terms_model->insert_terms($idcity, $linkfile, $title);
        if ($insert > 0) {
            $this->set_response(array(['status' => true, 'message' => 'success']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
             $this->set_response(array(['status' => false]), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
         }
     }

    public function update_terms() { //UPDATE
        $idterms = $this->post('idterms');
        $linkfile = $this->post('linkfile');
        $title = $this->post('title');

        $update = $this->Terms_model->update_terms($idterms, $linkfile, $title);
        if ($update > 0) {
            $this->set_response(array(['status' => true, 'message' => 'success']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
             $this->set_response(array(['status' => false]), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
         }
     }

    public function delete_terms() { //DELETE
        $idterms = $this->post('idterms');

        $delete = $this->Terms_model->delete_terms($idterms);
        if ($delete > 0) {
            $this->set_response(array(['status' => true, 'message' => 'success']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
             $this->set_response(array(['status' => false]), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
         }
     }

    ////////////////////////////////////////////////////////////////////////////

     public function not_found() {
        $this->set_response([[
            'status' => FALSE,
            'message' => 'not found'
            ]], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
    }

}
