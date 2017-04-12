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
 * Description of Property
 *
 * @author Anisa' Shihhatin Sholihah
 * 05 Agustus 2016
 */
require APPPATH . '/libraries/REST_Controller.php';

class Property extends REST_Controller {

    function __construct() {
        // Construct the parent class
        parent::__construct();
        $this->load->model('Property_model');
    }

    public function index_get() {
        // Users from a data store e.g. database
        $action = $this->get('action');
        switch ($action) {
            case "retrieve_get":
            $this->retrieve_get();
            break;
            case "listbycategory":
            $this->listbycategory();
            break;
            case "listpropertybyname":
            $this->listpropertybyname();
            break;
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
            case "insert_property":
            $this->insert_property();
            break;
            case "update_property":
            $this->update_property();
            break;
            case "delete_property":
            $this->delete_property();
            break;
            default:
            $this->not_found();
            break;
        }
    }

    ////////////////////////////////////////////////////////////////////////////

    public function listbycategory() {
        $idcategory = $this->get('idcategory');
        $pagenumber = $this->get('pagenumber');
        $pagesize = $this->get('pagesize');
        $status = $this->get('status');
        $idaccount = $this->get('idaccount')!=null ? $this->get('idaccount') : null;

        $listbycategory = $this->Property_model->listbycategory($idcategory, $pagenumber, $pagesize, $status, $idaccount);
        if (!empty($listbycategory)) {
            $this->set_response($listbycategory, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function listpropertybyname() {
        $idcategory = $this->get('idcategory');
        $pagenumber = $this->get('pagenumber');
        $pagesize = $this->get('pagesize');
        $status = $this->get('status');
        $keyword = trim($this->get('keyword'));
        $idaccount = $this->get('idaccount')!=null ? $this->get('idaccount') : null;

        $listpropertybyname = $this->Property_model->listpropertybyname($idcategory, $pagenumber, $pagesize, $status, $keyword, $idaccount);
        if (!empty($listpropertybyname)) {
            $this->set_response($listpropertybyname, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function listbyagent() {
        $idagent = $this->get('idagent');
        $pagenumber = $this->get('pagenumber');
        $pagesize = $this->get('pagesize');
        $listbyagent = $this->Property_model->listbyagent($idagent, $pagenumber, $pagesize);
        if (!empty($listbyagent)) {
            $this->set_response($listbyagent, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function retrieve_get() {
        $idproperty = $this->get('idproperty');
        $idaccount = $this->get('idaccount');

        $retrieve_get = $this->Property_model->retrieve_get($idproperty, $idaccount);
        if (!empty($retrieve_get)) {
            $this->set_response($retrieve_get, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    ////////////////////////////////////////////////////////////////////////////
    public function insert_property() { //INSERT
        $idcategory = $this->post('idcategory');
        $name = addslashes($this->post('name'));
        $type = $this->post('type');
        $price = $this->post('price');
        $description = addslashes($this->post('description'));
        $lb = $this->post('lb');
        $lt = $this->post('lt');
        $avatar = $this->post('avatar');
        $idagent = $this->post('idagent');
        $status = $this->post('status');
        $description_en = addslashes($this->post('description_en'));

        $insert_property = $this->Property_model->insert_property($idcategory, $name, $type, $price, $description, $lb, $lt, $avatar, $idagent, $status, $description_en);
        if ($insert_property > 0) {
            $this->set_response(array(['message' => 'success']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function update_property() { //UPDATE
        $idproperty = $this->post('idproperty');
        $idcategory = $this->post('idcategory');
        $name = addslashes($this->post('name'));
        $type = $this->post('type');
        $price = $this->post('price');
        $description = addslashes($this->post('description'));
        $lb = $this->post('lb');
        $lt = $this->post('lt');
        $avatar = $this->post('avatar');
        $idagent = $this->post('idagent');
        $status = $this->post('status');
        $description_en = addslashes($this->post('description_en'));


        $update_property = $this->Property_model->update_property($idproperty, $idcategory, $name, $type, $price, $description, $lb, $lt, $avatar, $idagent, $status, $description_en);
        if ($update_property > 0) {
            $this->set_response(array(['message' => 'success']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function delete_property() { //DELETE
        $idproperty = $this->post('idproperty');
        $delete_property = $this->Property_model->delete_property($idproperty);
        if ($delete_property > 0) {
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
