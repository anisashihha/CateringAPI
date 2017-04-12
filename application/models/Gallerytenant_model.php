
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
 * Description of Gallerytenant_model
 *
 * @author Anisa' Shihhatin Sholihah
 * 27 Juni 2016
 */
class Gallerytenant_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function listgallery($pagenumber, $pagesize) {
        $offset = ($pagenumber * $pagesize) - $pagesize;
        $query = $this->db->query("SELECT * FROM fn_get_listgallery($offset, $pagesize)");
        if (!empty($query)) {
            $gallery = array();
            foreach ($query->result_array() as $row) {
                $temp = array('status' => true, 'idgallery' => $row['idgallery'], 'idtenant' => $row['idtenant'], 'title' => stripslashes($row['title']), 'avatar' => $row['avatar']); // access attributes
                array_push($gallery, $temp);
            }
            return $gallery;
        } else {
            return null;
        }
    }



    public function insert_gallery($idtenant, $title, $avatar) {
        $this->db->set('idtenant', $idtenant);
        $this->db->set('title', $title);
        $this->db->set('avatar', $avatar);
        $this->db->insert('gallery');
        return $this->db->affected_rows();
    }

    public function update_gallery($idgallery, $title, $avatar) {
        $sql = "UPDATE gallery set title=?, avatar=? WHERE idgallery=?";
        $query = $this->db->query($sql, array($title, $avatar, $idgallery));
        return $this->db->affected_rows();
    }

    public function delete_gallery($idgallery) {
        $sql = "DELETE FROM gallery WHERE idgallery=?";
        $query = $this->db->query($sql, array($idgallery));
        return $this->db->affected_rows();
    }

}
