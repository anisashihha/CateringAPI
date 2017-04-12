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
 * Description of Discountcoupon_model
 *
 * @author Anisa' Shihhatin Sholihah 
 * 22 November 2016
 */
class Discountcoupon_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
////////////////////////////////////////////////////////////////////////////////////////////////////////
   public function discountlist($pagenumber, $pagesize) {
        $offset = ($pagenumber * $pagesize) - $pagesize;
        $squery = "SELECT * FROM fn_get_discountlist($offset, $pagesize)";
        $query = $this->db->query($squery);
        $discountlist = array();
        foreach ($query->result_array() as $row) {
            $temp = array('iddiscountcoupon' => $row['iddiscountcoupon'], 'idtenant' => $row['idtenant'], 'idcategory' => $row['idcategory'], 'imageurl' => $row['imageurl'], 'title' => $row['title'], 'caption' => $row['caption'], 'fileurl' => $row['fileurl'], 'filename' => $row['filename'], 'filesize' => $row['filesize'], 'logo' => $row['logo'], 'color' => $row['color']); // access attribute
            array_push($discountlist, $temp);
        }

        return $discountlist;
    }
    
    public function retrieve_get($idtenant, $pagenumber, $pagesize) {
        $offset = ($pagenumber * $pagesize) - $pagesize;
        $squery = "SELECT * FROM fn_get_discountcoupon($idtenant, $offset, $pagesize)";
        $query = $this->db->query($squery);
        $retrieve_get = array();
        foreach ($query->result_array() as $row) {
            $temp = array('iddiscountcoupon' => $row['iddiscountcoupon'], 'idtenant' => $row['idtenant'], 'imageurl' => $row['imageurl'], 'title' => $row['title'], 'caption' => $row['caption'], 'fileurl' => $row['fileurl'], 'filename' => $row['filename'], 'filesize' => $row['filesize'], 'logo' => $row['logo'], 'color' => $row['color']); // access attribute
            array_push($retrieve_get, $temp);
        }

        return $retrieve_get;
    }

    public function listdiscountcouponbycategory($idcategory, $pagenumber, $pagesize) {
        $offset = ($pagenumber * $pagesize) - $pagesize;
        $query = "SELECT * FROM fn_get_listdiscountbycategory($idcategory, $offset, $pagesize)";
        $query = $this->db->query($query);
        $listdiscountcouponbycategory = array();
        foreach ($query->result_array() as $row) {
            $temp = array('iddiscountcoupon' => $row['iddiscountcoupon'], 'idtenant' => $row['idtenant'], 'idcategory' => $row['idcategory'], 'imageurl' => $row['imageurl'], 'title' => $row['title'], 'caption' => $row['caption'], 'fileurl' => $row['fileurl'], 'filename' => $row['filename'], 'filesize' => $row['filesize'], 'logo' => $row['logo'], 'color' => $row['color']); // access attribute
            array_push($listdiscountcouponbycategory, $temp);
        }

        return $listdiscountcouponbycategory;
    }


    // public function listdiscountcoupon($idtenant, $pagenumber, $pagesize) {
    //     $offset = ($pagenumber * $pagesize) - $pagesize;
    //     $query = "SELECT * FROM fn_get_listdiscount($idtenant, $offset, $pagesize)";
    //     $query = $this->db->query($query);
    //     $listdiscountcoupon = array();
    //     foreach ($query->result_array() as $row) {
    //         $temp = array('iddiscountcoupon' => $row['iddiscountcoupon'], 'idtenant' => $row['idtenant'], 'idcategory' => $row['idcategory'], 'imageurl' => $row['imageurl'], 'title' => $row['title'], 'caption' => $row['caption'], 'fileurl' => $row['fileurl'], 'filename' => $row['filename'], 'filesize' => $row['filesize'], 'logo' => $row['logo'], 'color' => $row['color']); // access attribute
    //         array_push($listdiscountcoupon, $temp);
    //     }

    //     return $listdiscountcoupon;
    // }

    public function listdiscountcouponfilterbyname($pagenumber, $pagesize, $keyword) {
        $offset = ($pagenumber * $pagesize) - $pagesize;
        $query = "SELECT * FROM fn_get_listdiscount($offset, $pagesize, '" . strtolower($keyword). "')";
        $query = $this->db->query($query);
        $listdiscountcouponfilterbyname = array();
        foreach ($query->result_array() as $row) {
            $temp = array('iddiscountcoupon' => $row['iddiscountcoupon'], 'idtenant' => $row['idtenant'], 'idcategory' => $row['idcategory'], 'imageurl' => $row['imageurl'], 'title' => $row['title'], 'caption' => $row['caption'], 'fileurl' => $row['fileurl'], 'filename' => $row['filename'], 'filesize' => $row['filesize'], 'logo' => $row['logo'], 'color' => $row['color']); // access attribute
            array_push($listdiscountcouponfilterbyname, $temp);
        }

        return $listdiscountcouponfilterbyname;
    }
    
    public function listdiscountcouponbytenant($idtenant) {
        $squery = "SELECT * FROM fn_get_listdiscountbytenant($idtenant)";
        $query = $this->db->query($squery);
        $listdiscountcouponfilterbyname = array();
        foreach ($query->result_array() as $row) {
            $temp = array('iddiscountcoupon' => $row['iddiscountcoupon'], 'idtenant' => $row['idtenant'], 'idcategory' => $row['idcategory'], 'imageurl' => $row['imageurl'], 'title' => $row['title'], 'caption' => $row['caption'], 'fileurl' => $row['fileurl'], 'filename' => $row['filename'], 'filesize' => $row['filesize'], 'logo' => $row['logo'], 'color' => $row['color']); // access attribute
            array_push($listdiscountcouponfilterbyname, $temp);
        }

        return $listdiscountcouponfilterbyname;
    }

////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function insert_discountcoupon($idtenant, $imageurl, $title, $caption, $fileurl, $filename, $filesize, $idcategory) {
         $this->db->set('idtenant', $idtenant);
        $this->db->set('imageurl', $imageurl);
        $this->db->set('title', $title);
        $this->db->set('caption', $caption);
        $this->db->set('fileurl', $fileurl);
        $this->db->set('filename', $filename);
        $this->db->set('filesize', $filesize);
        $this->db->set('idcategory', $idcategory);
        $this->db->insert('discountcoupon');
        return $this->db->affected_rows();
    }
   
    public function update_discountcoupon($iddiscountcoupon, $idtenant, $imageurl, $title, $caption, $fileurl, $filename, $filesize, $idcategory) {
        $sql = "UPDATE discountcoupon set idtenant=?, imageurl=?, title=?, caption=?, fileurl=?, filename=?, filesize=?, idcategory=?  WHERE iddiscountcoupon=?";
        $query = $this->db->query($sql, array($idtenant, $imageurl, $title, $caption, $fileurl, $filename, $filesize, $idcategory, $iddiscountcoupon));
        return $this->db->affected_rows();
    }
    public function delete_discountcoupon($iddiscountcoupon) {
        $sql = "DELETE FROM discountcoupon WHERE iddiscountcoupon=?";
        $query = $this->db->query($sql, array($iddiscountcoupon));
        return $this->db->affected_rows();
    }
    

}
