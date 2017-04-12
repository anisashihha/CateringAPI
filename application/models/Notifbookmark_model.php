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
 * Description of Notifbookmark_model
 *
 * @author Anisa' Shihhatin Sholihah 
 * 27 Juni 2016
 */
class Notifbookmark_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function listnotifbookmark($idaccount, $pagenumber, $pagesize) {
        $offset = ($pagenumber * $pagesize) - $pagesize;
        $query = "SELECT * FROM fn_get_listnotifbookmark($idaccount, $offset, $pagesize)";
        $query = $this->db->query($query);
        $listnotifbookmark = array();
        foreach ($query->result_array() as $row) {
            $temp = array('idnotifbookmark' => $row['idnotifbookmark'], 'idnotif' => $row['idnotif'], 'idaccount' => $row['idaccount']); // access attributes
            array_push($listnotifbookmark, $temp);
        }
        return $listnotifbookmark;
    }
    
    ////////////////////////////////////////////////////////////////////////////
    
    public function insert_notifbookmark($idnotif, $idaccount) {
        $sql = "SELECT * FROM notif WHERE idnotif=?";
        $this->db->query($sql, array($idnotif));
        if($this->db->affected_rows() > 0) {
            $sql = "SELECT * FROM notifbookmark WHERE idnotif=? AND idaccount=?";
            $this->db->query($sql, array($idnotif, $idaccount));
            if($this->db->affected_rows() == 0) {
                $this->db->set('idnotif', $idnotif);
                $this->db->set('idaccount', $idaccount);
                $this->db->insert('notifbookmark');
                return $this->db->affected_rows();   
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

    public function delete_notifbookmark($idnotifbookmark) {
        $sql = "DELETE FROM notifbookmark WHERE idnotifbookmark=?";
        $query = $this->db->query($sql, array($idnotifbookmark));
        return $this->db->affected_rows();
    }

}
