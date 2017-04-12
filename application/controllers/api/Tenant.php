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
 * Description of Tenant
 *
 * @author Anisa' Shihhatin Sholihah
 * 27 Juni 2016
 */
require APPPATH . '/libraries/REST_Controller.php';

class Tenant extends REST_Controller {

    function __construct() {
        // Construct the parent class
        parent::__construct();
        $this->load->model('Tenant_model');
    }

    public function index_get() {
        // Users from a data store e.g. database
        $action = $this->get('action');
        switch ($action) {
            case "listbycategory":
            $this->listbycategory();
            break;
            case "listcategoryfilterbyname":
            $this->listcategoryfilterbyname();
            break;
            case "listcategoryfilterbyrecommended":
            $this->listcategoryfilterbyrecommended();
            break;
            case "listalltenant":
            $this->listalltenant();
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
            case "insert_tenant":
            $this->insert_tenant();
            break;
            case "update_tenant":
            $this->update_tenant();
            break;
            case "delete_tenant":
            $this->delete_tenant();
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
        $listbycategory = $this->Tenant_model->listbycategory($idcategory, $pagenumber, $pagesize);
        if (!empty($listbycategory)) {
            $this->set_response($listbycategory, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function listcategoryfilterbyname() {
        $idcategory = $this->get('idcategory');
        $pagenumber = $this->get('pagenumber');
        $pagesize = $this->get('pagesize');
        $keyword = trim($this->get('keyword'));
        $listcategoryfilterbyname = $this->Tenant_model->listcategoryfilterbyname($idcategory, $pagenumber, $pagesize, $keyword);
        if (!empty($listcategoryfilterbyname)) {
            $this->set_response($listcategoryfilterbyname, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function listcategoryfilterbyrecommended() {
        $idcategory = $this->get('idcategory');
        $pagenumber = $this->get('pagenumber');
        $pagesize = $this->get('pagesize');
        $keyword = trim($this->get('keyword'));
        $idaccount = $this->get('idaccount');

        $listcategoryfilterbyrecommended = $this->Tenant_model->listcategoryfilterbyrecommended($idcategory, $pagenumber, $pagesize, $keyword, $idaccount);
        if (!empty($listcategoryfilterbyrecommended)) {
            $this->set_response($listcategoryfilterbyrecommended, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->set_response(array(['status' => false, 'message' => 'failed']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }
    }

    public function listalltenant() {
        $keyword = trim($this->get('keyword'));
        $pagenumber = $this->get('pagenumber');
        $pagesize = $this->get('pagesize');

        $listalltenant = $this->Tenant_model->listalltenant($keyword, $pagenumber, $pagesize);
        if (!empty($listalltenant)) {
            $this->set_response($listalltenant, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->set_response(array(['status' => 'failed']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }
    }

    public function retrieve_get() {
        $idtenant = $this->get('idtenant');
        $idaccount = $this->get('idaccount')!=null ? $this->get('idaccount') : null;

        $retrieve_get = $this->Tenant_model->retrieve_get($idtenant, $idaccount);
        if (!empty($retrieve_get)) {
            $this->set_response($retrieve_get, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->set_response(array(['status' => 'failed']), REST_Controller::HTTP_OK);
        }
    }

    ////////////////////////////////////////////////////////////////////////////
    public function insert_tenant() { //INSERT
        $idcategory = $this->post('idcategory');
        $name = addslashes($this->post('name'));
        $avatar = $this->post('avatar');
        $address = addslashes($this->post('address'));
        $longlat = $this->post('longlat');
        $premium = $this->post('premium');
        $phone = $this->post('phone');
        $link = $this->post('link');
        $logo = $this->post('logo');
        $color = $this->post('color');

        $insert_tenant = $this->Tenant_model->insert_tenant($idcategory, $name, $avatar, $address, $longlat, $premium, $phone, $link, $logo, $color);
        if ($insert_tenant > 0) {
            $this->set_response(array(['message' => 'success']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function update_tenant() { //UPDATE
        $idtenant = $this->post('idtenant');
        $idcategory = $this->post('idcategory');
        $name = addslashes($this->post('name'));
        $avatar = $this->post('avatar');
        $address = addslashes($this->post('address'));
        $longlat = $this->post('longlat');
        $premium = $this->post('premium');
        $phone = $this->post('phone');
        $link = $this->post('link');
        $logo = $this->post('logo');
        $color = $this->post('color');

        $update_tenant = $this->Tenant_model->update_tenant($idtenant, $idcategory, $name, $avatar, $address, $longlat, $premium, $phone, $link, $logo, $color);
        if ($update_tenant > 0) {
            $this->set_response(array(['message' => 'success']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->set_response(array(['message' => 'failed']), REST_Controller::HTTP_OK);
        }
    }

    public function delete_tenant() { //DELETE
        $idtenant = $this->post('idtenant');
        $delete_tenant = $this->Tenant_model->delete_tenant($idtenant);
        if ($delete_tenant > 0) {
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
