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
 * Description of Download
 *
 * @author Anisa' Shihhatin Sholihah
 * 01 Agustus 2016
 */
require APPPATH . '/libraries/REST_Controller.php';

class Download extends REST_Controller {

    function __construct() {
        // Construct the parent class
        parent::__construct();
        $this->load->model('Download_model');
    }

    public function index_get() {
        // Users from a data store e.g. database
        $action = $this->get('action');
        switch ($action) {

            case "listdownload":
            $this->listdownload();
            break;
            case "listdownloadfilterbyname":
            $this->listdownloadfilterbyname();
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
            case "insert_download":
            $this->insert_download();
            break;
            case "update_download":
            $this->update_download();
            break;
            case "delete_download":
            $this->delete_download();
            break;
            default:
            $this->not_found();
            break;
        }
    }

    ////////////////////////////////////////////////////////////////////////////

    public function listdownload() {
        $idcategory = $this->get('idcategory');
        $pagenumber = $this->get('pagenumber');
        $pagesize = $this->get('pagesize');
        $listdownload = $this->Download_model->listdownload($idcategory, $pagenumber, $pagesize);
        if ($listdownload != null) {
            $this->set_response($listdownload, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function listdownloadfilterbyname() {
        $idcategory = $this->get('idcategory');
        $pagenumber = $this->get('pagenumber');
        $pagesize = $this->get('pagesize');
        $keyword = trim($this->get('keyword'));
        $listdownloadfilterbyname = $this->Download_model->listdownloadfilterbyname($idcategory, $pagenumber, $pagesize, $keyword);
        if ($listdownloadfilterbyname != null) {
            $this->set_response($listdownloadfilterbyname, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function retrieve_get() {
        $iddownload = $this->get('iddownload');
        // $this->set_response('retrieve_get', 200);
        $retrieve_get = $this->Download_model->retrieve_get($iddownload);
        if (!empty($retrieve_get)) {
            $this->set_response($retrieve_get, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    ////////////////////////////////////////////////////////////////////////////
    public function insert_download() { //INSERT
        $idcategory = $this->post('idcategory');
        $title = addslashes($this->post('title'));
        $avatar = $this->post('avatar');
        $linkfile = $this->post('linkfile');
        $filename = $this->post('filename');
        $filesize = $this->post('filesize');


        $insert_download = $this->Download_model->insert_download($idcategory, $title, $avatar, $linkfile, $filename, $filesize);
        if ($insert_download > 0) {
            $this->set_response(array(['message' => 'success']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function update_download() { //UPDATE
        $iddownload = $this->post('iddownload');
        $idcategory = $this->post('idcategory');
        $title = addslashes($this->post('title'));
        $avatar = $this->post('avatar');
        $linkfile = $this->post('linkfile');
        $filename = $this->post('filename');
        $filesize = $this->post('filesize');
        $update_download = $this->Download_model->update_download($iddownload, $idcategory, $title, $avatar, $linkfile, $filename, $filesize);
        if ($update_download > 0) {
            $this->set_response(array(['message' => 'success']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function delete_download() { //DELETE
        $iddownload = $this->post('iddownload');
        $delete_download = $this->Download_model->delete_download($iddownload);
        if ($delete_download > 0) {
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
