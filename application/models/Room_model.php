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
 * Description of Room_model
 *
 * @author Anisa' Shihhatin Sholihah
 * 27 Juli 2016
 */
class Room_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function retrieve_get($idproperty) {
        $query = "SELECT * FROM fn_get_detailproperty ($idproperty)";
        $query = $this->db->query($query);
        $retrieve_get = array();
        foreach ($query->result_array() as $row) {
            $temp = array('idproperty' => $row['idproperty'], 'name' => $row['name'], 'idroom' => $row['idroom']); // access attribute
            array_push($retrieve_get, $temp);
        }
        $detail['detail'] = $retrieve_get;

        $room = "SELECT * FROM fn_get_listroom_byproperty($idroom) ";
        $room = $this->db->query($room);

        if ($room->result_array()) {
            $roomarray = array();
            foreach ($room->result_array() as $row) {
                $temp = array('idroom' => $row['idroom'], 'name' => $row['name']); // access attribute
                array_push($menuarray, $temp);
            }
            $detail['room'] = $roomarray;
        }
    }

    public function listbyproperty($idproperty, $pagenumber, $pagesize) {
        $offset = ($pagenumber * $pagesize) - $pagesize;
        $squery = "select * from fn_get_listroom_byproperty($idproperty, $offset, $pagesize);";
        $query = $this->db->query($squery);
        $listbyproperty = array();
        foreach ($query->result_array() as $row) {
            $temp = array('idproperty' => $row['idproperty'], 'idroom' => $row['idroom'], 'name' => $row['name'], 'jumlah' => $row['jumlah']); // access attributes
            array_push($listbyproperty, $temp);
        }
        return $listbyproperty;
    }

    ////////////////////////////////////////////////////////////////////////////
    public function insert_room($idproperty, $name, $jumlah) {
        $this->db->set('idproperty', $idproperty);
        $this->db->set('name', $name);
        $this->db->set('jumlah', $jumlah);

        $this->db->insert('room');
        return $this->db->affected_rows();
    }

    public function update_room($idroom, $idproperty, $name, $jumlah) {
        $sql = "UPDATE room set name=?, jumlah=? WHERE idroom=?";
        $query = $this->db->query($sql, array($name, $jumlah, $idroom));
        return $this->db->affected_rows();
    }

    public function delete_room($idroom) {
        $sql = "DELETE FROM room WHERE idroom=?";
        $query = $this->db->query($sql, array($idroom));
        return $this->db->affected_rows();
    }

}
