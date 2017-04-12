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
 * Description of Talktous_model
 *
 * @author Anisa' Shihhatin Sholihah
 * 29 Juni 2016
 */
class Talktous_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    //////////////////////////////////////////////////////////////////////////////
    public function retrieve_get($idtalktous, $idcity) {
        $sql = "SELECT * FROM talktous WHERE idcity = ? AND idtalktous = ?";
        $query = $this->db->query($sql, array($idcity, $idtalktous));
        $get = array();
        foreach ($query->result_array() as $row) {
            $temp = array('idtalktous' => $row['idtalktous'], 'idcity' => $row['idcity'], 'header' => stripslashes($row['header']), 'description' => stripslashes($row['description']), 'heading1' => stripslashes($row['heading1']), 'content1' => stripslashes($row['content1']), 'heading2' => stripslashes($row['heading2']), 'content2' => stripslashes($row['content2']), 'content3' => stripslashes($row['content3']), 'content4' => stripslashes($row['content4']), 'emergencycall' => stripslashes($row['emergencycall']), 'content5' => stripslashes($row['content5']), 'callcenter' => stripslashes($row['callcenter']));
            array_push($get, $temp);
        }
        return $get;
    }

    //////////////////////////////////////////////////////////////////////////////
    public function update_talktous($idtalktous, $header, $description, $heading1, $content1, $heading2, $content2, $content3, $content4, $emergencycall, $content5, $callcenter, $idcity) {
        $sql = "UPDATE talktous SET header=?, description=?, heading1=?, content1=?, heading2=?, content2=?, content3=?, content4=?, emergencycall=?, content5=?, callcenter=? WHERE idtalktous=? AND idcity=?";

        $query = $this->db->query($sql, array($header, $description, $heading1, $content1, $heading2, $content2, $content3, $content4, $emergencycall, $content5, $callcenter, $idtalktous, $idcity));
        return $this->db->affected_rows();
    }

}
