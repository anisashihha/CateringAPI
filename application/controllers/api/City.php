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
 * Description of City
 *
 * @author Anisa' Shihhatin Sholihah
 * 27 Juni 2016
 */
require APPPATH . '/libraries/REST_Controller.php';

class City extends REST_Controller {

    function __construct() {
        // Construct the parent class
        parent::__construct();
        $this->load->model('City_model');
    }

    public function index_get() {
        // Users from a data store e.g. database
        $action = $this->get('action');
        switch ($action) {
            case "listgallery":
            $this->listgallery();
            break;
            case "select_datacity":
            $this->select_datacity();
            break;
            case "listgalleryfilterbyname":
            $this->listgalleryfilterbyname();
            break;
            case "listglobal":
            $this->listglobal();
            break;
            case "retrieveget_terms":
            $this->retrieveget_terms();
            break;
            default:
            $this->not_found();
            break;
        }
    }

    public function index_post() {
        $action = $this->post('action');
        switch ($action) {
            case "insert_gallery":
            $this->insert_gallery();
            break;
            case "update_gallery":
            $this->update_gallery();
            break;
            case "delete_gallery":
            $this->delete_gallery();
            break;
            case "insert_datacity":
            $this->insert_datacity();
            break;
            case "update_datacity":
            $this->update_datacity();
            break;
            default:
            $this->not_found();
            break;
        }
    }

    ////////////////////////////////////////////////////////////////////////////


