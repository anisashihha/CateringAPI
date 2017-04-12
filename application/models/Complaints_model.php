
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
 * Description of Complaints_model
 *
 * @author Anisa' Shihhatin Sholihah
 * 21 February 2017
 */
class Complaints_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function listcomplaints($pagenumber, $pagesize) {
        $offset = ($pagenumber * $pagesize) - $pagesize;
        $query_list = $this->db->query("SELECT * FROM fn_get_listcomplaints($offset, $pagesize)");
        if (!empty($query_list)) {
            $listcomplaints = array();
            foreach ($query_list->result_array() as $row) {
                $sql = "select count (*) as count FROM comment WHERE idcomplaints = ?";
                $query_count = $this->db->query($sql, array($row['idforums']));
                foreach ($query_count->result_array() as $subrow) {
                    $temp = array('status' => true, 'idcomplaints' => $row['idcomplaints'], 'idaccount' => $row['idaccount'], 'title' => stripslashes($row['title']), 'idprofile' => $row['idprofile'], 'fullname' => stripslashes($row['fullname']), 'avatar' => $row['avatar'], 'viewer' => $row['viewer'], 'createdate' => $row['createdate'], 'comment' => $subrow['count']); // access attributes
                    array_push($listcomplaints, $temp);
                }
            }

            return $listcomplaints;
        }
    }

    public function listcomplaintsfilterbyname($pagenumber, $pagesize, $keyword) {
        $offset = ($pagenumber * $pagesize) - $pagesize;
        $query_list = $this->db->query("SELECT * FROM fn_get_listcomplaints($offset, $pagesize, '" . strtolower($keyword) . "')");
        if (!empty($query_list)) {
            $listcomplaintsfilterbyname = array();
            foreach ($query_list->result_array() as $row) {
                $sql = "select count (*) as count FROM comment WHERE idcomplaints = ?";
                $query_count = $this->db->query($sql, array($row['idcomplaints']));
                foreach ($query_count->result_array() as $subrow) {
                    $temp = array('status' => true, 'idcomplaints' => $row['idcomplaints'], 'idaccount' => $row['idaccount'], 'title' => stripslashes($row['title']), 'idprofile' => $row['idprofile'], 'fullname' => stripslashes($row['fullname']), 'avatar' => $row['avatar'], 'viewer' => $row['viewer'], 'createdate' => $row['createdate'], 'comment' => $subrow['count']); // access attributes
                    array_push($listcomplaintsfilterbyname, $temp);
                }
            }

            return $listcomplaintsfilterbyname;
        }
    }


    public function retrieve_get($idcomplaints) {
        $dayname = strtolower(date('l'));
        $query = "SELECT * FROM fn_get_detailcomplaints ($idcomplaints)";
        $query = $this->db->query($query);
        $retrieve_get = array();
        foreach ($query->result_array() as $row) {
            $temp = array('idcomplaints' => $row['idcomplaints'], 'idaccount' => $row['idaccount'], 'title' => stripslashes($row['title']), 'fullname' => stripslashes($row['fullname']), 'avatar' => $row['avatar'], 'viewer' => $row['viewer'], 'description' => stripslashes($row['description']), 'createdate' => $row['createdate']); // access attribute
            array_push($retrieve_get, $temp);
        }
        $detail['detail'] = $retrieve_get;

        $comment = "SELECT * FROM fn_get_comment($idcomplaints) ";
        $comment = $this->db->query($comment);

        if ($comment->result_array()) {
            $commentarray = array();
            foreach ($comment->result_array() as $row) {
                $temp = array('idcomment' => $row['idcomment'], 'idaccount' => $row['idaccount'], 'fullname' => stripslashes($row['fullname']), 'avatar' => $row['avatar'], 'idcomplaints' => $row['idcomplaints'], 'comment' => $row['comment'], 'createdate' => $row['createdate']); // access attribute
                array_push($commentarray, $temp);
            }
            $detail['comment'] = $commentarray;
        }

        $gallerycomplaints = "SELECT * FROM fn_get_listgallerycomplaints($idcomplaints)";
        $gallerycomplaints = $this->db->query($gallerycomplaints);

        if ($gallerycomplaints->result_array()) {
            $gallerycomplaintsarray = array();
            foreach ($gallerycomplaints->result_array() as $row) {
                $temp = array('idgallerycomplaints' => $row['idgallerycomplaints'], 'idcomplaints' => $row['idcomplaints'], 'avatar' => $row['avatar']); // access attribute
                array_push($gallerycomplaintsarray, $temp);
            }
            $detail['gallerycomplaints'] = $gallerycomplaintsarray;
        }

        return $detail;
    }

    ////////////////////////////////////////////////////////////////////////////
    public function insert_complaints($idaccount, $title, $description, $numberticket, $status, $avatar) {
        $this->db->set('idaccount', $idaccount);
        $this->db->set('title', $title);
        $this->db->set('description', $description);
        $this->db->set('numberticket', $numberticket);
        $this->db->set('status', $status);
        $this->db->set('avatar', $avatar);
        $this->db->set('createdate', date('Y-m-d H:i:s'));
        $this->db->insert('complaints');

        if ($this->db->affected_rows() > 0) {
            $avatar1 = explode(',', $avatar);
            $idcomplaints = $this->db->insert_id();
            foreach ($avatar1 as $file) {
                $file_data = array(
                    'idcomplaints' => $idcomplaints,
                    'avatar' => $file
                    );
                $this->db->insert('gallerycomplaints', $file_data);
            }

            return $this->db->affected_rows();
        } else {
            return 0;
        }
    }

    public function update_complaints($idcomplaints, $title, $description, $numberticket, $status) {
        $sql = "UPDATE complaints set title=?,  description=?, numberticket=?, status=?  WHERE idcomplaints=?";
        $query = $this->db->query($sql, array($title, $description, $numberticket, $status, $idcomplaints));
        return $this->db->affected_rows();
    }

    public function delete_complaints($idcomplaints) {
        $sql = "DELETE FROM complaints WHERE idcomplaints=?";
        $query = $this->db->query($sql, array($idcomplaints));
        if($this->db->affected_rows()>0) {
            $sql = "DELETE FROM gallerycomplaints WHERE idcomplaints=?";
            $query = $this->db->query($sql, array($idcomplaints));
            return $this->db->affected_rows();
        } else {
            return 0;
        }
    }

}
