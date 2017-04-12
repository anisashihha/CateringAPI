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
 * Description of Publictransportation
 *
 * @author Anisa' Shihhatin Sholihah 
 * 27 Juni 2016
 */
require APPPATH . '/libraries/REST_Controller.php';

class Publictransportation extends REST_Controller {

    function __construct() {
        // Construct the parent class
        parent::__construct();
        $this->load->model('Publictransportation_model');
    }

    public function index_get() {
        // Users from a data store e.g. database
        $action = $this->get('action');
        switch ($action) {
            case "list":
                $this->listpublictransport();
                break;
            default:
            case "listpublictransportbyname":
                $this->listpublictransportbyname();
                break;
                $this->not_found();
                break;
        }
    }

    public function index_post() {
        $action = $this->post('action');
        switch ($action) {
            case "insert_publictransportation":
                $this->insert_publictransportation();
                break;
            case "update_publictransportation":
                $this->update_publictransportation();
                break;
            case "delete_publictransportation":
                $this->delete_publictransportation();
                break;
            default:
                $this->not_found();
                break;
        }
    }

    ///////////////////////////////////////////////////////////////////////////////////
    public function listpublictransport() {
            $idcity = $this->get('idcity');
            $pagenumber = $this->get('pagenumber');
            $pagesize = $this->get('pagesize');
            $list = $this->Publictransportation_model->listpublictransport($idcity, $pagenumber, $pagesize);
            if (!empty($list)) {
                $this->set_response($list, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            } else {
                $this->not_found();
            }
        }
///////////////////////////////////////////////////////////////////////////////////////
 //tambahan 06-10-2016
        public function listpublictransportbyname() {
        $idcity = $this->get('idcity');
        $pagenumber = $this->get('pagenumber');
        $pagesize = $this->get('pagesize');
        $keyword = trim($this->get('keyword'));
        $listpublictransportbyname = $this->Publictransportation_model->listpublictransportbyname($idcity, $pagenumber, $pagesize, $keyword);
        if (!empty($listpublictransportbyname)) {
            $this->set_response($listpublictransportbyname, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }
        /////////////////////////////////////////////////////////////////////////////////////////
    public function insert_publictransportation() { //INSERT
        $idcity = $this->post('idcity');
        $publictransportcode = $this->post('publictransportcode');
        $route = $this->post('route');

        $insert_publictransportation = $this->Publictransportation_model->insert_publictransportation($idcity, $publictransportcode, $route);
        if ($insert_publictransportation > 0) {
            $this->set_response(array(['status' => true, 'message' => 'success']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->set_response(array(['status' => false, 'message' => 'failed']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }
    }

    public function update_publictransportation() { //UPDATE
        $idpublictransportation = $this->post('idpublictransportation');
        $idcity = $this->post('idcity');
        $publictransportcode = $this->post('publictransportcode');
        $route = $this->post('route');
        

        $this->load->model('Publictransportation_model');
        $update_publictransportation = $this->Publictransportation_model->update_publictransportation($idpublictransportation, $idcity, $publictransportcode , $route);
         if ($update_publictransportation > 0) {
            $this->set_response(array(['status' => true, 'message' => 'success']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->set_response(array(['status' => false, 'message' => 'failed']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }
    }
    
    public function delete_publictransportation() { //DELETE
        $idpublictransportation = $this->post('idpublictransportation');
        $this->load->model('Publictransportation_model');
        $delete_publictransportation = $this->Publictransportation_model->delete_publictransportation($idpublictransportation);
         if ($delete_publictransportation > 0) {
            $this->set_response(array(['status' => true, 'message' => 'success']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->set_response(array(['status' => false, 'message' => 'failed']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }
    }

    public function not_found() {
        $this->set_response([[
        'status' => FALSE,
        'message' => 'not found'
            ]], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
    }

}
