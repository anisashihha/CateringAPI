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
 * Description of notifbookmark
 *
 * @author Anisa' Shihhatin Sholihah 
 * 27 Juni 2016
 */
require APPPATH . '/libraries/REST_Controller.php';

class notifbookmark extends REST_Controller {

    function __construct() {
        // Construct the parent class
        parent::__construct();
        $this->load->model('Notifbookmark_model');
    }

    public function index_get() {
        // Users from a data store e.g. database
        $action = $this->get('action');
        switch ($action) {
            case "listnotifbookmark":
                $this->listnotifbookmark();
                break;
            default:
                $this->not_found();
                break;
        }
    }

    public function index_post() {
        $action = $this->post('action');
        switch ($action) {
            case "insert_notifbookmark":
                $this->insert_notifbookmark();
                break;
            case "delete_notifbookmark":
                $this->delete_notifbookmark();
                break;
            default:
                $this->not_found();
                break;
        }
    }

    ////////////////////////////////////////////////////////////////////////////

    public function listnotifbookmark() {
        $idaccount = $this->get('idaccount');
        $pagenumber = $this->get('pagenumber');
        $pagesize = $this->get('pagesize');
        $listnotifbookmark = $this->Notifbookmark_model->listnotifbookmark($idaccount, $pagenumber, $pagesize);
        if (!empty($listnotifbookmark)) {
            $this->set_response($listnotifbookmark, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }
    


    ////////////////////////////////////////////////////////////////////////////
    public function insert_notifbookmark() { //INSERT
        $idnotif = $this->post('idnotif');
        $idaccount = $this->post('idaccount');
        
        $insert_notifbookmark = $this->Notifbookmark_model->insert_notifbookmark($idnotif, $idaccount);
        if ($insert_notifbookmark > 0) {
            $this->set_response(array(['status' => true,'message' => 'success']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->set_response(array(['status' => false,'message' => 'failed']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }
    }

    public function delete_notifbookmark() { //DELETE
        $idnotifbookmark = $this->post('idnotifbookmark');
        $delete_notifbookmark = $this->Notifbookmark_model->delete_notifbookmark($idnotifbookmark);
        if ($delete_notifbookmark > 0) {
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
