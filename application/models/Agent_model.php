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
 * Description of Agent_model
 *
 * @author Anisa' Shihhatin Sholihah 
 * 10 Agustus 2016
 */
class Agent_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function retrieve_get($idagent) {
        $query = "SELECT * FROM fn_get_agent ($idagent)";
        $query = $this->db->query($query);
        $retrieve_get = array();
        foreach ($query->result_array() as $row) {
            $temp = array('idagent' => $row['idagent'], 'name' => $row['name'], 'avatar' => $row['avatar'], 'email' => $row['email'], 'phone' => $row['phone']); // access attribute
            array_push($retrieve_get, $temp);
        }

        return $retrieve_get;
    }

    public function listagent($pagenumber, $pagesize) {
        $offset = ($pagenumber * $pagesize) - $pagesize;
        $squery = "select * from fn_get_listagent($offset, $pagesize);";
        $query = $this->db->query($squery);
        $listagent = array();
        foreach ($query->result_array() as $row) {
            $temp = array('idagent' => $row['idagent'], 'avatar' => $row['avatar'], 'name' => $row['name'], 'email' => $row['email'], 'phone' => $row['phone']); // access attributes
            array_push($listagent, $temp);
        }
        return $listagent;
    }

    ///// tambahan 25/08/2016
    public function listbyagent($idagent, $pagenumber, $pagesize) {
        $offset = ($pagenumber * $pagesize) - $pagesize;
        $squery = "select * from fn_get_listpropertybyagent($idagent, $offset, $pagesize);";
        $query = $this->db->query($squery);
        $listbyagent = array();
        foreach ($query->result_array() as $row) {
            $temp = array('idproperty' => $row['idproperty'], 'idagent' => $row['idagent'], 'categoryname' => $row['categoryname'], 'name' => $row['name'], 'type' => $row['type'], 'price' => $row['price'], 'avatar' => $row['avatar'], 'lb' => $row['lb'], 'lt' => $row['lt'], 'status' => $row['status'], 'email' => $row['email'], 'phone' => $row['phone'] ); // access attributes
            array_push($listbyagent, $temp);
        }
        return $listbyagent;
    }


    //////////////////////////////////////////////////////////////////////////////
    public function insert_agent($name, $avatar, $email, $phone) {
        $this->db->set('name', $name);
        $this->db->set('avatar', $avatar);
        $this->db->set('email', $email);
        $this->db->set('phone', $phone);
        $this->db->insert('agent');
        return $this->db->affected_rows();
    }

    public function update_agent($idagent, $name, $avatar, $email, $phone) {
        $sql = "UPDATE agent set name=?, avatar=?, email=?, phone=? WHERE idagent=?";
        $query = $this->db->query($sql, array($name, $avatar, $email, $phone, $idagent));
        return $this->db->affected_rows();
    }

    public function delete_agent($idagent) {
        $sql = "DELETE FROM agent WHERE idagent=?";
        $query = $this->db->query($sql, array($idagent));
        return $this->db->affected_rows();
    }
}
