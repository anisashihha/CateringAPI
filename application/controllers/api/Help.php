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
 * Description of Help
 *
 * @author Anisa' Shihhatin Sholihah 
 * 10 Agustus 2016
 */
require APPPATH . '/libraries/REST_Controller.php';

class Help extends REST_Controller {

    function __construct() {
        // Construct the parent class
        parent::__construct();
        $this->load->model('Help_model');
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
            case "update":
                $this->update_help();
                break;
            default:
                $this->not_found();
                break;
        }
    }

    ////////////////////////////////////////////////////////////////////////////
    public function retrieve_get() {
        $idhelp = $this->get('idhelp');
        $idcity = $this->get('idcity');

        $get = $this->Help_model->retrieve_get($idhelp, $idcity);
        if (!empty($get)) {
            $this->set_response($get, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

 public function update_help() {
        $idhelp = $this->post('idhelp');
        $description = $this->post('description');
        $idcity = $this->post('idcity');
        

        $update = $this->Help_model->update_help($idhelp, $description, $idcity);
        if ($update>0) {
            $this->set_response(array(['status' => true,'message' => 'success']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
             $this->set_response(array(['status' => false,'message' => 'failed']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }
    }

    public function not_found() {
        $this->set_response([[
        'status' => FALSE,
        'message' => 'not found'
            ]], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
    }

}
