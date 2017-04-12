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
 * Description of Forums
 *
 * @author Anisa' Shihhatin Sholihah
 * 03 Maret 2017
 */
require APPPATH . '/libraries/REST_Controller.php';

class Forums extends REST_Controller {

    function __construct() {
        // Construct the parent class
        parent::__construct();
        $this->load->model('Forums_model');
    }

    public function index_get() {
        // Users from a data store e.g. database
        $action = $this->get('action');
        switch ($action) {
            case "listforums":
                $this->listforums();
                break;
            case "listforumsfilterbyname":
                $this->listforumsfilterbyname();
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
            case "insert_forums":
                $this->insert_forums();
                break;
            case "update_forums":
                $this->update_forums();
                break;
            case "delete_forums":
                $this->delete_forums();
                break;
            default:
                $this->not_found();
                break;
        }
    }

    ////////////////////////////////////////////////////////////////////////////
    public function listforums() {
        $pagenumber = $this->get('pagenumber');
        $pagesize = $this->get('pagesize');
        $listforum = $this->Forums_model->listforums($pagenumber, $pagesize);
        if (!empty($listforum)) {
            $this->set_response($listforum, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function listforumsfilterbyname() {
        $pagenumber = $this->get('pagenumber');
        $pagesize = $this->get('pagesize');
        $keyword = trim($this->get('keyword'));
        $listforumsfilterbyname = $this->Forums_model->listforumsfilterbyname($pagenumber, $pagesize, $keyword);
        if (!empty($listforumsfilterbyname)) {
            $this->set_response($listforumsfilterbyname, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function retrieve_get() {
        $idforums = $this->get('idforums');
        $idaccount = $this->get('idaccount');

        $retrieve_get = $this->Forums_model->retrieve_get($idforums, $idaccount);
        if (!empty($retrieve_get)) {
            $this->set_response($retrieve_get, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    ////////////////////////////////////////////////////////////////////////////
    public function insert_forums() { //INSERT
        $idaccount = $this->post('idaccount');
        $title = addslashes($this->post('title'));
        $viewer = 0;
        $description = addslashes($this->post('description'));
        $avatar = $this->post('avatar');

        $insert_forums = $this->Forums_model->insert_forums($idaccount, $title, $viewer, $description, $avatar);
        if ($insert_forums > 0) {
            $this->set_response(array(['message' => 'success']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function update_forums() { //UPDATE
        $idforums = $this->post('idforums');
        $title = addslashes($this->post('title'));
        $description = addslashes($this->post('description'));
        $update_forums = $this->Forums_model->update_forums($idforums, $title, $description);
        if ($update_forums > 0) {
            $this->set_response(array(['message' => 'success']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function delete_forums() { //DELETE
        $idforums = $this->post('idforums');
        $delete_forums = $this->Forums_model->delete_forums($idforums);
        if ($delete_forums > 0) {
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
