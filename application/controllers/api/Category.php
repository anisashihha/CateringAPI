<?php

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
 * @Category        Admin Web Server
 * @author1         Anisa' Shihhatin Sholihah
 * @license         DBA
 * @link            anisashihha73@gmail.com //http://anisass.wordpress.com
 */
/**
 * Description of Category
 *
 * @author Anisa' Shihhatin Sholihah 
 * 27 Juni 2016
 */
defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';

class Category extends REST_Controller {

    function __construct() {
        // Construct the parent class
        parent::__construct();
        $this->load->model('Category_model');
    }

    public function index_get() {
        // Users from a data store e.g. database
        $action = $this->get('action');
        switch ($action) {
            case "listallchild":
                $this->listallchild();
                break;
            case "listchild":
                $this->listchild();
                break;

            default:
                $this->not_found();
                break;
        }
    }

    ////////////////////////////////////////////////////////////////////////////

    public function listallchild() {
        $idcategory = $this->get('idcategory');
        $listallchild = $this->Category_model->listallchild($idcategory);
        if (!empty($listallchild)) {
            $this->set_response($listallchild, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function listchild() {
        $idcategory = $this->get('idcategory');
        $listchild = $this->Category_model->listchild($idcategory);
        if (!empty($listchild)) {
            $this->set_response($listchild, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
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
