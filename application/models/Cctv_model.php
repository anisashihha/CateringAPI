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
 * Description of Cctv_model
 *
 * @author Anisa' Shihhatin Sholihah 
 * 27 Juni 2016
 */
class Cctv_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////
    // LIST ALL CCTV 
    ////////////////////////////////////////////////////////////////////////////////////////////////////////
     public function listcctv($idcity, $pagenumber, $pagesize) {
        $offset = ($pagenumber * $pagesize) - $pagesize;
        $sql = "select * from cctv WHERE idcity=? OFFSET ? LIMIT ?;";
        $query = $this->db->query($sql, array($idcity, $offset, $pagesize));
        $listcctv = array();
        foreach ($query->result_array() as $row) {
            $temp = array('idcity' => $row['idcity'], 'idcctv' => $row['idcctv'], 'ipaddress' => $row['link'], 'port' => $row['port'], 'username' => $row['username'], 'password' => $row['password'], 'channel' => $row['channel'], 'label' => $row['name']);
            array_push($listcctv, $temp);
        }
        return $listcctv;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // SEARCH LIST CCTV
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function listcctvfilterbyname($idcity, $pagenumber, $pagesize, $keyword) {
        $offset = ($pagenumber * $pagesize) - $pagesize;
        $query = $this->db->query("SELECT * FROM fn_get_listcctv_bycity(".$idcity.", ".$offset.", ".$pagesize.", '".strtolower($keyword)."')");
        $listcctvfilterbyname = array();
        foreach ($query->result_array() as $row) {
            $temp = array('idcity' => $row['idcity'], 'idcctv' => $row['idcctv'], 'ipaddress' => $row['link'], 'port' => $row['port'], 'username' => $row['username'], 'password' => $row['password'], 'channel' => $row['channel'], 'label' => $row['name']);
            array_push($listcctvfilterbyname, $temp);
        }

        return $listcctvfilterbyname;
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function insert_cctv($idcity, $name, $link, $port, $username, $password, $channel) {
        $this->db->set('idcity', $idcity);
        $this->db->set('name', $name);
        $this->db->set('link', $link);
        $this->db->set('port', $port);
        $this->db->set('username', $username);
        $this->db->set('password', $password);
        $this->db->set('channel', $channel);

        $this->db->insert('cctv');
        return $this->db->affected_rows();
    }
   
    public function update_cctv($idcctv, $idcity, $name, $link, $port, $username, $password, $channel) {
        $sql = "UPDATE cctv set idcity=?, name=?, link=?, port=?, username=?, password=?, channel=? WHERE idcctv=?";
        $query = $this->db->query($sql, array($idcity, $name, $link, $port, $username, $password, $channel, $idcctv));
        return $this->db->affected_rows();
    }

    public function delete_cctv($idcctv) {
        $sql = "DELETE FROM cctv WHERE idcctv=?";
        $query = $this->db->query($sql, array($idcctv));
        return $this->db->affected_rows();
    }
    
}