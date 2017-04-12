<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
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
class Account extends REST_Controller {

    function __construct() {
        // Construct the parent class
        parent::__construct();

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        // $this->methods['user_get']['limit'] = 500; // 500 requests per hour per user/key
        // $this->methods['user_post']['limit'] = 100; // 100 requests per hour per user/key
        // $this->methods['user_delete']['limit'] = 50; // 50 requests per hour per user/key

        $this->load->model('Account_model');
    }

    /**
     *
     */
    public function index_get() {
        // Users from a data store e.g. database
        $action = $this->get('action');
        switch ($action) {
            case "retrieve_get":
            $this->retrieve_get();
            break;
            case "listaccount":
            $this->listaccount();
            break;
            case "checkemailexist":
            $this->checkemailexist();
            break;
            default:
            $this->not_found();
            break;
        }
    }

    /*
    **********************************************************************************************
    */

    public function index_post() {
        $action = $this->input->post('action');
        switch ($action) {
            case "login":
            $this->login();
            break;
            case "register":
            $this->register();
            break;
            case "change_password":
            $this->change_password();
            break;
            case "insert_account":
            $this->insert_account();
            break;
            case "update_account":
            $this->update_account();
            break;
            case "delete_account":
            $this->delete_account();
            break;
            case "forget_password":
            $this->forget_password();
            break;
            case "gen_code":
            $this->gen_code();
            break;
            case "check_code":
            $this->check_code();
            break;
            default :
            $this->not_found();
            break;
        }
    }

    //====================================================================================================

