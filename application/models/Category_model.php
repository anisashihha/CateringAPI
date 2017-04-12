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
 * Description of Category_model
 *
 * @author Anisa' Shihhatin Sholihah 
 * 27 Juni 2016
 */
class Category_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function listallchild($idcategory) {

        $squery = "select * from fn_get_listcategory_allchild($idcategory);";
        $query = $this->db->query($squery);
        $listallchild = array();
        foreach ($query->result_array() as $row) {
            $temp = array('parentid' => $row['parentid'], 'parentname' => $row['parentname'], 'idcategory' => $row['idcategory'], 'categoryname' => $row['categoryname'], 'level' => $row['level']); // access attributes
            array_push($listallchild, $temp);
        }
        return $listallchild;
    }

    public function listchild($idcategory) {

        $squery = "select * from fn_get_listcategory_child($idcategory)";
        $query = $this->db->query($squery);
        $listchild = array();
        foreach ($query->result_array() as $row) {
            $temp = array('parentid' => $row['parentid'], 'parentame' => $row['parentame'], 'idcategory' => $row['idcategory'], 'categoryname' => $row['categoryname'], 'level' => $row['level']); // access attributes
            array_push($listchild, $temp);
        }
        return $listchild;
    }

}