    public function listgallery() {
        $idcity = $this->get('idcity');
        $pagenumber = $this->get('pagenumber');
        $pagesize = $this->get('pagesize');
        $listgallery = $this->City_model->listgallery($idcity, $pagenumber, $pagesize);
        if (!empty($listgallery)) {
            $this->set_response($listgallery, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function retrieveget_terms() {
        $this->load->helper('file');
        $filename='http://innodev.vnetcloud.com/LiveIn/assets/file/city/terms.html';
        $file = fopen($filename,"r");
  // var_dump(fread($file,10000));
        $a = fread($file,10000);
        fclose($file);
        if ($a) {
            $this->set_response($terms, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function select_datacity() {
        $idcity = $this->get('idcity');
        $select_datacity = $this->City_model->select_datacity($idcity);
        if (!empty($select_datacity)) {
            $this->set_response($select_datacity, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function listgalleryfilterbyname() {
        $idcity = $this->get('idcity');
        $pagenumber = $this->get('pagenumber');
        $pagesize = $this->get('pagesize');
        $keyword = trim($this->get('keyword'));
        $listgalleryfilterbyname = $this->City_model->listgalleryfilterbyname($idcity, $pagenumber, $pagesize, $keyword);
        if (!empty($listgalleryfilterbyname)) {
            $this->set_response($listgalleryfilterbyname, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function listalltenantsfilterbyname() {
        $name = $this->get('name');
        $pagenumber = $this->get('pagenumber');
        $pagesize = $this->get('pagesize');
        $listalltenantsfilterbyname = $this->Tenant_model->listalltenantsfilterbyname($name, $pagenumber, $pagesize);
        if (!empty($listalltenantsfilterbyname)) {
            $this->set_response($listalltenantsfilterbyname, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->set_response(array(['status' => 'failed']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }
    }

    public function listglobal() {
        $idcity = $this->get('idcity');
        $pagenumber = $this->get('pagenumber');
        $pagesize = $this->get('pagesize');
        $keyword = trim($this->get('keyword'));
        $listglobal = $this->City_model->listglobal($idcity, $pagenumber, $pagesize, $keyword);
        if (!empty($listglobal)) {
            $this->set_response($listglobal, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->set_response(array(['status' => 'failed']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }
    }
    ////////////////////////////////////////////////////////////////////////////
    public function insert_gallery() { //INSERT
        $idcity = $this->post('idcity');
        $title = addslashes($this->post('title'));
        $avatar = $this->post('avatar');


        $insert_gallery = $this->City_model->insert_gallery($idcity, $title, $avatar);
        if ($insert_gallery > 0) {
            $this->set_response(array(['message' => 'success']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function update_gallery() { //UPDATE
        $idcitygallery = $this->post('idcitygallery');
        $title = addslashes($this->post('title'));
        $avatar = $this->post('avatar');
        $update_gallery = $this->City_model->update_gallery($idcitygallery, $title, $avatar);
        if ($update_gallery > 0) {
            $this->set_response(array(['message' => 'success']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function delete_gallery() { //DELETE
        $idcitygallery = $this->post('idcitygallery');
        $delete_gallery = $this->City_model->delete_gallery($idcitygallery);
        if ($delete_gallery > 0) {
            $this->set_response(array(['message' => 'success']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    ////////////////////////////////////////////////////////////////////////////
    public function insert_datacity() { //INSERT
        $cityname = addslashes($this->post('cityname'));
        $cityarea = $this->post('cityarea');
        $residentpopulation = $this->post('residentpopulation');
        $employmentpopulation = $this->post('employmentpopulation ');
        $jobspopulation = $this->post('jobspopulation');
        $jobsinformation = addslashes($this->post('jobsinformation'));
        $treesinformation = addslashes($this->post('treesinformation'));
        $roadinformation = addslashes($this->post('roadinformation'));
        $houseinformation = addslashes($this->post('houseinformation'));
        $shophouseinformation = addslashes($this->post('shophouseinformation'));
        $schoollinformation = addslashes($this->post('schoollinformation'));
        $internationalschoollinformation = addslashes($this->post('internationalschoollinformation'));
        $serviceapartmentinformation = addslashes($this->post('serviceapartmentinformation'));
        $timezone = $this->post('timezone');
        $areacode = $this->post('areacode');
        $vehicleregistration = addslashes($this->post('vehicleregistration'));
        $website = addslashes($this->post('website'));
        $insert_datacity = $this->City_model->insert_datacity($cityname, $cityarea, $residentpopulation, $employmentpopulation, $jobspopulation, $jobsinformation, $treesinformation, $roadinformation, $houseinformation, $shophouseinformation, $schoollinformation, $internationalschoollinformation, $serviceapartmentinformation, $timezone, $areacode, $vehicleregistration, $website);
        if ($insert_datacity > 0) {
            $this->set_response(array(['message' => 'success']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function update_datacity() { //UPDATE
        $idcity = $this->post('idcity');
        $cityname = addslashes($this->post('cityname'));
        $cityarea = $this->post('cityarea');
        $residentpopulation = $this->post('residentpopulation');
        $employmentpopulation = $this->post('employmentpopulation');
        $jobspopulation = $this->post('jobspopulation');
        $jobsinformation = addslashes($this->post('jobsinformation'));
        $treesinformation = addslashes($this->post('treesinformation'));
        $roadinformation = addslashes($this->post('roadinformation'));
        $houseinformation = addslashes($this->post('houseinformation'));
        $shophouseinformation = addslashes($this->post('shophouseinformation'));
        $schoollinformation = addslashes($this->post('schoollinformation'));
        $internationalschoollinformation = addslashes($this->post('internationalschoollinformation'));
        $serviceapartmentinformation = addslashes($this->post('serviceapartmentinformation'));
        $timezone = $this->post('timezone');
        $areacode = $this->post('areacode');
        $vehicleregistration = addslashes($this->post('vehicleregistration'));
        $website = addslashes($this->post('website'));
        $update_datacity = $this->City_model->update_datacity($idcity, $cityname, $cityarea, $residentpopulation, $employmentpopulation, $jobspopulation, $jobsinformation, $treesinformation, $roadinformation, $houseinformation, $shophouseinformation, $schoollinformation, $internationalschoollinformation, $serviceapartmentinformation, $timezone, $areacode, $vehicleregistration, $website);
        if ($update_datacity > 0) {
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
