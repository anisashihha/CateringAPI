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
 * Description of Callcenter_model
 *
 * @author Anisa' Shihhatin Sholihah 
 * 25 Agustus 2016
 */
class Callcenter_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    //////////////////////////////////////////////////////////////////////////////
    public function retrieve_get($idcallcenter, $idcity) {
        $sql = "SELECT * FROM callcenter WHERE idcity = ? AND idcallcenter = ?";
        $query = $this->db->query($sql, array($idcity, $idcallcenter));
        $get = array();
        foreach ($query->result_array() as $row) {
            $temp = array('idcallcenter' => $row['idcallcenter'], 'idcity' => $row['idcity'], 'title' => $row['title'], 'description' => $row['description'], 'phone' => $row['phone']);
            array_push($get, $temp);
        }
        return $get;
    }

    //////////////////////////////////////////////////////////////////////////////
    public function insert_callcenter($idcity, $title, $description, $phone) {
        $this->db->set('idcity', $idcity);
        $this->db->set('title', $title);
        $this->db->set('description', $description);
        $this->db->set('phone', $phone);
        $this->db->insert('callcenter');
        return $this->db->affected_rows();
    }

    public function update_callcenter($idcallcenter, $idcity, $title, $description, $phone) {
        $sql = "UPDATE callcenter set idcity=?, title=?, description=?, phone=? WHERE idcallcenter=?";
        $query = $this->db->query($sql, array($idcity, $title, $description, $phone, $idcallcenter));
        return $this->db->affected_rows();
    }

    public function delete_callcenter($idcallcenter) {
        $sql = "DELETE FROM callcenter WHERE idcallcenter=?";
        $query = $this->db->query($sql, array($idcallcenter));
        return $this->db->affected_rows();
    }
}
