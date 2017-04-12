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
 * Description of Discountcoupon
 *
 * @author Anisa' Shihhatin Sholihah 
 * 22 November 2016
 */
require APPPATH . '/libraries/REST_Controller.php';

class Discountcoupon extends REST_Controller {

    function __construct() {
        // Construct the parent class
        parent::__construct();
        $this->load->model('Discountcoupon_model');
    }
    
    

    public function index_get() {
        // Users from a data store e.g. database
        $action = $this->get('action');
        switch ($action) {
            case "discountlist":
                $this->discountlist();
                break;
            case "listdiscountcoupon":
                $this->discountlist();
                break;
            case "retrieve_get":
                $this->retrieve_get();
                break;
            case "listdiscountcouponbycategory":
                $this->listdiscountcouponbycategory();
                break;
            // case "listdiscountcoupon":
            //     $this->listdiscountcoupon();
            //  break;
            case "listdiscountcouponfilterbyname":
                $this->listdiscountcouponfilterbyname();
                break;
            case "listdiscountcouponbytenant":
                $this->listdiscountcouponbytenant();
                break;
            default:
                $this->not_found();
                break;
        }
    }

    public function index_post() {
        $action = $this->post('action');
        switch ($action) {
            case "insert_discountcoupon":
                $this->insert_discountcoupon();
                break;
            case "update_discountcoupon":
                $this->update_discountcoupon();
                break;
            case "delete_discountcoupon":
                $this->delete_discountcoupon();
                break;
            default:
                $this->not_found();
                break;
        }
    }

    ///////////////////////////////////////////////////////////////////////////////////
    public function discountlist() {
        $pagenumber = $this->get('pagenumber');
        $pagesize = $this->get('pagesize');

        $discountlist = $this->Discountcoupon_model->discountlist($pagenumber, $pagesize);
        if (!empty($discountlist)) {
            $this->set_response($discountlist, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function retrieve_get() {
        $idtenant = $this->get('idtenant');
        $pagenumber = $this->get('pagenumber');
        $pagesize = $this->get('pagesize');
        
        $retrieve_get = $this->Discountcoupon_model->retrieve_get($idtenant, $pagenumber, $pagesize);
        if (!empty($retrieve_get)) {
            $this->set_response($retrieve_get, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function listdiscountcouponbycategory() {
        $idcategory = $this->get('idcategory');
        $pagenumber = $this->get('pagenumber');
        $pagesize = $this->get('pagesize');

        $listdiscountcouponbycategory = $this->Discountcoupon_model->listdiscountcouponbycategory($idcategory, $pagenumber, $pagesize);
        if (!empty($listdiscountcouponbycategory)) {
            $this->set_response($listdiscountcouponbycategory, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function listdiscountcoupon() {
        $pagenumber = $this->get('pagenumber');
        $pagesize = $this->get('pagesize');
        $listdiscountcoupon = $this->Discountcoupon_model->listdiscountcoupon($pagenumber, $pagesize);
    //     if (!empty($listdiscountcoupon)) {
    //         $this->set_response($listdiscountcoupon, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
    //     } else {
    //         $this->not_found();
    //     }
    // }
    if ($listdiscountcoupon > 0) {
            $this->set_response(array(['status' => true, 'message' => 'success']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->set_response(array(['status' => false, 'message' => 'failed']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }
    }

    public function listdiscountcouponfilterbyname() {
        $pagenumber = $this->get('pagenumber');
        $pagesize = $this->get('pagesize');
        $keyword = trim($this->get('keyword'));
        $listdiscountcouponfilterbyname = $this->Discountcoupon_model->listdiscountcouponfilterbyname($pagenumber, $pagesize, $keyword);
        if (!empty($listdiscountcouponfilterbyname)) {
            $this->set_response($listdiscountcouponfilterbyname, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }


    public function listdiscountcouponbytenant() {
         $idtenant = $this->get('idtenant');
        $listdiscountcouponbytenant = $this->Discountcoupon_model->listdiscountcouponbytenant($idtenant);
        if (!empty($listdiscountcouponbytenant)) {
            $this->set_response($listdiscountcouponbytenant, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }
        
     ///////////////////////////////////////////////////////////////////////////////////////
    public function insert_discountcoupon() { //INSERT
        $idtenant = $this->post('idtenant');
        $imageurl = $this->post('imageurl');
        $title = $this->post('title');
        $caption = $this->post('caption') != null ? $this->post('caption') : null;
        $fileurl = $this->post('fileurl');
        $filename = $this->post('filename');
        $filesize = $this->post('filesize');
        $idcategory = $this->post('idcategory');

        $insert_discountcoupon = $this->Discountcoupon_model->insert_discountcoupon($idtenant, $imageurl, $title, $caption, $fileurl, $filename, $filesize, $idcategory);
        if ($insert_discountcoupon > 0) {
            $this->set_response(array(['status' => true, 'message' => 'success']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->set_response(array(['status' => false, 'message' => 'failed']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }
    }

    public function update_discountcoupon() { //UPDATE
        $iddiscountcoupon = $this->post('iddiscountcoupon');
        $idtenant = $this->post('idtenant');
        $imageurl = $this->post('imageurl');
        $title = $this->post('title');
        $caption = $this->post('caption') != null ? $this->post('caption') : null;
        $fileurl = $this->post('fileurl');
        $filename = $this->post('filename');
        $filesize = $this->post('filesize');
        $idcategory = $this->post('idcategory');
    
        $update_discountcoupon = $this->Discountcoupon_model->update_discountcoupon($iddiscountcoupon, $idtenant, $imageurl, $title, $caption, $fileurl, $filename, $filesize, $idcategory);
         if ($update_discountcoupon > 0) {
            $this->set_response(array(['status' => true, 'message' => 'success']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->set_response(array(['status' => false, 'message' => 'failed']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }
    }
    
    public function delete_discountcoupon() { //DELETE
        $iddiscountcoupon = $this->post('iddiscountcoupon');
        $this->load->model('Discountcoupon_model');
        $delete_discountcoupon = $this->Discountcoupon_model->delete_discountcoupon($iddiscountcoupon);
         if ($delete_discountcoupon > 0) {
            $this->set_response(array(['status' => true, 'message' => 'success']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->set_response(array(['status' => false, 'message' => 'failed']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }
    }

    public function not_found() {
        $this->set_response([[
        'status' => FALSE,
        'message' => 'not found'
            ]], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
    }

}
