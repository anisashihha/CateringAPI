<?php

defined('BASEPATH') OR exit('No direct script access allowed');
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
// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';

class Dining extends REST_Controller {

    function __construct() {
        // Construct the parent class
        parent::__construct();
        $this->load->model('Dining_model');
    }

    public function index_get() {
        // Users from a data store e.g. database
        $action = $this->get('action');
        switch ($action) {
            case "list":
                $this->list1();
                break;
            case "retrieve":
                $this->set_response("retrieve", REST_Controller::HTTP_OK);
                break;
            default:
                $this->not_found();
                break;
        }
    }

    public function index_post() {
        $action = $this->post('action');
        switch ($action) {
            case "insert":
                $this->insert();
                break;
            case "update":
                $this->update();
                break;
            case "delete":
                $this->delete();
                break;
            default:
                $this->not_found();
                break;
        }
    }

    ///////////////////////////////////////////////////////////////////////////////////

    public function list1() {
        $this->set_response("{berhasil}", 200);
        //return "berhasil";
    }

    public function retrieve1() {
        $idcategory = $this->get('idcategory');
        $this->load->model('Dining_model');
        $retrieve = $this->Dining_model->retrieve1($idcategory);
        $this->set_response("{Retrieve}", 200);
        
    }

///////////////////////////////////////////////////////////////////////////////////////
    public function insert() { //INSERT
        $idcategory = $this->post('idcategory');
        $name = $this->post('name');
        $avatar = $this->post('avatar');
        $address = $this->post('address');
        $point_longlat = $this->post('point_longlat');
        $premium = $this->post('premium');
        $phone = $this->post('phone');

        $insert = $this->Dining_model->insert($idcategory, $name, $avatar, $address, $point_longlat, $premium, $phone);
        if (!empty($insert)) {
            $this->set_response($insert, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function update() { //UPDATE
        $idtenant = $this->post('idtenant');
        $idcategory = $this->post('idcategory');
        $name = $this->post('name');
        $avatar = $this->post('avatar');
        $address = $this->post('address');
        $longlat = $this->post('longlat');
        $premium = $this->post('premium');
        $phone = $this->post('phone');

      
        $update = $this->Dining_model->update($idtenant, $idcategory, $name, $avatar, $address, $longlat, $premium, $phone);
        if ($update > 0) {
            $this->set_response(array(['message' => 'success']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function delete() { //DELETE
        $idtenant = $this->post('idtenant');
        $deletet = $this->Dining_model->delete($idtenant);
        if ($delete > 0) {
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

