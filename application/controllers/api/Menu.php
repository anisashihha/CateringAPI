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
 * Description of Menu
 *
 * @author Anisa' Shihhatin Sholihah
 * 29 Juni 2016
 */
require APPPATH . '/libraries/REST_Controller.php';

class Menu extends REST_Controller {

    function __construct() {
        // Construct the parent class
        parent::__construct();
        $this->load->model('Menu_model');
    }

    public function index_get() {
        // Users from a data store e.g. database
        $action = $this->get('action');
        switch ($action) {
            case "menu_select":
                $this->menu_select();
                break;

            default:
                $this->not_found();
                break;
        }
    }

    public function index_post() {
        $action = $this->post('action');
        switch ($action) {
            case "insert_menu":
                $this->insert_menu();
                break;
            case "update_menu":
                $this->update_menu();
                break;
            case "delete_menu":
                $this->delete_menu();
                break;
            default:
                $this->not_found();
                break;
        }
    }

    ////////////////////////////////////////////////////////////////////////////
    public function menu_select() {
        $idtenant = $this->get('idtenant');
        $menu = $this->Menu_model->menu_select($idtenant);
        if (!empty($menu)) {
            $this->set_response($menu, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    ////////////////////////////////////////////////////////////////////////////
    public function insert_menu() { //INSERT
        $idtenant = $this->post('idtenant');
        $menu = $this->post('menu');
        $price = $this->post('price') != '' ? $this->post('price') : null;
        $linkcatalog = $this->post('linkcatalog');
        $filename = $this->post('filename');
        $filesize = $this->post('filesize') != '' ? $this->post('filesize') : null;

        $insert_menu = $this->Menu_model->insert_menu($idtenant, $menu, $price, $linkcatalog, $filename, $filesize);
        if ($insert_menu > 0) {
            $this->set_response(array(['message' => 'success']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function update_menu() { //UPDATE 
        $idmenu = $this->post('idmenu');
        $menu = $this->post('menu');
        $price = $this->post('price') != '' ? $this->post('price') : 'null';
        $linkcatalog = $this->post('linkcatalog');
        $filename = $this->post('filename');
        $filesize = $this->post('filesize');


        $update_menu = $this->Menu_model->update_menu($idmenu, $menu, $price, $linkcatalog);
        if ($update_menu > 0) {
            $this->set_response(array(['message' => 'success']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function delete_menu() { //DELETE
        $idmenu = $this->post('idmenu');
        $delete_menu = $this->Menu_model->delete_menu($idmenu);
        if ($delete_menu > 0) {
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
