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
 * Description of openhour
 *
 * @author Anisa' Shihhatin Sholihah 
 * 08 Agustus 2016
 */
require APPPATH . '/libraries/REST_Controller.php';

class Openhour extends REST_Controller {

    function __construct() {
        // Construct the parent class
        parent::__construct();
        $this->load->model('Openhour_model');
    }

    public function index_get() {
        // Users from a data store e.g. database
        $action = $this->get('action');
        switch ($action) {
            case "openhour_get":
                $this->openhour_get();
                break;
            default:
                $this->not_found();
                break;
        }
    }

    public function index_post() {
        $action = $this->post('action');
        switch ($action) {
            case "insert_openhour":
                $this->insert_openhour();
                break;
            case "update_openhour":
                $this->update_openhour();
                break;
            case "delete_openhour":
                $this->delete_openhour();
                break;
            default:
                $this->not_found();
                break;
        }
    }

////////////////////////////////////////////////////////////////////////////////
    public function openhour_get() {
        $idtenant = $this->get('idtenant');
        $openhour_get = $this->Openhour_model->openhour_get($idtenant);
        if (!empty($openhour_get)) {
            $this->set_response($openhour_get, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

////////////////////////////////////////////////////////////////////////////////
    public function insert_openhour() { //INSERT
        $idopenhour = $this->post('idopenhour');
        $idtenant = $this->post('idtenant');
        $day = $this->post('day');
        $openhour = $this->post('openhour');
        $closehour = $this->post('closehour');
        $open = $this->post('open');

        $insert_openhour = $this->Openhour_model->insert_openhour($idopenhour, $idtenant, $day, $openhour, $closehour, $open);
        if ($insert_openhour > 0) {
            $this->set_response(array(['message' => 'success']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function update_openhour() { //UPDATE 
        $idopenhour = $this->post('idopenhour');
        $dayname = $this->post('dayname');
        $openhour = $this->post('openhour');
        $closehour = $this->post('closehour');
        $open = $this->post('open');


        $update_openhour = $this->Openhour_model->update_openhour($idopenhour, $dayname, $openhour, $closehour, $open);
        if ($update_openhour > 0) {
            $this->set_response(array(['message' => 'success']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function delete_openhour() { //DELETE
        $idopenhour = $this->post('idopenhour');
        $delete_openhour = $this->Openhour_model->delete_openhour($idopenhour);
        if ($delete_openhour > 0) {
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
