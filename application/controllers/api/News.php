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
 * Description of News
 *
 * @author Anisa' Shihhatin Sholihah
 * 27 Juni 2016
 */
require APPPATH . '/libraries/REST_Controller.php';

class News extends REST_Controller {

    function __construct() {
        // Construct the parent class
        parent::__construct();
        $this->load->model('News_model');
    }

    public function index_get() {
        // Users from a data store e.g. database
        $action = $this->get('action');
        switch ($action) {

            case "listnews":
                $this->listnews();
                break;
            case "listnewsfilterbyname":
                $this->listnewsfilterbyname();
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
            case "insert_news":
                $this->insert_news();
                break;
            case "update_news":
                $this->update_news();
                break;
            case "delete_news":
                $this->delete_news();
                break;
            default:
                $this->not_found();
                break;
        }
    }

    ////////////////////////////////////////////////////////////////////////////
    
    public function listnews() {
        $pagenumber = $this->get('pagenumber');
        $pagesize = $this->get('pagesize');
        $lang = addslashes($this->get('lang'));
        $listnews = $this->News_model->listnews($pagenumber, $pagesize, $lang);
        if (!empty($listnews)) {
            $this->set_response($listnews, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function listnewsfilterbyname() {
        $pagenumber = $this->get('pagenumber');
        $pagesize = $this->get('pagesize');
        $keyword = "%".trim($this->get('keyword'))."%";
        $lang = $this->get('lang');
        $listnewsfilterbyname = $this->News_model->listnewsfilterbyname($pagenumber, $pagesize, $keyword, $lang);
        if (!empty($listnewsfilterbyname)) {
            $this->set_response($listnewsfilterbyname, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function retrieve_get() {
        $idnews = $this->get('idnews');
        $retrieve_get = $this->News_model->retrieve_get($idnews);
        if (!empty($retrieve_get)) {
            $this->set_response($retrieve_get, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    ////////////////////////////////////////////////////////////////////////////

    public function insert_news() { //INSERT
        $avatar = $this->post('avatar');
        $createdate = date("Y-m-d h:i:s");
        $title = addslashes($this->post('title'));
        $description = addslashes($this->post('description'));
        $title_en = addslashes($this->post('title_en'));
        $description_en = addslashes($this->post('description_en'));

        $insert_news = $this->News_model->insert_news($avatar, $createdate, $title, $description, $title_en, $description_en);
        if ($insert_news > 0) {
            $this->set_response(array(['status' => true, 'message' => 'success']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->set_response(array(['status' => false, 'message' => 'failed']), REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function update_news() { //UPDATE
        $idnews = $this->post('idnews');
        $avatar = $this->post('avatar');
        $title = addslashes($this->post('title'));
        $description = addslashes($this->post('description'));
        $title_en = addslashes($this->post('title_en'));
        $description_en = addslashes($this->post('description_en'));

        $update_news = $this->News_model->update_news($idnews, $avatar, $title, $description, $title_en, $description_en);
        if ($update_news > 0) {
            $this->set_response(array(['status' => true, 'message' => 'success']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->set_response(array(['status' => false, 'message' => 'failed']), REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function delete_news() { //DELETE
        $idnews = $this->post('idnews');
        $delete_news = $this->News_model->delete_news($idnews);
        if ($delete_news > 0) {
            $this->set_response(array(['status' => true, 'message' => 'success']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
             $this->set_response(array(['status' => false, 'message' => 'failed']), REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function not_found() {
        $this->set_response([[
        'status' => FALSE,
        'message' => 'not found'
            ]], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
    }

}
