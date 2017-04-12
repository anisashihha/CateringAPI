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
 * Description of Bookmark
 *
 * @author Anisa' Shihhatin Sholihah 
 * 27 Juni 2016
 */
require APPPATH . '/libraries/REST_Controller.php';

class Bookmark extends REST_Controller {

    function __construct() {
        // Construct the parent class
        parent::__construct();
        $this->load->model('Bookmark_model');
    }

    public function index_get() {
        // Users from a data store e.g. database
        $action = $this->get('action');
        switch ($action) {
            case "listbookmark":
            $this->listbookmark();
            break;
            case "listbookmarkfilterbyname":
            $this->listbookmarkfilterbyname();
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
            case "insert_bookmark":
            $this->insert_bookmark();
            break;
            case "delete_bookmark":
            $this->delete_bookmark();
            break;
            default:
            $this->not_found();
            break;
        }
    }

    ////////////////////////////////////////////////////////////////////////////

    public function listbookmark() {
        $idaccount = $this->get('idaccount');
        $pagenumber = $this->get('pagenumber');
        $pagesize = $this->get('pagesize');
        $listbookmark = $this->Bookmark_model->listbookmark($idaccount, $pagenumber, $pagesize);
        if (!empty($listbookmark)) {
            $this->set_response($listbookmark, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }
    
    public function listbookmarkfilterbyname() {
        $idaccount = $this->get('idaccount');
        $pagenumber = $this->get('pagenumber');
        $pagesize = $this->get('pagesize');
        $idtenant = $this->get('idtenant');
        $listbookmarkfilterbyname = $this->Bookmark_model->listbookmarkfilterbyname ($idaccount, $pagenumber, $pagesize, $idtenant);
        if (!empty($listbookmarkfilterbyname )) {
            $this->set_response($listbookmarkfilterbyname , REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }
    
    public function retrieve_get() {
        $idbookmark = $this->get('idbookmark');
        // $this->set_response('retrieve_get', 200);
        $retrieve_get = $this->Bookmark_model->retrieve_get($idbookmark);
        if (!empty($retrieve_get)) {
            $this->set_response($retrieve_get, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    ////////////////////////////////////////////////////////////////////////////
    
    public function insert_bookmark() { //INSERT
        $idaccount = $this->post('idaccount');
        $idtenant = $this->post('idtenant') != '' ? $this->post('idtenant') : null;
        $idproperty = $this->post('idproperty') != '' ? $this->post('idproperty') : null;

        $insert_bookmark = $this->Bookmark_model->insert_bookmark($idaccount, $idtenant, $idproperty);
        if ($insert_bookmark > 0) {
            $this->set_response(array(['status' => true, 'message' => 'success']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else if($insert_bookmark < 0) {
            $this->set_response(array(['status' => false, 'message' => 'already bookmark']), REST_Controller::HTTP_OK); // OK (200) being the HTTP 
        } else {
            $this->set_response(array(['status' => false, 'message' => 'something wrong']), REST_Controller::HTTP_OK); // OK (200) being the HTTP
        }
    }

    public function delete_bookmark() { //DELETE
        $idbookmark = $this->post('idbookmark');
        $delete_bookmark = $this->Bookmark_model->delete_bookmark($idbookmark);
        if ($delete_bookmark > 0) {
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
