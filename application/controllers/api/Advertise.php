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
 * Description of Advertise
 *
 * @author Anisa' Shihhatin Sholihah 
 * 09 February 2017
 */
require APPPATH . '/libraries/REST_Controller.php';

class Advertise extends REST_Controller {

    function __construct() {
        // Construct the parent class
        parent::__construct();
        $this->load->model('Advertise_model');
    }

    public function index_get() {
        // Users from a data store e.g. database
        $action = $this->get('action');
        switch ($action) {
            case "retrieve_get":
                $this->retrieve_get();
            break;
            case "listadvertise":
                $this->listadvertise();
                break;
            case "listbycategory":
                $this->listbycategory();
                break;
            case "listadvertisefilterbyname":
                $this->listadvertisefilterbyname();
                break;
            case "get_countadvertise":
                $this->get_countadvertise();
                break;
            default:
                $this->not_found();
                break;
        }
    }

    public function index_post() {
        $action = $this->post('action');
        switch ($action) {
            case "insert_advertise":
                 $this->insert_advertise();
            break;
            case "update_advertise":
                 $this->update_advertise();
            break;
            case "delete_advertise":
                 $this->delete_advertise();
            break;
            default:
                 $this->not_found();
            break;
        }
    }
/////////////////////////////////////////////////////////////////////////////////////////////
    public function retrieve_get() {
        $idadvertise = $this->get('idadvertise');

        $retrieve_get = $this->Advertise_model->retrieve_get($idadvertise);
        if (!empty($retrieve_get)) {
            $this->set_response($retrieve_get, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->set_response(array(['status' => false, 'message' => 'empty']), REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function listadvertise() {
        $pagenumber = $this->get('pagenumber');
        $pagesize = $this->get('pagesize');
        $listadvertise = $this->Advertise_model->listadvertise($pagenumber, $pagesize);
        if (!empty($listadvertise)) {
            $this->set_response($listadvertise, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->set_response(array(['status' => false, 'message' => 'empty']), REST_Controller::HTTP_NOT_FOUND); // OK (200) being the HTTP response code
        }
    }

    public function listbycategory() {
        $idcategory = $this->get('idcategory');
        $pagenumber = $this->get('pagenumber');
        $pagesize = $this->get('pagesize');
        $category = $this->get('category') != '' ? $this->get('category') : "tenant";

        $listbycategory = $this->Advertise_model->listbycategory($idcategory, $pagenumber, $pagesize, $category);
        if (!empty($listbycategory)) {
            $this->set_response($listbycategory, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->set_response(array(['status' => false, 'message' => 'empty']), REST_Controller::HTTP_NOT_FOUND); // OK (200) being the HTTP response code
        }
    }

    public function listadvertisefilterbyname() {
        $pagenumber = $this->get('pagenumber');
        $pagesize = $this->get('pagesize');
        $keyword = trim($this->get('keyword'));
        $listadvertisefilterbyname = $this->Advertise_model->listadvertisefilterbyname($pagenumber, $pagesize, $keyword);
        if (!empty($listadvertisefilterbyname)) {
            $this->set_response($listadvertisefilterbyname, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->set_response(array(['status' => false, 'message' => 'empty']), REST_Controller::HTTP_NOT_FOUND); // OK (200) being the HTTP response code
        }
    }

    //COUNT advertise
     public function get_countadvertise() {
        $get_countadvertise = $this->Advertise_model->get_countadvertise();
        if (!empty($get_countadvertise)) {
            $this->set_response($get_countadvertise, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->set_response(array(['status' => false, 'message' => 'failed']), REST_Controller::HTTP_NOT_FOUND);
        }
    }

/////////////////////////////////////////////////////////////////////////////////////////////////
    public function insert_advertise() { //INSERT
        $advertise = $this->post('advertise');
        $smalladvertise = $this->post('smalladvertise') != '' ? $this->post('smalladvertise') : null;
        $idtenant = $this->post('idtenant') != '' ? $this->post('idtenant') : null;
        $idproperty = $this->post('idproperty') != '' ? $this->post('idproperty') : null;

        $insert_advertise = $this->Advertise_model->insert_advertise($idtenant, $idproperty, $advertise, $smalladvertise);
        if ($insert_advertise > 0) {
            $this->set_response(array(['status' => true, 'message' => 'success']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->set_response(array(['status' => false, 'message' => 'failed']), REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function update_advertise() { //UPDATE
        $idadvertise = $this->post('idadvertise');
        $advertise = $this->post('advertise');
        $smalladvertise = $this->post('smalladvertise') != '' ? $this->post('smalladvertise') : null;
        $idtenant = $this->post('idtenant') != '' ? $this->post('idtenant') : null;
        $idproperty = $this->post('idproperty') != '' ? $this->post('idproperty') : null;
        
        $update_advertise = $this->Advertise_model->update_advertise($idadvertise, $idtenant, $idproperty, $advertise, $smalladvertise);
        if ($update_advertise > 0) {
            $this->set_response(array(['status' => true, 'message' => 'success']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->set_response(array(['status' => false, 'message' => 'failed']), REST_Controller::HTTP_OK);
        }
    }

    public function delete_advertise() { //DELETE
        $idadvertise = $this->post('idadvertise');
        $delete_advertise = $this->Advertise_model->delete_advertise($idadvertise);
        if ($delete_advertise > 0) {
            $this->set_response(array(['message' => 'success']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->set_response(array(['message' => 'failed']), REST_Controller::HTTP_OK);
        }
    }

    public function not_found() {
        $this->set_response([[
            'status' => FALSE,
            'message' => 'not found'
            ]], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
    }

}