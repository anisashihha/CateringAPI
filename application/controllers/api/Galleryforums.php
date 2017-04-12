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
 * Description of Galleryforums
 *
 * @author Anisa' Shihhatin Sholihah 
 * 15 Agustus 2016
 */
require APPPATH . '/libraries/REST_Controller.php';

class Galleryforums extends REST_Controller {

    function __construct() {
        // Construct the parent class
        parent::__construct();
        $this->load->model('Galleryforums_model');
    }

    public function index_post() {
        $action = $this->post('action');
        switch ($action) {
            case "insert_galleryforums":
                $this->insert_galleryforums();
                break;
            case "update_galleryforums":
                $this->update_galleryforums();
                break;
            case "delete_galleryforums":
                $this->delete_galleryforums();
                break;
            default:
                $this->not_found();
                break;
        }
    }

////////////////////////////////////////////////////////////////////////////////
    public function insert_galleryforums() { //INSERT
        $idforums = $this->post('idforums');
        $avatar = $this->post('avatar');
        $insert_galleryforums = $this->Galleryforums_model->insert_galleryforums($idforums, $avatar);
        if ($insert_galleryforums > 0) {
            $this->set_response(array(['message' => 'success']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function update_galleryforums() { //UPDATE
        $idgalleryforums = $this->post('idgalleryforums');
        $avatar = $this->post('avatar');
        $update_galleryforums = $this->Galleryforums_model->update_galleryforums($idgalleryforums, $avatar);
        if ($update_galleryforums > 0) {
            $this->set_response(array(['message' => 'success']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function delete_galleryforums() { //DELETE
        $idgalleryforums = $this->post('idgalleryforums');
        $delete_galleryforums = $this->Galleryforums_model->delete_galleryforums($idgalleryforums);
        if ($delete_galleryforums > 0) {
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
