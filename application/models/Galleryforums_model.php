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
 * Description of Galleryforums_model
 *
 * @author Anisa' Shihhatin Sholihah 
 * 15 Agustus 2016
 */
class Galleryforums_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function insert_galleryforums($idforums, $avatar) {
        $this->db->set('idforums', $idforums);
        $this->db->set('avatar', $avatar);
        $this->db->insert('galleryforums');
        return $this->db->affected_rows();
    }

    public function update_galleryforums($idgalleryforums, $avatar) {
        $sql = "UPDATE galleryforums set avatar=? WHERE idgalleryforums=?";
        $query = $this->db->query($sql, array($avatar, $idgalleryforums));
        return $this->db->affected_rows();
    }

    public function delete_galleryforums($idgalleryforums) {
        $sql = "DELETE FROM galleryforums WHERE idgalleryforums=?";
        $query = $this->db->query($sql, array($idgalleryforums));
        return $this->db->affected_rows();
    }

}
