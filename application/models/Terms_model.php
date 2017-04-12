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
 * Description of Notif_model
 *
 * @author Anisa' Shihhatin Sholihah 
 * 29 Juli 2016
 */
class Terms_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function listterms($idcity) {
        $sql = "SELECT * FROM terms WHERE idcity = ?";
        $query = $this->db->query($sql, array($idcity));

        if ($query) {
            $listterms = array();
            foreach ($query->result_array() as $row) {
                $temp = array('idterms' => $row['idterms'], 'idcity' => $row['idcity'], 'linkfile' => $row['linkfile'], 'title' => $row['title']);
                array_push($listterms, $temp);
            }
            return $listterms;
        } else {
            return null;
        }
    }

    ////////////////////////////////////////////////////////////////////////////
    public function insert_terms($idcity, $linkfile, $title) {
        $this->db->set('idcity', $idcity);
        $this->db->set('linkfile', $linkfile);
        $this->db->set('title', $title);
        $this->db->insert('terms');

        return $this->db->affected_rows();
    }

    public function update_terms($idterms, $linkfile, $title) {
        $sql = "UPDATE terms set linkfile=?, title=? WHERE idterms=?";
        $query = $this->db->query($sql, array($linkfile, $title, $idterms));

        return $this->db->affected_rows();
    }

    public function delete_terms($idterms) {
        $sql = "DELETE FROM terms WHERE idterms=?";
        $query = $this->db->query($sql, array($idterms));

        return $this->db->affected_rows();
    }

}
