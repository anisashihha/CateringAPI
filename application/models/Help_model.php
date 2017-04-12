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
 * Description of Help_model
 *
 * @author Anisa' Shihhatin Sholihah 
 * 10 Agustus 2016
 */
class Help_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function retrieve_get($idhelp, $idcity) {
        $sql = "SELECT * FROM help WHERE idcity = ? AND idhelp = ?";
        $query = $this->db->query($sql, array($idcity, $idhelp));
        $get = array();
        foreach ($query->result_array() as $row) {
            $temp = array('idhelp' => $row['idhelp'], 'description' => $row['description'], 'idcity' => $row['idcity'],);
            array_push($get, $temp);
        }
        return $get;
    }

    //////////////////////////////////////////////////////////////////////////////
    public function update_help($idhelp, $description, $idcity) {
        $sql = "UPDATE help SET description=? WHERE idhelp=? AND idcity=?";
        $this->db->query($sql, array($description, $idhelp, $idcity));
        return $this->db->affected_rows();
    }

}
