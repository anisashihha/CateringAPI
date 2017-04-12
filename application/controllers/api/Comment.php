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
 * Description of Comment
 *
 * @author Anisa' Shihhatin Sholihah
 * 27 Juni 2016
 */
require APPPATH . '/libraries/REST_Controller.php';

class Comment extends REST_Controller {

    function __construct() {
        // Construct the parent class
        parent::__construct();
        $this->load->model('Comment_model');
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
            case "insert_comment":
                $this->insert_comment();
                break;
            case "update_comment":
                $this->update_comment();
                break;
            case "delete_comment":
                $this->delete_comment();
                break;
            default:
                $this->not_found();
                break;
        }
    }

    ////////////////////////////////////////////////////////////////////////////
    public function retrieve_get() {
        $idcomment = $this->get('idcomment');
        $retrieve_get = $this->Comment_model->retrieve_get($idcomment);
        if (!empty($retrieve_get)) {
            $this->set_response($retrieve_get, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    ////////////////////////////////////////////////////////////////////////////
    public function insert_comment() { //INSERT
        $idaccount = $this->post('idaccount');
        $idforums = $this->post('idforums');
        $comment = addslashes($this->post('comment'));

        $insert_comment = $this->Comment_model->insert_comment($idaccount, $idforums, $comment);
        if ($insert_comment > 0) {
            $this->set_response(array(['message' => 'success']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function update_comment() { //UPDATE
        $idcomment = $this->post('idcomment');
        $comment = addslashes($this->post('comment'));
        // $createdate = $this->post('createdate');


        $update_comment = $this->Comment_model->update_comment($idcomment, $comment);
        if ($update_comment > 0) {
            $this->set_response(array(['message' => 'success']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function delete_comment() { //DELETE
        $idcomment = $this->post('idcomment');
        $delete_comment = $this->Comment_model->delete_comment($idcomment);
        if ($delete_comment > 0) {
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
