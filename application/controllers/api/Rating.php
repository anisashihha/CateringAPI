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
 * Description of Rating
 *
 * @author Anisa' Shihhatin Sholihah
 * 02 Agustus 2016
 */
require APPPATH . '/libraries/REST_Controller.php';

class Rating extends REST_Controller {

    function __construct() {
        // Construct the parent class
        parent::__construct();
        $this->load->model('Rating_model');
    }

    public function index_post() {
        $action = $this->post('action');
        switch ($action) {
            case "insert_rating":
                $this->insert_rating();
                break;
            case "update_rating":
                $this->update_rating();
                break;
            case "delete_rating":
                $this->delete_rating();
                break;
            default:
                $this->not_found();
                break;
        }
    }

    ////////////////////////////////////////////////////////////////////////////
    public function insert_rating() { //INSERT
        $idtenant = $this->post('idtenant');
        $idaccount = $this->post('idaccount');
        $rating = $this->post('rating');


        $insert_rating = $this->Rating_model->insert_rating($idtenant, $idaccount, $rating);
        if ($insert_rating > 0) {
            $this->set_response(array(['message' => 'success']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function update_rating() { //UPDATE
        $idrating = $this->post('idrating');
        $rating = $this->post('rating');
        $update_rating = $this->Rating_model->update_rating($idrating, $rating);
        if ($update_rating > 0) {
            $this->set_response(array(['message' => 'success']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function delete_rating() { //DELETE
        $idrating = $this->post('idrating');
        $delete_rating = $this->Rating_model->delete_rating($idrating);
        if ($delete_rating > 0) {
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
