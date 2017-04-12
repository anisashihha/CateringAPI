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
 * Description of Notif
 *
 * @author Anisa' Shihhatin Sholihah
 * 29 Juli 2016
 */
require APPPATH . '/libraries/REST_Controller.php';

class Notif extends REST_Controller {

    function __construct() {
        // Construct the parent class
        parent::__construct();
        $this->load->model('Notif_model');
    }

    public function index_get() {
        // Users from a data store e.g. database
        $action = $this->get('action');
        switch ($action) {

            case "listnotif":
            $this->listnotif();
            break;
            case "listnotifbytenant":
            $this->listnotifbytenant();
            break;
            case "listnotifbycity":
            $this->listnotifbycity();
            break;
            case "listnotiffilterbyname":
            $this->listnotiffilterbyname();
            break;
            case "retrieve_get":
            $this->retrieve_get();
            break;
            case "count_notif":
            $this->count_notif();
            break;
            case "listnotifbycategory":
            $this->listnotifbycategory();
            break;
            default:
            $this->not_found();
            break;
        }
    }

    public function index_post() {
        $action = $this->post('action');
        switch ($action) {
            case "insert_notif":
            $this->insert_notif();
            break;
            case "mark_read":
            $this->mark_read();
            break;
            case "insert_isread":
            $this->insert_isread();
            break;
            case "update_notif":
            $this->update_notif();
            break;
            case "delete_notif":
            $this->delete_notif();
            break;
            case "delete_account_notif":
            $this->delete_account_notif();
            break;
            case "delete_isread":
            $this->delete_isread();
            break;
            default:
            $this->not_found();
            break;
        }
    }

    ////////////////////////////////////////////////////////////////////////////

