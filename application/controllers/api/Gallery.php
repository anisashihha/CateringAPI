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
 * Description of Gallery
 *
 * @author Anisa' Shihhatin Sholihah
 * 12 Agustus 2016
 */
require APPPATH . '/libraries/REST_Controller.php';

class Gallery extends REST_Controller {

    function __construct() {
        // Construct the parent class
        parent::__construct();
        $this->load->model('Gallery_model');
    }

    public function index_get() {
        // Users from a data store e.g. database
        $action = $this->get('action');
        switch ($action) {

            case "listgallery":
                $this->listgallery();
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
            default:
                $this->not_found();
                break;
        }
    }

    ////////////////////////////////////////////////////////////////////////////
    public function listgallery() {
        $pagenumber = $this->get('pagenumber');
        $pagesize = $this->get('pagesize');
        $idgallery = $this->get('idgallery');
        $title = $this->get('title');
        $avatar = $this->get('avatar');
        $listgallery = $this->Gallery_model->listgallery($pagenumber, $pagesize, $idgallery, $title, $avatar);
        if (!empty($listgallery)) {
            $this->set_response($listgallery, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    ////////////////////////////////////////////////////////////////////////////
    public function insert_gallery() { //INSERT
        $idcity = $this->post('idcity');
        $title = addslashes($this->post('title'));
        $avatar = $this->post('avatar');


        $insert_gallery = $this->Gallery_model->insert_gallery($idcity, $title, $avatar);
        if ($insert_gallery > 0) {
            $this->set_response(array(['message' => 'success']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function update_gallery() { //UPDATE
        $idgallery = $this->post('idgallery');
        $title = addslashes($this->post('title'));
        $avatar = $this->post('avatar');
        $update_gallery = $this->Gallery_model->update_gallery($idgallery, $title, $avatar);
        if ($update_gallery > 0) {
            $this->set_response(array(['message' => 'success']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function delete_gallery() { //DELETE
        $idgallery = $this->post('idgallery');
        $delete_gallery = $this->Gallery_model->delete_gallery($idgallery);
        if ($delete_gallery > 0) {
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
