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
 * Description of Forums_model
 *
 * @author Anisa' Shihhatin Sholihah
 * 03 Maret 2016
 */
class Forums_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function listforums($pagenumber, $pagesize) {
        $offset = ($pagenumber * $pagesize) - $pagesize;
        $query_list = $this->db->query("SELECT * FROM fn_get_listforums($offset, $pagesize)");
        if (!empty($query_list)) {
            $listforums = array();
            foreach ($query_list->result_array() as $row) {
                $sql = "select count (*) as count FROM comment WHERE idforums = ?";
                $query_count = $this->db->query($sql, array($row['idforums']));
                foreach ($query_count->result_array() as $subrow) {
                    $temp = array('status' => true, 'idforums' => $row['idforums'], 'idaccount' => $row['idaccount'], 'title' => stripslashes($row['title']), 'idprofile' => $row['idprofile'], 'fullname' => stripslashes($row['fullname']), 'avatar' => $row['avatar'], 'viewer' => $row['viewer'], 'createdate' => $row['createdate'], 'comment' => $subrow['count']); // access attributes
                    array_push($listforums, $temp);
                }
            }

            return $listforums;
        }
    }

    public function listforumsfilterbyname($pagenumber, $pagesize, $keyword) {
        $offset = ($pagenumber * $pagesize) - $pagesize;
        $query_list = $this->db->query("SELECT * FROM fn_get_listforums($offset, $pagesize, '" . strtolower($keyword) . "')");
        if (!empty($query_list)) {
            $listforumsfilterbyname = array();
            foreach ($query_list->result_array() as $row) {
                $sql = "select count (*) as count FROM comment WHERE idforums = ?";
                $query_count = $this->db->query($sql, array($row['idforums']));
                foreach ($query_count->result_array() as $subrow) {
                    $temp = array('status' => true, 'idforums' => $row['idforums'], 'idaccount' => $row['idaccount'], 'title' => stripslashes($row['title']), 'idprofile' => $row['idprofile'], 'fullname' => stripslashes($row['fullname']), 'avatar' => $row['avatar'], 'viewer' => $row['viewer'], 'createdate' => $row['createdate'], 'comment' => $subrow['count']); // access attributes
                    array_push($listforumsfilterbyname, $temp);
                }
            }

            return $listforumsfilterbyname;
        }
    }

    public function retrieve_get($idforums, $idaccount) {
        $dayname = strtolower(date('l'));
        $query = "SELECT * FROM fn_get_detailforums ($idforums)";
        $query = $this->db->query($query);
        $retrieve_get = array();
        foreach ($query->result_array() as $row) {
            $temp = array('idforums' => $row['idforums'], 'idaccount' => $row['idaccount'], 'title' => stripslashes($row['title']), 'fullname' => stripslashes($row['fullname']), 'avatar' => $row['avatar'], 'viewer' => $row['viewer'], 'description' => stripslashes($row['description']), 'createdate' => $row['createdate']); // access attribute
            array_push($retrieve_get, $temp);
        }
        $detail['detail'] = $retrieve_get;

        $comment = "SELECT * FROM fn_get_comment($idforums) ";
        $comment = $this->db->query($comment);

        if ($comment->result_array()) {
            $commentarray = array();
            foreach ($comment->result_array() as $row) {
                $temp = array('idcomment' => $row['idcomment'], 'idaccount' => $row['idaccount'], 'fullname' => stripslashes($row['fullname']), 'avatar' => $row['avatar'], 'idforums' => $row['idforums'], 'comment' => $row['comment'], 'createdate' => $row['createdate']); // access attribute
                array_push($commentarray, $temp);
            }
            $detail['comment'] = $commentarray;
        }

        $galleryforums = "SELECT * FROM fn_get_listgalleryforums($idforums)";
        $galleryforums = $this->db->query($galleryforums);

        if ($galleryforums->result_array()) {
            $galleryforumsarray = array();
            foreach ($galleryforums->result_array() as $row) {
                $temp = array('idgalleryforums' => $row['idgalleryforums'], 'idforums' => $row['idforums'], 'avatar' => $row['avatar']); // access attribute
                array_push($galleryforumsarray, $temp);
            }
            $detail['galleryforums'] = $galleryforumsarray;
        }

        if($idaccount!=null) {
            $squery = "SELECT viewer FROM forums WHERE idforums = ?";
            $query = $this->db->query($squery, array($idforums));
            foreach ($query->result_array() as $row) {
                $newviewer = $row['viewer'] + 1;
                $sql = "UPDATE forums set viewer=? WHERE idforums=?";
                $this->db->query($sql, array($newviewer, $idforums));
            }
        }

        return $detail;
    }

    ////////////////////////////////////////////////////////////////////////////
    public function insert_forums($idaccount, $title, $viewer, $description, $avatar) {
        $this->db->set('idaccount', $idaccount);
        $this->db->set('title', $title);
        $this->db->set('viewer', $viewer);
        $this->db->set('description', $description);
        $this->db->set('createdate', date('Y-m-d H:i:s'));
        $this->db->insert('forums');

        if ($this->db->affected_rows() > 0) {
            $avatar1 = explode(',', $avatar);
            $idforums = $this->db->insert_id();
            foreach ($avatar1 as $file) {
                $file_data = array(
                    'idforums' => $idforums,
                    'avatar' => $file
                    );
                $this->db->insert('galleryforums', $file_data);
            }

            return $this->db->affected_rows();
        } else {
            return 0;
        }
    }

    public function update_forums($idforums, $title, $description) {
        $sql = "UPDATE forums set title=?,  description=?  WHERE idforums=?";
        $query = $this->db->query($sql, array($title, $description, $idforums));
        return $this->db->affected_rows();
    }

    public function delete_forums($idforums) {
        $sql = "DELETE FROM forums WHERE idforums=?";
        $query = $this->db->query($sql, array($idforums));
        if($this->db->affected_rows()>0) {
            $sql = "DELETE FROM galleryforums WHERE idforums=?";
            $query = $this->db->query($sql, array($idforums));
            return $this->db->affected_rows();
        } else {
            return 0;
        }
    }

}
