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
 * Description of Advertise_model
 *
 * @author Anisa' Shihhatin Sholihah 
 * 09 February 2017
 */
class Advertise_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function retrieve_get($idadvertise) {
        $query = "SELECT * FROM fn_get_advertise($idadvertise)";
        $query = $this->db->query($query);
        $retrieve_get = array();
        foreach ($query->result_array() as $row) {
            $temp = array('idadvertise' => $row['idadvertise'], 'idtenant' => $row['idtenant'], 'idproperty' => $row['idproperty'], 'advertise' => $row['advertise'], 'smalladvertise' => $row['smalladvertise']); // access attribute
            array_push($retrieve_get, $temp);
        }

        return $retrieve_get;
    }

    public function listadvertise($pagenumber, $pagesize) {
        $offset = ($pagenumber * $pagesize) - $pagesize;
        $squery = "select * from fn_get_listadvertise($pagesize, $offset);";
        $query = $this->db->query($squery);
        $listadvertise = array();
        foreach ($query->result_array() as $row) {
            $temp = array('idadvertise' => $row['idadvertise'], 'idtenant' => $row['idtenant'], 'idproperty' => $row['idproperty'], 'advertise' => $row['advertise'], 'smalladvertise' => $row['smalladvertise']); // access attributes
            array_push($listadvertise, $temp);
        }
        return $listadvertise;
    }

    public function listbycategory($idcategory, $pagenumber, $pagesize, $category) {
        $offset = ($pagenumber * $pagesize) - $pagesize;

        if($category=="property") {
            $squery = "select * from fn_get_listadvertiseproperty($idcategory, $offset, $pagesize)";
        } else {
            $squery = "select * from fn_get_listadvertise($idcategory, $offset, $pagesize)";
        }
        $query = $this->db->query($squery);

        $listbycategory = array();
        foreach ($query->result_array() as $row) {
            $temp = array('idadvertise' => $row['idadvertise'], 'idtenant' => $row['idtenant'], 'idproperty' => $row['idproperty'], 'advertise' => $row['advertise'], 'smalladvertise' => $row['smalladvertise']); // access attributes
            array_push($listbycategory, $temp);
        }
        return $listbycategory;
    }

    public function listadvertisefilterbyname($pagenumber, $pagesize, $keyword) {
        $offset = ($pagenumber * $pagesize) - $pagesize;
        $squery = "SELECT * FROM fn_get_listadvertise($offset, $pagesize, '" . strtolower($keyword) . "')";
        $query = $this->db->query($squery);
        $listadvertisefilterbyname = array();
        foreach ($query->result_array() as $row) {
            $temp = array('idadvertise' => $row['idadvertise'], 'idtenant' => $row['idtenant'], 'idproperty' => $row['idproperty'], 'advertise' => $row['advertise'], 'smalladvertise' => $row['smalladvertise']); // access attributes
            array_push($listadvertisefilterbyname, $temp);
        }
        return $listadvertisefilterbyname;
    }

    //GET COUNT advertise

    public function get_countadvertise() {
       // $squery = "SELECT COUNT(*) FROM advertise GROUP BY advertise";
        $squery = "SELECT COUNT(*) FROM advertise;";
        $query = $this->db->query($squery);
        $countadvertise = array();
        foreach ($query->result_array() as $row) {
            $temp = array('count' => $row['count']); // access attribute
            array_push($countadvertise, $temp);
        }
        return $countadvertise;
    }

    ////////////////////////////////////////////////////////////////////////////////////////
    public function insert_advertise($idtenant, $idproperty, $advertise, $smalladvertise) {
        if($idtenant!=null AND $idproperty==null) {
            $this->db->set('idtenant', $idtenant);
        } else if($idtenant==null AND $idproperty!=null) {
            $this->db->set('idproperty', $idproperty);
        } else {
            return 0;
        }
        
        $this->db->set('advertise', $advertise);
        $this->db->set('smalladvertise', $smalladvertise);
        $this->db->insert('advertise');

        return $this->db->affected_rows();
    }

    public function update_advertise($idadvertise, $idtenant, $idproperty, $advertise, $smalladvertise) {
        if($idtenant!=null AND $idproperty==null) {
            $sql = "UPDATE advertise set idtenant=?, advertise=?, smalladvertise=? WHERE idadvertise=?";
            $query = $this->db->query($sql, array($idtenant, $advertise, $smalladvertise, $idadvertise));
        } else if($idtenant==null AND $idproperty!=null) {
            $sql = "UPDATE advertise set idproperty=?, advertise=?, smalladvertise=? WHERE idadvertise=?";
            $query = $this->db->query($sql, array($idproperty, $advertise, $smalladvertise, $idadvertise));
        } else {
            return 0;
        }
        
        return $this->db->affected_rows();
    }

    public function delete_advertise($idadvertise) {
        $sql = "DELETE FROM advertise WHERE idadvertise=?";
        $query = $this->db->query($sql, array($idadvertise));
        return $this->db->affected_rows();
    }
}