
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
 * Description of Complaints
 *
 * @author Anisa' Shihhatin Sholihah
 * 21 February 2017
 */
require APPPATH . '/libraries/REST_Controller.php';

class Complaints extends REST_Controller {

    function __construct() {
        // Construct the parent class
        parent::__construct();
        $this->load->model('Complaints_model');
    }

    public function index_get() {
        // Users from a data store e.g. database
        $action = $this->get('action');
        switch ($action) {
            case "listcomplaints":
                $this->listcomplaints();
                break;
            case "listcomplaintsfilterbyname":
                $this->listcomplaintsfilterbyname();
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
            case "insert_complaints":
                $this->insert_complaints();
                break;
            case "update_complaints":
                $this->update_complaints();
                break;
            case "delete_complaints":
                $this->delete_complaints();
                break;
            default:
                $this->not_found();
                break;
        }
    }

    ////////////////////////////////////////////////////////////////////////////
    public function listcomplaints() {
        $pagenumber = $this->get('pagenumber');
        $pagesize = $this->get('pagesize');
        $listcomplaint = $this->Complaints_model->listcomplaints($pagenumber, $pagesize);
        if (!empty($listcomplaint)) {
            $this->set_response($listcomplaint, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function listcomplaintsfilterbyname() {
        $pagenumber = $this->get('pagenumber');
        $pagesize = $this->get('pagesize');
        $keyword = $this->get('keyword');
        $listcomplaintsfilterbyname = $this->Complaints_model->listcomplaintsfilterbyname($pagenumber, $pagesize, $keyword);
        if (!empty($listcomplaintsfilterbyname)) {
            $this->set_response($listcomplaintsfilterbyname, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function retrieve_get() {
        $idcomplaints = $this->get('idcomplaints');
        $retrieve_get = $this->Complaints_model->retrieve_get($idcomplaints);
        if (!empty($retrieve_get)) {
            $this->set_response($retrieve_get, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    ////////////////////////////////////////////////////////////////////////////
    public function insert_complaints() { //INSERT
        $idaccount = $this->post('idaccount');
        $title = addslashes($this->post('title'));
        $description = addslashes($this->post('description'));
        $numberticket = $this->post('numberticket');
        $status = $this->post('status');
        $avatar = $this->post('avatar');

        $insert_complaints = $this->Complaint_model->insert_complaints($idaccount, $title, $description, $numberticket, $status, $avatar);
        if ($insert_complaints > 0) {
            $this->set_response(array(['message' => 'success']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function update_complaints() { //UPDATE
        $idcomplaints = $this->post('idcomplaints');
        $title = addslashes($this->post('title'));
        $description = addslashes($this->post('description'));
        $numberticket = addslashes($this->post('numberticket'));
        $status = addslashes($this->post('status'));
        $update_complaints = $this->Complaints_model->update_complaints($idcomplaints, $title, $description, $numberticket, $status);
        if ($update_complaints > 0) {
            $this->set_response(array(['message' => 'success']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function delete_complaints() { //DELETE
        $idcomplaints = $this->post('idcomplaints');
        $delete_complaints = $this->Complaints_model->delete_complaints($idcomplaints);
        if ($delete_complaints > 0) {
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
