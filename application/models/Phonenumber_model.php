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
 * Description of phonenumber_model
 *
 * @author Anisa' Shihhatin Sholihah 
 * 29 Juni 2016
 */
class phonenumber_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    ////////////////////////////////////////////////////////////////////////////
    public function phonenumber_get($idcity) {
        $sql = "SELECT idphonenumber, idcity, name, phonenumber FROM phonenumber WHERE idcity = ?";
        $query = $this->db->query($sql, array($idcity));
        $phonenumber = array();
        foreach ($query->result_array() as $row) {
            $temp = array('idphonenumber' => $row['idphonenumber'], 'idcity' => $row['idcity'], 'name' => $row['name'], 'phonenumber' => $row['phonenumber']); // access attributes
            array_push($phonenumber, $temp);
        }
        return $phonenumber;
    }

    ////////////////////////////////////////////////////////////////////////////
    public function insert_phonenumber($idcity, $name, $phonenumber) {
        $this->db->set('idcity', $idcity);
        $this->db->set('name', $name);
        $this->db->set('phonenumber', $phonenumber);
        $this->db->insert('phonenumber');
        return $this->db->affected_rows();
    }

    public function update_phonenumber($idphonenumber, $idcity, $name, $phonenumber) {
        $sql = "UPDATE phonenumber SET name=?, phonenumber=? WHERE idphonenumber=? AND idcity=?";
        $query = $this->db->query($sql, array($name, $phonenumber, $idphonenumber, $idcity));        
        return $this->db->affected_rows();
    }

    public function delete_phonenumber($idphonenumber) {
        $sql = "DELETE FROM phonenumber WHERE idphonenumber=?";
        $query = $this->db->query($sql, array($idphonenumber)); 
        return $this->db->affected_rows();
    }

}
