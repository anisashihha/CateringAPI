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
 * Description of Bookmark_model
 *
 * @author Anisa' Shihhatin Sholihah 
 * 27 Juni 2016
 */
class Bookmark_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function listbookmark($idaccount, $pagenumber, $pagesize) {
        $offset = ($pagenumber * $pagesize) - $pagesize;
        $query = "SELECT * FROM fn_get_listbookmark($idaccount, $offset, $pagesize)";
        $query = $this->db->query($query);
        $listbookmark = array();
        foreach ($query->result_array() as $row) {
            $temp = array('idbookmark' => $row['idbookmark'], 'idaccount' => $row['idaccount'], 'idtenant' => $row['idtenant'], 'idproperty' => $row['idproperty'], 'avatar' => $row['avatar'], 'tenantname' => $row['tenantname'], 'address' => $row['address'], 'longlat' => $row['longlat']); // access attributes
            array_push($listbookmark, $temp);
        }
        return $listbookmark;
    }
    
    public function listbookmarkfilterbyname($idaccount, $pagenumber, $pagesize, $idtenant) {
        $offset = ($pagenumber * $pagesize) - $pagesize;
        $query = "select * from fn_get_listbookmark($idaccount, $offset, $pagesize, $idtenant)";
        $query = $this->db->query($query);
        $listbookmarkfilterbyname = array();
        foreach ($query->result_array() as $row) {
            $temp = array('idbookmark' => $row['idbookmark'], 'idaccount' => $row['idaccount'], 'idtenant' => $row['idtenant'], 'idproperty' => $row['idproperty'], 'avatar' => $row['avatar'], 'tenantname' => $row['tenantname'], 'address' => $row['address'], 'longlat' => $row['longlat']); // access attributes
            array_push($listbookmarkfilterbyname, $temp);
        }
        return $listbookmarkfilterbyname;
    }

    public function retrieve_get($idbookmark) {
        //$dayname = strtolower(date('l'));
        $query = "SELECT * FROM fn_get_detailbookmark ($idbookmark)";
        $query = $this->db->query($query);
        $retrieve_get = array();
        foreach ($query->result_array() as $row) {
            $temp = array('idbookmark' => $row['idbookmark'], 'idaccount' => $row['idaccount'], 'idtenant' => $row['idtenant'], 'idproperty' => $row['idproperty'], 'avatar' => $row['avatar'], 'tenantname' => $row['tenantname'], 'address' => $row['address'], 'longlat' => $row['longlat']); // access attribute
            array_push($retrieve_get, $temp);
        }
        return $retrieve_get;
    }

    ////////////////////////////////////////////////////////////////////////////
    
    public function insert_bookmark($idaccount, $idtenant, $idproperty) {
        if($idtenant!=null AND $idproperty==null) { 
            $sql = "SELECT * FROM bookmark WHERE idaccount=? AND idtenant=?";
            $query = $this->db->query($sql, array($idaccount, $idtenant));
            $affect = $this->db->affected_rows();
        } else if($idtenant==null AND $idproperty!=null) {
            $sql = "SELECT * FROM bookmark WHERE idaccount=? AND idproperty=?";
            $query = $this->db->query($sql, array($idaccount, $idproperty));
            $affect = $this->db->affected_rows();
        } else {
            $affect = -1;
        }

        if($affect == 0) {
            $this->db->set('idaccount', $idaccount);
            if($idtenant!=null) $this->db->set('idtenant', $idtenant);
            else if($idproperty!=null) $this->db->set('idproperty', $idproperty);
            $this->db->insert('bookmark');
            return $this->db->affected_rows();   
        } else if($affect > 0) {
            return -1;
        } else {
            return 0;
        }
    }

    public function delete_bookmark($idbookmark) {
        $sql = "DELETE FROM bookmark WHERE idbookmark=?";
        $query = $this->db->query($sql, array($idbookmark));
        return $this->db->affected_rows();
    }

}
