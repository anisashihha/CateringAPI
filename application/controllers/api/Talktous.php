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
 * Description of Talktous
 *
 * @author Anisa' Shihhatin Sholihah
 * 29 Juni 2016
 */
require APPPATH . '/libraries/REST_Controller.php';

class Talktous extends REST_Controller {

    function __construct() {
        // Construct the parent class
        parent::__construct();
        $this->load->model('Talktous_model');
    }

    public function index_get() {
        // Users from a data store e.g. database
        $action = $this->get('action');
        switch ($action) {
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
            case "update":
                $this->update_talktous();
                break;
            default:
                $this->not_found();
                break;
        }
    }

    ////////////////////////////////////////////////////////////////////////////
    public function retrieve_get() {
        $idtalktous = $this->get('idtalktous');
        $idcity = $this->get('idcity');

        $get = $this->Talktous_model->retrieve_get($idtalktous, $idcity);
        if (!empty($get)) {
            $this->set_response($get, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    ////////////////////////////////////////////////////////////////////////////
    public function update_talktous() { //UPDATE
        $idtalktous = $this->post('idtalktous');
        $header = addslashes($this->post('header'));
        $description = addslashes($this->post('description'));
        $heading1 = addslashes($this->post('heading1'));
        $content1 = addslashes($this->post('content1'));
        $heading2 = addslashes($this->post('heading2'));
        $content2 = addslashes($this->post('content2'));
        $content3 = addslashes($this->post('content3'));
        $content4 = addslashes($this->post('content4'));
        $emergencycall = addslashes($this->post('emergencycall'));
        $content5 = addslashes($this->post('content5'));
        $callcenter = addslashes($this->post('callcenter'));
        $idcity = $this->post('idcity');

        $update = $this->Talktous_model->update_talktous($idtalktous, $header, $description, $heading1, $content1, $heading2, $content2, $content3, $content4, $emergencycall, $content5, $callcenter, $idcity);
        if ($update > 0) {
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
