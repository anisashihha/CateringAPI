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
 * Description of History
 *
 * @author Anisa' Shihhatin Sholihah
 * 09 Agustus 2016
 */
require APPPATH . '/libraries/REST_Controller.php';

class History extends REST_Controller {

    function __construct() {
        // Construct the parent class
        parent::__construct();
        $this->load->model('History_model');
    }

    public function index_get() {
        // Users from a data store e.g. database
        $action = $this->get('action');
        switch ($action) {

            case "listhistory":
                $this->listhistory();
                break;
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
            case "insert_history":
                $this->insert_history();
                break;
            case "update_history":
                $this->update_history();
                break;
            case "delete_history":
                $this->delete_history();
                break;
            default:
                $this->not_found();
                break;
        }
    }

    ////////////////////////////////////////////////////////////////////////////
    public function listhistory() {
        $idaccount = $this->get('idaccount');
        $pagenumber = $this->get('pagenumber');
        $pagesize = $this->get('pagesize');
        $listhistory = $this->History_model->listhistory($idaccount, $pagenumber, $pagesize);
        if (!empty($listhistory)) {
            $this->set_response($listhistory, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

     public function retrieve_get() {
        $idaccount = $this->get('idaccount');$retrieve_get = $this->History_model->retrieve_get($idaccount);
        if (!empty($retrieve_get)) {
            $this->set_response($retrieve_get, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

////////////////////////////////////////////////////////////////////////////////
    public function insert_history() { //INSERT
        $idaccount = $this->post('idaccount');
        $activities = addslashes($this->post('activities'));
        $visitdate = $this->post('visitdate');
        $idcategory = $this->post('idcategory');


        $insert_history = $this->History_model->insert_history($idaccount, $activities, $visitdate, $idcategory);
        if ($insert_history > 0) {
            $this->set_response(array(['message' => 'success']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function update_history() { //UPDATE
        $idhistory = $this->post('idhistory');
        $idaccount = $this->post('idaccount');
        $activities = addslashes($this->post('activities'));
        $visitdate = $this->post('visitdate');
        $idcategory = $this->post('idcategory');
        $update_history = $this->History_model->update_history($idhistory, $idaccount, $activities, $visitdate, $idcategory);
        if ($update_history > 0) {
            $this->set_response(array(['message' => 'success']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function delete_history() { //DELETE
        $idhistory = $this->post('idhistory');
        $delete_history = $this->History_model->delete_history($idhistory);
        if ($delete_history > 0) {
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
