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
 * @category        Admin Web Server
 * @author1         Anisa' Shihhatin Sholihah
 * @license         DBA
 * @link            anisashihha73@gmail.com //http://anisass.wordpress.com
 */

/**
 * Description of Application_model
 *
 * @author Anisa' Shihhatin Sholihah 
 * 27 Juni 2016
 */
class Application_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function retrieve_get($idapplication) {
        $query = "SELECT * FROM fn_get_detailapplication ($idapplication)";
        $query = $this->db->query($query);
        $retrieve_get = array();
        foreach ($query->result_array() as $row) {
            $temp = array('idapplication' => $row['idapplication'], 'name' => $row['name'], 'androidversion' => $row['androidversion'], 'iosversion' => $row['iosversion']); // access attribute
            array_push($retrieve_get, $temp);
        }
        return $retrieve_get;
    }

}
