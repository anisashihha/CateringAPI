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
 * Description of Openhour_model
 *
 * @author Anisa' Shihhatin Sholihah 
 * 08 Agustus 2016
 */
class Openhour_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

////////////////////////////////////////////////////////////////////////////////
    public function openhour_get($idtenant) {
        $sql = "SELECT idopenhour, idtenant, dayname, openhour, closehour, open, dayid FROM openhour WHERE idtenant = ?"; //////
        $query = $this->db->query($sql, array($idtenant));
        $openhour = array();
        foreach ($query->result_array() as $row) {
            $temp = array('idopenhour' => $row['idopenhour'], 'idtenant' => $row['idtenant'], 'dayname' => $row['dayname'], 'openhour' => $row['openhour'], 'closehour' => $row['closehour'], 'open' => $row['open'], 'dayid' => $row['dayid']); // access attributes
            array_push($openhour, $temp);
        }
        return $openhour;
    }

////////////////////////////////////////////////////////////////////////////////
    public function insert_openhour($idopenhour, $idtenant, $day, $openhour, $closehour, $open) {
        $this->db->set('idopenhour', $idopenhour);
        $this->db->set('idtenant', $idtenant);
        $this->db->set('day', $day);
        $this->db->set('openhour', $openhour);
        $this->db->set('closehour', $closehour);
        $this->db->set('open', $open);
        $this->db->insert('openhour');
        return $this->db->affected_rows();
    }

    public function update_openhour($idopenhour, $dayname, $openhour, $closehour, $open) {
        $sql = "UPDATE openhour SET dayname=?, openhour=?, closehour=?, open=? WHERE idopenhour=?";
        $query = $this->db->query($sql, array($dayname, $openhour, $closehour, $open, $idopenhour));
        return $this->db->affected_rows();
    }

    public function delete_openhour($idopenhour) {
        $sql = "DELETE FROM openhour WHERE idopenhour=?";
        $query = $this->db->query($sql, array($idopenhour));
        return $this->db->affected_rows();
    }

}
