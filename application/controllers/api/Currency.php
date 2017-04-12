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
 * Description of Currency
 *
 * @author Anisa' Shihhatin Sholihah 
 * 27 Juni 2016
 */
require APPPATH . '/libraries/REST_Controller.php';

class Currency extends REST_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Currency_model');
    }

    public function index_get() {
        $action = $this->get('action');
        switch ($action) {
            case "currency":
            $this->currency();
            break;
            case "listcountry":
            $this->listcountry();
            break;
            default:
            $this->not_found();
            break;
        }
    }

    public function index_post() {
        $action = $this->post('action');
        switch ($action) {
            case "insert_country":
            $this->insert_country();
            break;
            case "update_country":
            $this->update_country();
            break;
            case "delete_country":
            $this->delete_country();
            break;
            default:
            $this->not_found();
            break;
        }
    }

    ////////////////////////////////////////////////////////////////////////////
    
    public function currency() {
        $url = "http://api.fixer.io/latest?base=IDR";

        header("Location: ".$url);
    }

    public function listcountry() {
        $pagenumber = $this->get('pagenumber');
        $pagesize = $this->get('pagesize');

        $listcountry = $this->Currency_model->listcountry($pagenumber, $pagesize);
        if (!empty($listcountry)) {
            $this->set_response($listcountry, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->set_response(array(['status' => false]), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }
    }

    ////////////////////////////////////////////////////////////////////////////

    public function insert_country() {
        $country_code = $this->post('country_code');
        $flag = $this->post('flag');

        $insert = $this->Currency_model->insert_country($country_code, $flag);
        if ($insert > 0) {
            $this->set_response(array(['status' => true, 'message' => 'success']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->set_response(array(['status' => false]), REST_Controller::HTTP_OK);
        }
    }

    public function update_country() {
        $idcountry = $this->post('idcountry');
        $country_code = $this->post('country_code');
        $flag = $this->post('flag');

        $update = $this->Currency_model->update_country($idcountry, $country_code, $flag);
        if ($update > 0) {
            $this->set_response(array(['status' => true, 'message' => 'success']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->set_response(array(['status' => false]), REST_Controller::HTTP_OK);
        }
    }

    public function delete_country() {
        $idcountry = $this->post('idcountry');

        $delete = $this->Currency_model->delete_country($idcountry);
        if ($delete > 0) {
            $this->set_response(array(['status' => true, 'message' => 'success']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->set_response(array(['status' => false]), REST_Controller::HTTP_OK);
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
