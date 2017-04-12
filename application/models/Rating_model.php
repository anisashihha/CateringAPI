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
 * Description of Rating_model
 *
 * @author Anisa' Shihhatin Sholihah
 * 02 Agustus 2016
 */
class Rating_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function insert_rating($idtenant, $idaccount, $rating) {
        $this->db->set('idtenant', $idtenant);
        $this->db->set('idaccount', $idaccount);
        $this->db->set('rating', $rating);
        $this->db->insert('rating');
        $result = $this->db->affected_rows();

        if($result>0) {
            $sql = "SELECT * FROM tenants WHERE idtenant = ?";
            $query = $this->db->query($sql, array($idtenant));
            foreach ($query->result_array() as $row) {
                $this->db->set('idaccount', $idaccount);
                $this->db->set('activities', "Rate for-".$row['name']);
                $this->db->set('visitdate', date('Y-m-d H:i:s'));
                $this->db->set('idcategory', $row['idcategory']);
                $this->db->insert('history');
            }
        }

        return $result;
    }

    public function update_rating($idrating, $rating) {
        $sql = "UPDATE rating set rating=? WHERE idrating=?";
        $query = $this->db->query($sql, array($rating, $idrating));
        return $this->db->affected_rows();
    }

    public function delete_rating($idrating) {
        $sql = "DELETE FROM rating WHERE idrating=?";
        $query = $this->db->query($sql, array($idrating));
        return $this->db->affected_rows();
    }

}
