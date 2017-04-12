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
 * Description of Publictranportation_model
 *
 * @author Anisa' Shihhatin Sholihah 
 * 27 Juni 2016
 */
class Publictransportation_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    ////////////////////////////////////////////////////////////////////////////////////////////////////////
     public function listpublictransport($idcity, $pagenumber, $pagesize) {
        $offset = ($pagenumber * $pagesize) - $pagesize;
        $sql = "select * from publictransportation WHERE idcity=? OFFSET ? LIMIT ?;";
        $query = $this->db->query($sql, array($idcity, $offset, $pagesize));
        $listpublictransport = array();
        foreach ($query->result_array() as $row) {
            $temp = array('idpublictransportation' => $row['idpublictransportation'], 'idcity' => $row['idcity'], 'publictransportcode' => $row['publictransportcode'], 'route' => $row['route']); // access attributes
            array_push($listpublictransport, $temp);
        }
        return $listpublictransport;
    }
    
    //tambahan 06-10-2016
    public function listpublictransportbyname($idcity, $pagenumber, $pagesize, $keyword) {
        $offset = ($pagenumber * $pagesize) - $pagesize;
        $query = "select * from fn_get_listpublictransportation($idcity, $offset, $pagesize ,'" . strtolower($keyword) . "')";
        $query = $this->db->query($query);
        $listpublictransportbyname = array();
        foreach ($query->result_array() as $row) {
            $temp = array('idcity' => $row['idcity'], 'idpublictransportation' => $row['idpublictransportation'], 'publictransportcode' => $row['publictransportcode'], 'route' => $row['route']); // access attributes
            array_push($listpublictransportbyname, $temp);
        }
        return $listpublictransportbyname;
    }


////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function insert_publictransportation($idcity, $publictransportcode, $route) {
        $this->db->set('idcity', $idcity);
        $this->db->set('publictransportcode ', $publictransportcode );
        $this->db->set('route ', $route );
        $this->db->insert('publictransportation');
        return $this->db->affected_rows();
    }

    public function update_publictransportation($idpublictransportation, $idcity, $publictransportcode, $route) {
        $sql = "UPDATE publictransportation set idcity=?, publictransportcode=?, route=? WHERE idpublictransportation=?";
        $query = $this->db->query($sql, array($idcity, $publictransportcode, $route, $idpublictransportation ));
        return $this->db->affected_rows();
    }

    public function delete_publictransportation($idpublictransportation) {
        $sql = "DELETE FROM publictransportation WHERE idpublictransportation=?";
        $query = $this->db->query($sql, array($idpublictransportation));
        return $this->db->affected_rows();
    }

}
