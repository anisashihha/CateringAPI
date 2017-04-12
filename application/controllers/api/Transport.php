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
 * Description of transport
 *
 * @author Anisa' Shihhatin Sholihah 
 * 27 Juni 2016
 */
require APPPATH . '/libraries/REST_Controller.php';

class transport extends REST_Controller {

    function __construct() {
        // Construct the parent class
        parent::__construct();
        $this->load->model('transport_model');
    }

    public function index_get() {
        // Users from a data store e.g. database
        $action = $this->get('action');
        switch ($action) {
            case "transportbycategory":
                $this->transportbycategory();
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
            case "insert_transport":
                $this->insert_transport();
                break;
            case "update_transport":
                $this->update_transport();
                break;
            case "delete_transport":
                $this->delete_transport();
                break;
            default:
                $this->not_found();
                break;
        }
    }

    ///////////////////////////////////////////////////////////////////////////////////

    public function transportbycategory() {
        $idtransportcategory = $this->get('idtransportcategory');
        $pagenumber = $this->get('pagenumber');
        $pagesize = $this->get('pagesize');
        $transportbycategory = $this->transport_model->transportbycategory($idtransportcategory, $pagenumber, $pagesize);
        if (!empty($transportbycategory)) {
            $this->set_response($transportbycategory, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }


    public function retrieve_get() {
        $idtransport = $this->get('idtransport');
        $this->load->model('transport_model');$retrieve_get = $this->transport_model->retrieve_get($idtransport);
        if (!empty($retrieve_get)) {
            $this->set_response($retrieve_get, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

///////////////////////////////////////////////////////////////////////////////////////
    public function insert_transport() { //INSERT
        $idtransportcategory = $this->post('idtransportcategory');
        $name = $this->post('name');
        $avatar = $this->post('avatar');
        $address = $this->post('address');
        $longlat = $this->post('longlat');
        $premium = $this->post('premium');
        $phone = $this->post('phone');

        $insert_transport = $this->transport_model->insert_transport($idtransportcategory, $name, $avatar, $address, $longlat, $premium, $phone);
        if ($insert_transport > 0) {
            $this->set_response(array(['message' => 'success']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function update_transport() { //UPDATE
        $idtransport = $this->post('idtransport');
        $idtransportcategory = $this->post('idtransportcategory');
        $name = $this->post('name');
        $avatar = $this->post('avatar');
        $address = $this->post('address');
        $longlat = $this->post('longlat');
        $premium = $this->post('premium');
        $phone = $this->post('phone');
        

        $this->load->model('transport_model');
        $update_transport = $this->transport_model->update_transport($idtransport, $idtransportcategory, $name, $avatar, $address, $longlat, $premium, $phone);
        if ($update_transport > 0) {
            $this->set_response(array(['message' => 'success']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function delete_transport() { //DELETE
        $idtransport = $this->post('idtransport');
        $this->load->model('transport_model');
        $delete_transport = $this->transport_model->delete_transport($idtransport);
        if ($delete_transport > 0) {
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