    public function retrieve_get() {
        $idaccount = $this->get('idaccount');
        $profile = $this->Account_model->retrieve_get($idaccount);
        if (!empty($profile)) {
            $this->set_response($profile, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function listaccount() {
        $idaccount = $this->get('idaccount');
        $account = $this->Account_model->listaccount($idaccount);
        if (!empty($account)) {
            $this->set_response($account, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function login() {
        $email = addslashes($this->input->post('email'));
        $password = $this->input->post('password');
        $login= $this->Account_model->login($email, $password);
        if ($login['status'] == true) {
            $this->set_response($login['dataresult'], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->set_response($login['dataresult'], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }
    }



    /**
     * REST API Upload using native CI Upload class.
     * @param avatar - multipart/form-data file
     * @return upload data array || error string
     */

    public function register() {
        $privilege = $this->input->post('privilege');
        $fullname = addslashes($this->input->post('fullname'));
        $gender = $this->input->post('gender'); //Boolean
        $dateofbirth = $this->input->post('dateofbirth')==NULL?NULL:$this->input->post('dateofbirth');

        //Get true format for phone -> 62___________
        $phone = $this->input->post('phone') == '' ? null : $this->input->post('phone');
        if($phone!=null) {
            if(substr($phone,0,1)=="+") {
                $phone = substr($phone,1);
            }
            if(substr($phone,0,1)=="0") {
                $phone = "62".substr($phone,1);
            }
        }

        $email = addslashes($this->input->post('email'));
        $password = $this->my_lib->hashing($this->input->post('password'));
        $pscode = $this->input->post('pscode')==NULL?NULL:$this->input->post('pscode');
        $register = $this->Account_model->register($email, $password, $privilege, $fullname, $gender, $dateofbirth, $phone,  $pscode);

        if ($register['affected'] > 0) {
            /*$this->set_response(array(['status' => true, 'message' => 'success', 'idaccount' => $register['idaccount']]), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code*/

            $base_thirdapi_activate = base_thirdapi_activate();
            $url = '';

            foreach($base_thirdapi_activate as $key => $value) {
                if($key=='email') {
                    $url .= $value.$email;
                } else if($key=='name') {
                    $url .= $value.$fullname;
                } else {
                    $url .= $value;
                }
            }

            header("Location: ".$url);
        } else {
            $this->set_response($register['dataresult'], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }
    }

    /////////////////////////TAMBAHAN 19/07/2016
    public function checkemailexist() {
        $email = $this->get('email');
        $check = $this->Account_model->checkemailexist($email);
        if ($check==1) {
            $this->set_response(array(['status' => TRUE, 'message' => 'available']), REST_Controller::HTTP_OK);
        } else {
            $this->set_response(array(['status' => FALSE, 'message' => 'unavailable']), REST_Controller::HTTP_OK);
        }
    }

    public function forget_password() {
        if(addslashes($this->post('contact'))!=null) {

            $contact = addslashes($this->post('contact'));

            if(preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", $contact)) {
                $type = "email";
            } else if(is_numeric(substr($contact, 1))) {
                //Get true format for phone -> 62___________
                if(substr($contact,0,1)=="+") {
                    $contact = substr($contact,1);
                }
                if(substr($contact,0,1)=="0") {
                    $contact = "62".substr($contact,1);
                }

                $type = "phone";
            } else {
                $contact = "false";
                $type = "email";
            }
        } else {
            $contact = "false2";
            $type = "email";
        }

        $forget = $this->Account_model->forget_password($contact, $type);

        if ($forget['status']==true) {
            $this->set_response(array(['status' => true, 'idaccount' => $forget['idaccount'], 'contact' => $forget['contact'], 'type' => $forget['type']]), REST_Controller::HTTP_OK);
        } else {
            $this->set_response(array($forget), REST_Controller::HTTP_OK);
        }
    }

    public function gen_code() {
        $idaccount = $this->post('idaccount');
        $contact = addslashes($this->post('contact'));
        $type = $this->post('type');

        $gen_code = $this->Account_model->gen_code($idaccount, $contact);

        if ($gen_code['status']==true) {
            $url = '';

            if($type=="phone") {
                //$url = "http://139.255.61.242:8080/lksmspush/senderId=LIPPOCKRG&campaignName=LCMOBILEAPP&phone=".$gen_code['contact']."&message=Your%20verification%20code%20is%20".$gen_code['codeconfirm'];
                $base_thirdapi_sms = base_thirdapi_sms();

                foreach($base_thirdapi_sms as $key => $value) {
                    if($key=='phone') {
                        $url .= $value.stripslashes($gen_code['contact']);
                    } else if($key=='message') {
                        $url .= $value.$gen_code['codeconfirm'];
                    } else {
                        $url .= $value;
                    }
                }
            } else if($type=="email") {
                $base_thirdapi_forget = base_thirdapi_forget();

                foreach($base_thirdapi_forget as $key => $value) {
                    if($key=='email') {
                        $url .= $value.stripslashes($gen_code['contact']);
                    } else if($key=='message') {
                        $url .= $value.$gen_code['codeconfirm'];
                    } else {
                        $url .= $value;
                    }
                }
            }

            header("Location: ".$url);
        } else {
            $this->set_response(array($gen_code), REST_Controller::HTTP_OK);
        }
    }

    public function check_code() {
        $code = $this->post('codeConfirm');
        $idaccount = $this->post('idaccount');
        $check = $this->Account_model->check_code($code, $idaccount);
        if ($check > 0) {
            $this->set_response(array(['status' => true, 'message' => 'passed']), REST_Controller::HTTP_OK);
        } else {
            $this->set_response(array(['status' => false, 'message' => 'unpassed']), REST_Controller::HTTP_OK);
        }
    }
    /////////////////////////////////////


    public function update_account() { //UPDATE
        $idaccount = $this->post('idaccount');
        $privilege = $this->post('privilege');
        $email = addslashes($this->post('email'));
        $gender = $this->post('gender');

        //Get true format for phone -> 62___________
        $phone = $this->input->post('phone') == '' ? null : $this->input->post('phone');
        if($phone!=null) {
            if(substr($phone,0,1)=="+") {
                $phone = substr($phone,1);
            }
            if(substr($phone,0,1)=="0") {
                $phone = "62".substr($phone,1);
            }
        }

        $dateofbirth = $this->input->post('dateofbirth')==NULL?NULL:$this->input->post('dateofbirth');
        $fullname = addslashes($this->post('fullname'));
        $password = $this->my_lib->hashing($this->post('password'));
        $address = addslashes($this->post('address'));
        $avatar = $this->post('avatar');
        $pscode = $this->post('pscode')==NULL?NULL:$this->input->post('pscode');;

        $update_account = $this->Account_model->update_account($idaccount, $privilege, $gender, $phone, $dateofbirth, $fullname, $password, $email, $address, $avatar, $pscode);
        if ($update_account['status'] == true) {
            $this->set_response(array(['status' => true, 'message' => 'success']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->set_response($update_account['dataresult'], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }
    }

    public function delete_account() { //DELETE
        $idaccount = $this->post('idaccount');
        $delete_account = $this->Account_model->delete_account($idaccount);
        if ($delete_account > 0) {
            $this->set_response(array(['message' => 'success']), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function change_password() { //UPDATE
        $idaccount = $this->post('idaccount');
        $password = $this->my_lib->hashing($this->post('password'));

        $change_password = $this->Account_model->change_password($idaccount,$password);
        if ($change_password > 0) {
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
