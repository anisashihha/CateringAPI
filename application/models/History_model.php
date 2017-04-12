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
 * Description of History_model
 *
 * @author Anisa' Shihhatin Sholihah
 * 09 Agustus 2016
 */
class History_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function listhistory($idaccount, $pagenumber, $pagesize) {
        $offset = ($pagenumber * $pagesize) - $pagesize;
        $query = $this->db->query("SELECT * FROM fn_get_listhistory($idaccount, $offset, $pagesize)");
        if (!empty($query)) {
            $history = array();
            foreach ($query->result_array() as $row) {
                $activities = str_replace('-', ' ', $row['activities']);
                $temp = array('idhistory' => $row['idhistory'], 'idcategory' => $row['idcategory'], 'idaccount' => $row['idaccount'], 'activities' => stripslashes($activities), 'visitdate' => $row['visitdate'], 'categoryname' => $row['name']); // access attributes
                array_push($history, $temp);
            }
            return $history;
        } else {
            return null;
        }
    }

    public function retrieve_get($idaccount) {
        $query = "SELECT * FROM fn_get_history($idaccount)";
        $query = $this->db->query($query);
        if ($query->result_array()) {
            $retrieve_get = array();
            foreach ($query->result_array() as $row) {
                $activities = str_replace('-', ' ', $row['activities']);
                $temp = array('idhistory' => $row['idhistory'], 'idaccount' => $row['idaccount'], 'activities' => stripslashes($activities), 'visitdate' => $row['visitdate'], 'idcategory' => $row['idcategory']); // access attribute
                array_push($retrieve_get, $temp);
            }
        }
        $detail['detail'] = $retrieve_get;
        return $detail;
    }

    ////////////////////////////////////////////////////////////////////////////

    public function insert_history($idaccount, $activities, $visitdate, $idcategory) {
        $this->db->set('idaccount', $idaccount);
        $this->db->set('activities', $activities);
        $this->db->set('visitdate', date('Y-m-d H:i:s'));
        $this->db->set('idcategory', $idcategory);
        $this->db->insert('history');
        return $this->db->affected_rows();
    }

    public function update_history($idhistory, $idaccount, $activities, $visitdate, $idcategory) {
        $sql = "UPDATE history set idaccount=?, activities=?, visitdate=?, idcategory=? WHERE idhistory=?";
        $query = $this->db->query($sql, array($idaccount, $activities, $visitdate, $idcategory, $idhistory));
        return $this->db->affected_rows();
    }

    public function delete_history($idhistory) {
        $sql = "DELETE FROM history WHERE idhistory=?";
        $query = $this->db->query($sql, array($idhistory));
        return $this->db->affected_rows();
    }

}
