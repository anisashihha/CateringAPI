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
 * Description of Avatar
 *
 * @author Anisa' Shihhatin Sholihah 
 * 29 Juni 2016
 */
require APPPATH . '/libraries/REST_Controller.php';

class Avatar extends REST_Controller {

    function __construct() {
        // Construct the parent class
        parent::__construct();
        $this->load->model('Avatar_model');
    }

    public function index_get() {
        // Users from a data store e.g. database
        $action = $this->get('action');
        switch ($action) {
            case "avatar_get":
                $this->avatar_get();
                break;
            default:
                $this->not_found();
                break;
        }
    }

    public function index_post() {
        $action = $this->post('action');
        switch ($action) {
            case "insert_avatar":
                $this->insert_avatar();
                break;
            case "update_avatar":
                $this->update_avatar();
                break;
            case "delete_avatar":
                $this->delete_avatar();
                break;
            default:
                $this->not_found();
                break;
        }
    }

    ////////////////////////////////////////////////////////////////////////////
    public function avatar_get() {
        $idtenant = $this->get('idtenant');
        $avatar_get = $this->Avatar_model->avatar_get($idtenant);
        if (!empty($avatar_get)) {
            $this->set_response($avatar_get, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    ////////////////////////////////////////////////////////////////////////////
    public function insert_avatar() { //INSERT
        $idavatar = $this->post('idavatar');
        $idtenant = $this->post('idtenant');
        $linkavatar = $this->post('linkavatar');


        $insert_avatar = $this->Avatar_model->insert_avatar($idavatar, $idtenant, $linkavatar);
        if ($insert_avatar > 0) {
            $this->set_response(array(['message' => 'success']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function update_avatar() { //UPDATE 
        $idavatar = $this->post('idavatar');
        $idtenant = $this->post('idtenant');
        $linkavatar = $this->post('linkavatar');

        $update_avatar = $this->Avatar_model->update_avatar($idavatar, $idtenant, $linkavatar);
        if ($update_avatar > 0) {
            $this->set_response(array(['message' => 'success']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function delete_avatar() { //DELETE
        $idavatar = $this->post('idavatar');
        $delete_avatar = $this->Avatar_model->delete_avatar($idavatar);
        if ($delete_avatar > 0) {
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
