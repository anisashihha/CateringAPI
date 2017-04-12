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
 * Description of Avatar_model
 *
 * @author Anisa' Shihhatin Sholihah 
 * 29 Juni 2016
 */
class Avatar_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    ////////////////////////////////////////////////////////////////////////////
    public function avatar_get($idtenant) {
        $sql = "SELECT idavatar, idtenant, linkavatar FROM avatar WHERE idtenant = ?";
        $query = $this->db->query($sql, array($idtenant));
        $avatar = array();
        foreach ($query->result_array() as $row) {
            $temp = array('idavatar' => $row['idavatar'], 'idtenant' => $row['idtenant'], 'linkavatar' => $row['linkavatar']); // access attributes
            array_push($avatar, $temp);
        }
        return $avatar;
    }

    ////////////////////////////////////////////////////////////////////////////
    public function insert_avatar($idavatar, $idtenant, $linkavatar) {
        $this->db->set('idavatar', $idavatar);
        $this->db->set('idtenant', $idtenant);
        $this->db->set('linkavatar', $linkavatar);
        $this->db->insert('avatar');
        return $this->db->affected_rows();
    }

    public function update_avatar($idavatar, $idtenant, $linkavatar) {
        $sql = "UPDATE avatar SET linkavatar=? WHERE idavatar=? AND idtenant=?";
        $query = $this->db->query($sql, array($linkavatar, $idavatar, $idtenant ));

        return $this->db->affected_rows();
    }

    public function delete_avatar($idavatar) {
        $sql = "DELETE FROM avatar WHERE idavatar=?";
        $query = $this->db->query($sql, array($idavatar));
        return $this->db->affected_rows();
    }

}
