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
 * Description of Cctv
 *
 * @author Anisa' Shihhatin Sholihah 
 * 09 February 2017
 */
require APPPATH . '/libraries/REST_Controller.php';

class Cctv extends REST_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Cctv_model');
    }

    public function index_get() {
        $action = $this->get('action');
        switch ($action) {
            case "list":
                $this->listcctv();
                break;
            case "listcctvfilterbyname":
                $this->listcctvfilterbyname();
                break;
            default:
                $this->not_found();
                break;
        }
    }

    public function index_post() {
        $action = $this->post('action');
        switch ($action) {
            case "insert_cctv":
                $this->insert_cctv();
                break;
            case "update_cctv":
                $this->update_cctv();
                break;
            case "delete_cctv":
                $this->delete_cctv();
                break;
            default:
                $this->not_found();
                break;
        }
    }

    ///////////////////////////////////////////////////////////////////////////////////

    public function listcctv() { //GET data list cctv
        $idcity = $this->get('idcity');
        $pagenumber = $this->get('pagenumber');
        $pagesize = $this->get('pagesize');
        $list = $this->Cctv_model->listcctv($idcity, $pagenumber, $pagesize);
        if (!empty($list)) {
            $this->set_response($list, REST_Controller::HTTP_OK);
        } else {
            $this->not_found();
        }
    }

    public function listcctvfilterbyname() { //SEARCHING
        $idcity = $this->get('idcity');
        $pagenumber = $this->get('pagenumber');
        $pagesize = $this->get('pagesize');
        $keyword = "%".trim($this->get('keyword'))."%";
        $listcctvfilterbyname = $this->Cctv_model->listcctvfilterbyname($idcity, $pagenumber, $pagesize, $keyword);
        if (!empty($listcctvfilterbyname)) {
            $this->set_response($listcctvfilterbyname, REST_Controller::HTTP_OK);
        } else {
            $this->not_found();
        }
    }
        
    ///////////////////////////////////////////////////////////////////////////////////////

    public function insert_cctv() { //INSERT
        $idcity = $this->post('idcity');
        $name = $this->post('name');
        $link = $this->post('link');
        $port = $this->post('port');
        $username = $this->post('username');
        $password = $this->post('password');
        $channel = $this->post('channel');

        $insert_cctv = $this->Cctv_model->insert_cctv($idcity, $name, $link, $port, $username, $password, $channel);
        if ($insert_cctv > 0) {
            $this->set_response(array(['status' => true, 'message' => 'success']), REST_Controller::HTTP_OK);
        } else {
            $this->set_response(array(['status' => false, 'message' => 'failed']), REST_Controller::HTTP_OK);
        }
    }

    public function update_cctv() { //UPDATE
        $idcctv = $this->post('idcctv');
        $idcity = $this->post('idcity');
        $name = $this->post('name');
        $link = $this->post('link');
        $port = $this->post('port');
        $username = $this->post('username');
        $password = $this->post('password');
        $channel = $this->post('channel');
        

        $this->load->model('Cctv_model');
        $update_cctv = $this->Cctv_model->update_cctv($idcctv, $idcity, $name , $link, $port, $username, $password, $channel);
         if ($update_cctv > 0) {
            $this->set_response(array(['status' => true, 'message' => 'success']), REST_Controller::HTTP_OK);
        } else {
            $this->set_response(array(['status' => false, 'message' => 'failed']), REST_Controller::HTTP_OK);
        }
    }
    
    public function delete_cctv() {
        $idcctv = $this->post('idcctv');
        $this->load->model('Cctv_model');
        $delete_cctv = $this->Cctv_model->delete_cctv($idcctv);
         if ($delete_cctv > 0) {
            $this->set_response(array(['status' => true, 'message' => 'success']), REST_Controller::HTTP_OK);
        } else {
            $this->set_response(array(['status' => false, 'message' => 'failed']), REST_Controller::HTTP_OK);
        }
    }

    public function not_found() {
        $this->set_response([[
        'status' => FALSE,
        'message' => 'not found'
            ]], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
    }

}
