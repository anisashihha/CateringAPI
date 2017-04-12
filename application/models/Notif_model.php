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
class Notif_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function listnotif($idaccount, $pagenumber, $pagesize, $lang) {
        $offset = ($pagenumber * $pagesize) - $pagesize;
        if($lang=="en") { $query = $this->db->query("SELECT * FROM fn_get_listnotif_en($idaccount, $offset, $pagesize)"); }
        else { $query = $this->db->query("SELECT * FROM fn_get_listnotif($idaccount, $offset, $pagesize)"); }
        if ($query) {
            $listnotif = array();
            foreach ($query->result_array() as $row) {
                $bookmarked = null;
                $idnotifbookmark = null;

                $subquery = "SELECT * FROM notifbookmark WHERE idnotif=? AND idaccount=?";
                $subquery = $this->db->query($subquery, array($row['idnotif'], $row['idaccount']));
                if($this->db->affected_rows()>0) {
                    foreach ($subquery->result_array() as $subrow) {
                        $idnotifbookmark = $subrow['idnotifbookmark'];
                    }
                    $bookmarked = true;
                } else {
                    $bookmarked = false;
                }

                $temp = array('idnotif' => $row['idnotif'], 'idaccount' => $row['idaccount'], 'idtenant' => $row['idtenant'], 'title' => $row['title'], 'description' => $row['description'], 'isread' => $row['isread'], 'bookmarked' => $bookmarked, 'idnotifbookmark' => $idnotifbookmark, 'createdate' => $row['createdate']);
                array_push($listnotif, $temp);
            }
            return $listnotif;
        } else {
            return null;
        }
    }

    public function listnotiffilterbyname($idaccount, $pagenumber, $pagesize, $keyword, $lang) {
        $offset = ($pagenumber * $pagesize) - $pagesize;
        if($lang=="en") { $query = $this->db->query("SELECT * FROM fn_get_listnotif_en($idaccount, $offset, $pagesize, '".strtolower($keyword)."')"); }
        else { $query = $this->db->query("SELECT * FROM fn_get_listnotif($idaccount, $offset, $pagesize, '".strtolower($keyword)."')"); }
        if ($query) {
            $listnotif = array();
            foreach ($query->result_array() as $row) {
                $bookmarked = null;
                $idnotifbookmark = null;

                $subquery = "SELECT * FROM notifbookmark WHERE idnotif=? AND idaccount=?";
                $subquery = $this->db->query($subquery, array($row['idnotif'], $row['idaccount']));
                if($this->db->affected_rows()>0) {
                    foreach ($subquery->result_array() as $subrow) {
                        $idnotifbookmark = $subrow['idnotifbookmark'];
                    }
                    $bookmarked = true;
                } else {
                    $bookmarked = false;
                }

                $subquery = "SELECT * FROM notifbookmark WHERE idnotif=? AND idaccount=?";
                $subquery = $this->db->query($subquery, array($row['idnotif'], $row['idaccount']));
                if($this->db->affected_rows()>0) $bookmarked = true;
                else $bookmarked = false;

                $temp = array('idnotif' => $row['idnotif'], 'idaccount' => $row['idaccount'], 'idtenant' => $row['idtenant'], 'title' => $row['title'], 'description' => $row['description'], 'isread' => $row['isread'], 'bookmarked' => $bookmarked, 'idnotifbookmark' => $idnotifbookmark, 'createdate' => $row['createdate']);
                array_push($listnotif, $temp);
            }
            return $listnotif;
        } else {
            return null;
        }
    }

    public function listnotifbytenant($pagenumber, $pagesize, $lang) {
        $offset = ($pagenumber * $pagesize) - $pagesize;
        if($lang=="en") { $query = $this->db->query("SELECT * FROM fn_get_listnotif_en($offset, $pagesize)"); }
        else { $query = $this->db->query("SELECT * FROM fn_get_listnotif($offset, $pagesize)"); }
        if ($query) {
            $listnotifbytenant = array();
            foreach ($query->result_array() as $row) {
                $temp = array('idnotif' => $row['idnotif'], 'title' => $row['title'], 'description' => $row['description'], 'idtenant' => $row['idtenant'], 'createdate' => $row['createdate']); // access attributes
                array_push($listnotifbytenant, $temp);
            }
            return $listnotifbytenant;
        } else {
            return null;
        }
    }

    //tambahan per 22-09-2016 (Thursday)
    public function listnotifbycity($idcity, $pagenumber, $pagesize, $lang) {
        $offset = ($pagenumber * $pagesize) - $pagesize;
        if($lang=="en") { $query = $this->db->query("SELECT * FROM fn_get_listnotifbycity_en($idcity, $offset, $pagesize)"); }
        else { $query = $this->db->query("SELECT * FROM fn_get_listnotifbycity($idcity, $offset, $pagesize)"); }
        if ($query) {
            $listnotifbycity = array();
            foreach ($query->result_array() as $row) {
                $temp = array('idnotif' => $row['idnotif'], 'title' => $row['title'], 'description' => $row['description'], 'image' => $row['image'], 'idcity' => $row['idcity'], 'createdate' => $row['createdate']); // access attributes
                array_push($listnotifbycity, $temp);
            }
            return $listnotifbycity;
        } else {
            return null;
        }
    }

    public function listnotifbycategory($idcategory, $lang) {
        if($lang=="en") { $query = $this->db->query("select * from fn_get_listnotif_en($idcategory)"); }
        else { $query = $this->db->query("select * from fn_get_listnotif($idcategory)"); }
        $listnotifbycategory = array();
        foreach ($query->result_array() as $row) {
            $temp = array('idnotif' => $row['idnotif'], 'idtenant' => $row['idtenant'], 'title' => $row['title'], 'tenantname' => $row['tenantname'], 'description' => $row['description'], 'image' => $row['image'], 'createdate' => $row['createdate']); // access attributes
            array_push($listnotifbycategory, $temp);
        }
        return $listnotifbycategory;
    }

    public function retrieve_get($idnotif, $idaccount, $lang) {
        $retrieve_get = array();
        if($lang=="en") { 
            $query = $this->db->query("SELECT * FROM fn_get_notif_en($idnotif)");
            foreach ($query->result_array() as $row) {
                $temp = array('idnotif' => $row['idnotif'], 'title' => $row['title'], 'description' => $row['description'], 'idtenant' => $row['idtenant'], 'createdate' => $row['createdate'], 'image' => $row['image']); // access attribute
                array_push($retrieve_get, $temp);
            }
        }
        else { 
            $query = $this->db->query("SELECT * FROM fn_get_notif($idnotif)"); 
            foreach ($query->result_array() as $row) {
                $temp = array('idnotif' => $row['idnotif'], 'title' => $row['title'], 'description' => $row['description'], 'title_en' => $row['title_en'], 'description_en' => $row['description_en'], 'idtenant' => $row['idtenant'], 'createdate' => $row['createdate'], 'image' => $row['image']); // access attribute
                array_push($retrieve_get, $temp);
            }
        }
        
        $detail['notif'] = $retrieve_get;

        if(isset($idaccount) AND $idaccount!='') {
            $query = "UPDATE read_notif set isread=? WHERE idnotif=? AND idaccount=?";
            $this->db->query($query, array(true, $idnotif, $idaccount));
        } else {
            $query = "SELECT read_notif.*, profile.fullname FROM read_notif INNER JOIN profile ON profile.idaccount = read_notif.idaccount WHERE idnotif=?";
            $query = $this->db->query($query, array($idnotif));
            $retrieve_get = array();
            foreach ($query->result_array() as $row) {
                $temp = array('idread' => $row['idread'], 'idaccount' => $row['idaccount'], 'name' => $row['fullname'], 'isread' => $row['isread']);
                array_push($retrieve_get, $temp);
            }
            $detail['account'] = $retrieve_get;
        }

        return $detail;
    }

    public function count_notif($idaccount) {
        $sql = "SELECT COUNT(*) as total_notif FROM read_notif WHERE idaccount = ? AND status=?";
        $query = $this->db->query($sql, array($idaccount, true));
        $count = array();
        foreach ($query->result_array() as $row) {
            array_push($count, array('total' => $row['total_notif']));
        }

        return $count;
    }

    ////////////////////////////////////////////////////////////////////////////

    public function insert_notif($title, $description, $title_en, $description_en, $idtenant, $idcity, $image, $idaccount) {
        $this->db->set('title', $title);
        $this->db->set('description', $description);
        $this->db->set('title_en', $title_en);
        $this->db->set('description_en', $description_en);
        if($idtenant!=null) $this->db->set('idtenant', $idtenant);
        else if($idcity!=null) $this->db->set('idcity', $idcity);
        $this->db->set('image', $image);
        $this->db->set('createdate', date('Y-m-d H:i:s'));
        $this->db->insert('notif');

        if($this->db->affected_rows()>0) {
            $idnotif = $this->db->insert_id();
            $idaccount_arr = explode(',', $idaccount);

            foreach ($idaccount_arr as $id) {
                $isread_data = array(
                    'idnotif' => $idnotif,
                    'idaccount' => $id,
                    'isread' => false
                    );
                $this->db->insert('read_notif', $isread_data);
            }

            return $this->db->affected_rows();
        } else {
            return 0;
        }
    }

    public function mark_read($idnotif, $idaccount) {
        $idnotif1 = explode(',', $idnotif);
        foreach ($idnotif1 as $id) {
            $sql = "UPDATE read_notif set isread=? WHERE idnotif=? AND idaccount=?";
            $query = $this->db->query($sql, array(true, $id, $idaccount));
        }

        return $this->db->affected_rows();
    }

    public function insert_isread($idnotif, $idaccount) {
        $idaccount_arr = explode(',', $idaccount);

        foreach ($idaccount_arr as $id) {
            $isread_data = array(
                'idnotif' => $idnotif,
                'idaccount' => $id,
                'isread' => false
                );
            $this->db->insert('read_notif', $isread_data);
        }

        return $this->db->affected_rows();
    }

    public function update_notif($idnotif, $title, $description, $title_en, $description_en, $idtenant, $idcity, $image) {
        $sql = "UPDATE notif set title='$title', description='$description', title_en='$title_en', description_en='$description_en', idtenant=$idtenant, idcity=$idcity, image='$image' WHERE idnotif=$idnotif";
        $query = $this->db->query($sql);

        return $this->db->affected_rows();
    }

    public function delete_notif($idnotif) {
        $sql = "DELETE FROM notif WHERE idnotif=?";
        $query = $this->db->query($sql, array($idnotif));

        return $this->db->affected_rows();
    }

    public function delete_account_notif($idnotif, $idaccount) {
        $idnotif1 = explode(',', $idnotif);
        foreach ($idnotif1 as $id) {
            $sql = "UPDATE read_notif set status=? WHERE idnotif=? AND idaccount=?";
            $query = $this->db->query($sql, array(false, $id, $idaccount));
        }

        return $this->db->affected_rows();
    }

    public function delete_isread($idread) {
        $sql = "DELETE FROM read_notif WHERE idread=?";
        $query = $this->db->query($sql, array($idread));

        return $this->db->affected_rows();
    }

}
