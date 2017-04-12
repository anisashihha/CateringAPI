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
 * Description of Agent
 *
 * @author Anisa' Shihhatin Sholihah 
 * 10 Agustus 2016
 */
require APPPATH . '/libraries/REST_Controller.php';

class Agent extends REST_Controller {

    function __construct() {
        // Construct the parent class
        parent::__construct();
        $this->load->model('Agent_model');
    }

    public function index_get() {
        // Users from a data store e.g. database
        $action = $this->get('action');
        switch ($action) {
            case "retrieve_get":
            $this->retrieve_get();
            break;
            case "listagent":
            $this->listagent();
            break;
            ///tambahan 25/08/2016
            case "listbyagent":
            $this->listbyagent();
            break;
            default:
            $this->not_found();
            break;
        }
    }

    public function index_post() {
        $action = $this->post('action');
        switch ($action) {
            case "insert_agent":
            $this->insert_agent();
            break;
            case "update_agent":
            $this->update_agent();
            break;
            case "delete_agent":
            $this->delete_agent();
            break;
            default:
            $this->not_found();
            break;
        }
    }

    ////////////////////////////////////////////////////////////////////////////
    public function retrieve_get() {
        $idagent = $this->get('idagent');
        // $this->set_response('retrieve_get', 200);
        $retrieve_get = $this->Agent_model->retrieve_get($idagent);
        if (!empty($retrieve_get)) {
            $this->set_response($retrieve_get, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function listagent() {
        $pagenumber = $this->get('pagenumber');
        $pagesize = $this->get('pagesize');
        $listagent = $this->Agent_model->listagent($pagenumber, $pagesize);
        if (!empty($listagent)) {
            $this->set_response($listagent, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    ///// tambahan 25/08/2016
    public function listbyagent() {
        $idagent = $this->get('idagent');
        $pagenumber = $this->get('pagenumber');
        $pagesize = $this->get('pagesize');
        $listbyagent = $this->Agent_model->listbyagent($idagent, $pagenumber, $pagesize);
        if (!empty($listbyagent)) {
            $this->set_response($listbyagent, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    ////////////////////////////////////////////////////////////////////////////
    public function insert_agent() { //INSERT
        $name = $this->post('name');
        $avatar = $this->post('avatar');
        $email = $this->post('email');
        $phone = $this->post('phone');

        $insert_agent = $this->Agent_model->insert_agent($name, $avatar, $email, $phone);
        if ($insert_agent > 0) {
            $this->set_response(array(['message' => 'success']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function update_agent() { //UPDATE
        $idagent = $this->post('idagent');
        $avatar = $this->post('avatar');
        $name = $this->post('name');
        $email = $this->post('email');
        $phone = $this->post('phone');
        $update_agent = $this->Agent_model->update_agent($idagent, $name, $avatar, $email, $phone);
        if ($update_agent > 0) {
            $this->set_response(array(['message' => 'success']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->set_response(array(['message' => 'failed']), REST_Controller::HTTP_OK);
        }
    }

    public function delete_agent() { //DELETE
        $idagent = $this->post('idagent');
        $delete_agent = $this->Agent_model->delete_agent($idagent);
        if ($delete_agent > 0) {
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
