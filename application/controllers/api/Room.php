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
 * Description of Room
 *
 * @author Anisa' Shihhatin Sholihah 
 * 27 Juli 2016
 */
require APPPATH . '/libraries/REST_Controller.php';

class Room extends REST_Controller {

    function __construct() {
        // Construct the parent class
        parent::__construct();
        $this->load->model('Room_model');
    }

    public function index_get() {
        // Users from a data store e.g. database
        $action = $this->get('action');
        switch ($action) {
            case "listbyproperty":
                $this->listbyproperty();
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
            case "insert_room":
                $this->insert_room();
                break;
            case "update_room":
                $this->update_room();
                break;
            case "delete_room":
                $this->delete_room();
                break;
            default:
                $this->not_found();
                break;
        }
    }

    ////////////////////////////////////////////////////////////////////////////
    public function listbyproperty() {
        $idproperty = $this->get('idproperty');
        $pagenumber = $this->get('pagenumber');
        $pagesize = $this->get('pagesize');
        $listbyproperty = $this->Room_model->listbyproperty($idproperty, $pagenumber, $pagesize);
        if (!empty($listbyproperty)) {
            $this->set_response($listbyproperty, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function retrieve_get() {
        $idproperty = $this->get('idproperty');$retrieve_get = $this->Room_model->retrieve_get($idproperty);
        if (!empty($retrieve_get)) {
            $this->set_response($retrieve_get, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    ////////////////////////////////////////////////////////////////////////////
    public function insert_room() { //INSERT
        $idproperty = $this->post('idproperty');
        $name = $this->post('name');
        $jumlah = $this->post('jumlah');

        $insert_room = $this->Room_model->insert_room($idproperty, $name, $jumlah);
        if ($insert_room > 0) {
            $this->set_response(array(['message' => 'success']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function update_room() { //UPDATE
        $idroom = $this->post('idroom');
        $idproperty = $this->post('idproperty');
        $name = $this->post('name');
        $jumlah = $this->post('jumlah');


        $update_room = $this->Room_model->update_room($idroom, $idproperty, $name, $jumlah);
        if ($update_room > 0) {
            $this->set_response(array(['message' => 'success']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function delete_room() { //DELETE
        $idroom = $this->post('idroom');
        $delete_room = $this->Room_model->delete_room($idroom);
        if ($delete_room > 0) {
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
