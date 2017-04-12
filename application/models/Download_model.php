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
 * Description of Download_model
 *
 * @author Anisa' Shihhatin Sholihah
 * 01 Agustus 2016
 */
class Download_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function listdownload($idcategory, $pagenumber, $pagesize) {
        $offset = ($pagenumber * $pagesize) - $pagesize;
        if(is_numeric($idcategory)) {
            $query = $this->db->query("SELECT * FROM fn_get_listdownload($idcategory, $offset, $pagesize)");
        } else {
            $query = $this->db->query("SELECT * FROM fn_get_listdownload($offset, $pagesize)");
        }

        if (!empty($query)) {
            $listdownload = array();
            foreach ($query->result_array() as $row) {
                $temp = array('status' => true, 'iddownload' => $row['iddownload'], 'idcategory' => $row['idcategory'], 'categoryname' => $row['categoryname'], 'title' => stripslashes($row['title']), 'avatar' => $row['avatar'], 'linkfile' => $row['linkfile'], 'filename' => $row['filename'], 'filesize' => $row['filesize']); // access attributes
                array_push($listdownload, $temp);
            }
            return $listdownload;
        } else {
            return null;
        }
    }

    //tambahan 21-09-2016

    public function listdownloadbytenant($idtenant, $pagenumber, $pagesize) {
        $offset = ($pagenumber * $pagesize) - $pagesize;
        $query = $this->db->query("SELECT * FROM fn_get_listdownloadbytenant($idtenant, $offset, $pagesize)");
        if (!empty($query)) {
            $listdownloadbytenant = array();
            foreach ($query->result_array() as $row) {
                $temp = array('status' => true, 'iddownload' => $row['iddownload'], 'idcategory' => $row['idcategory'], 'categoryname' => $row['categoryname'], 'title' => stripslashes($row['title']), 'avatar' => $row['avatar'], 'linkfile' => $row['linkfile'], 'filename' => $row['filename'], 'filesize' => $row['filesize']); // access attributes
                array_push($listdownloadbytenant, $temp);
            }
            return $listdownloadbytenant;
        } else {
            return null;
        }
    }

    public function listdownloadfilterbyname($idcategory, $pagenumber, $pagesize, $keyword) {
        $offset = ($pagenumber * $pagesize) - $pagesize;
        if(is_numeric($idcategory)) {
            $query = $this->db->query("SELECT * FROM fn_get_listdownload($idcategory, $offset, $pagesize, '" . strtolower($keyword) . "')");
        } else {
            $query = $this->db->query("SELECT * FROM fn_get_listdownload($offset, $pagesize, '" . strtolower($keyword) . "')");
        }

        if (!empty($query)) {
            $listdownloadfilterbyname = array();
            foreach ($query->result_array() as $row) {
                $temp = array('status' => true, 'iddownload' => $row['iddownload'], 'idcategory' => $row['idcategory'], 'categoryname' => $row['categoryname'], 'title' => stripslashes($row['title']), 'avatar' => $row['avatar'], 'linkfile' => $row['linkfile'], 'filename' => $row['filename'], 'filesize' => $row['filesize']); // access attributes
                array_push($listdownloadfilterbyname, $temp);
            }
            return $listdownloadfilterbyname;
        } else {
            return null;
        }
    }

    public function retrieve_get($iddownload) {
        //$dayname = strtolower(date('l'));
        $query = "SELECT * FROM fn_get_detaildownload ($iddownload)";
        $query = $this->db->query($query);
        $retrieve_get = array();
        foreach ($query->result_array() as $row) {
            $temp = array('iddownload' => $row['iddownload'], 'title' => stripslashes($row['title']), 'avatar' => $row['avatar'], 'linkfile' => $row['linkfile']); // access attribute
            array_push($retrieve_get, $temp);
        }
        $detail['detail'] = $retrieve_get;
        return $detail;
    }

    ////////////////////////////////////////////////////////////////////////////
    public function insert_download($idcategory, $title, $avatar, $linkfile, $filename, $filesize) {
        if($idcategory!=null) $this->db->set('idcategory', $idcategory);
        $this->db->set('title', $title);
        $this->db->set('avatar', $avatar);
        $this->db->set('linkfile', $linkfile);
        $this->db->set('filename', $filename);
        $this->db->set('filesize', $filesize);
        $this->db->insert('download');
        return $this->db->affected_rows();
    }

    public function update_download($iddownload, $idcategory, $title, $avatar, $linkfile, $filename, $filesize) {
        $sql = "UPDATE download set idcategory=?, title=?, avatar=?, linkfile=?, filename=?, filesize=? WHERE iddownload=?";
        $query = $this->db->query($sql, array($idcategory, $title, $avatar, $linkfile, $filename, $filesize, $iddownload));
        return $this->db->affected_rows();
    }

    public function delete_download($iddownload) {
        $sql = "DELETE FROM download WHERE iddownload=?";
        $query = $this->db->query($sql, array($iddownload));
        return $this->db->affected_rows();
    }

}