    public function listnotif() {
        $idaccount = $this->get('idaccount');
        $pagenumber = $this->get('pagenumber');
        $pagesize = $this->get('pagesize');
        $lang = addslashes(trim(strtolower($this->get('lang'))));
        $listnotif = $this->Notif_model->listnotif($idaccount, $pagenumber, $pagesize, $lang);
        if (!empty($listnotif)) {
            $this->set_response($listnotif, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->set_response(array(['status' => false]), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }
    }

    public function listnotifbytenant() {
        $pagenumber = $this->get('pagenumber');
        $pagesize = $this->get('pagesize');
        $lang = addslashes(trim(strtolower($this->get('lang'))));

        $listnotifbytenant = $this->Notif_model->listnotifbytenant($pagenumber, $pagesize, $lang);
        if (!empty($listnotifbytenant)) {
            $this->set_response($listnotifbytenant, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->set_response(array(['status' => false]), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }
    }

    //tambahan per 22-09-2016 (Thursday)
    public function listnotifbycity() {
        $idcity = $this->get('idcity');
        $pagenumber = $this->get('pagenumber');
        $pagesize = $this->get('pagesize');
        $lang = addslashes(trim(strtolower($this->get('lang'))));

        $listnotifbycity = $this->Notif_model->listnotifbycity($idcity, $pagenumber, $pagesize, $lang);
        if (!empty($listnotifbycity)) {
            $this->set_response($listnotifbycity, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->set_response(array(['status' => false]), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }
    }

    public function listnotiffilterbyname() {
        $idaccount = $this->get('idaccount');
        $pagenumber = $this->get('pagenumber');
        $pagesize = $this->get('pagesize');
        $keyword = trim($this->get('keyword'));
        $lang = addslashes(trim(strtolower($this->get('lang'))));
        $listnotiffilterbyname = $this->Notif_model->listnotiffilterbyname($idaccount, $pagenumber, $pagesize, $keyword, $lang);
        if (!empty($listnotiffilterbyname)) {
            $this->set_response($listnotiffilterbyname, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->set_response(array(['status' => false]), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }
    }

    public function listnotifbycategory() {
        $idcategory = $this->get('idcategory');
        $lang = addslashes(trim(strtolower($this->get('lang'))));
        $listnotifbycategory = $this->Notif_model->listnotifbycategory($idcategory, $lang);
        if (!empty($listnotifbycategory)) {
            $this->set_response($listnotifbycategory, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->set_response(array(['status' => false]), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }
    }

    public function retrieve_get() {
        $idnotif = $this->get('idnotif');
        $idaccount = $this->get('idaccount');
        $lang = addslashes(trim(strtolower($this->get('lang'))));
        $retrieve_get = $this->Notif_model->retrieve_get($idnotif, $idaccount, $lang);
        if (!empty($retrieve_get)) {
            $this->set_response($retrieve_get, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
             $this->set_response(array(['status' => false]), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
         }
     }

     public function count_notif() {
        $idaccount = $this->get('idaccount');
        $count_notif = $this->Notif_model->count_notif($idaccount);
        if (!empty($count_notif)) {
            $this->set_response($count_notif, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
             $this->set_response(array(['status' => false]), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
         }
     }

    ////////////////////////////////////////////////////////////////////////////

     public function insert_notif() {
        $title = $this->post('title');
        $description = $this->post('description');
        $title_en = $this->post('title_en');
        $description_en = $this->post('description_en');
        $idtenant = $this->post('idtenant') != '' ? $this->post('idtenant') : null;
        $idcity = $this->post('idcity') != '' ? $this->post('idcity') : null;
        $image = $this->post('image');
        $idaccount = $this->post('idaccount');

        $insert_notif = $this->Notif_model->insert_notif($title, $description, $title_en, $description_en, $idtenant, $idcity, $image, $idaccount);
        if ($insert_notif > 0) {
            $this->set_response(array(['status' => true, 'message' => 'success']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->set_response(array(['status' => false, 'message' => 'failed']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }
    }

    public function mark_read() {
        $idnotif = $this->post('idnotif');
        $idaccount = $this->post('idaccount');

        $mark_read = $this->Notif_model->mark_read($idnotif, $idaccount);
        if ($mark_read > 0) {
            $this->set_response(array(['status' => true, 'message' => 'success']), REST_Controller::HTTP_OK); // OK (200) being
        } else {
            $this->set_response(array(['status' => false, 'message' => 'failed']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }
    }

    public function insert_isread() {
        $idnotif = $this->post('idnotif');
        $idaccount = $this->post('idaccount');

        $insert_isread = $this->Notif_model->insert_isread($idnotif, $idaccount);
        if ($insert_isread > 0) {
            $this->set_response(array(['status' => true, 'message' => 'success']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->set_response(array(['status' => false, 'message' => 'failed']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }
    }

    public function update_notif() { //UPDATE
        $idnotif = $this->post('idnotif');
        $title = $this->post('title');
        $description = $this->post('description');
        $title_en = $this->post('title_en');
        $description_en = $this->post('description_en');
        $idtenant = $this->post('idtenant') != '' ? $this->post('idtenant') : 'null';
        $idcity = $this->post('idcity') != '' ? $this->post('idcity') : 'null';
        $image = $this->post('image');

        $update_notif = $this->Notif_model->update_notif($idnotif, $title, $description, $title_en, $description_en, $idtenant, $idcity, $image);
        if ($update_notif > 0) {
            $this->set_response(array(['status' => true, 'message' => 'success']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
             $this->set_response(array(['status' => false, 'message' => 'failed']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
         }
     }

    public function delete_notif() { //DELETE
        $idnotif = $this->post('idnotif');

        $delete_notif = $this->Notif_model->delete_notif($idnotif);
        if ($delete_notif > 0) {
            $this->set_response(array(['status' => true, 'message' => 'success']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
             $this->set_response(array(['status' => false, 'message' => 'failed']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
         }
     }

     public function delete_account_notif() { //DELETE
        $idnotif = $this->post('idnotif');
        $idaccount = $this->post('idaccount');

        $delete_account_notif = $this->Notif_model->delete_account_notif($idnotif, $idaccount);
        if ($delete_account_notif > 0) {
            $this->set_response(array(['status' => true, 'message' => 'success']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
             $this->set_response(array(['status' => false, 'message' => 'failed']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
         }
     }

     public function delete_isread() { //DELETE
        $idread = $this->post('idread');
        $delete_isread = $this->Notif_model->delete_isread($idread);
        if ($delete_isread > 0) {
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
