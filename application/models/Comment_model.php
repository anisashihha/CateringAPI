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
 * Description of Comment_model
 *
 * @author Anisa' Shihhatin Sholihah
 * 27 Juni 2016
 */
class Comment_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function retrieve_get($idcomment) {
        $query = "SELECT * FROM fn_get_comment  ($idcomment)";
        $query = $this->db->query($query);
        $retrieve_get = array();
        foreach ($query->result_array() as $row) {
            $temp = array('idcomment' => $row['idcomment'], 'idaccount' => $row['idaccount'], 'idforums' => $row['idforums'], 'comment' => stripslashes($row['comment']), 'createdate' => $row['createdate']); // access attribute
            array_push($retrieve_get, $temp);
        }
        return $retrieve_get;
    }

    ////////////////////////////////////////////////////////////////////////////
    public function insert_comment($idaccount, $idforums, $comment) {
        $this->db->set('idaccount', $idaccount);
        $this->db->set('idforums', $idforums);
        $this->db->set('comment', $comment);
        $this->db->set('createdate', date('Y-m-d H:i:s'));
        $this->db->insert('comment');
        return $this->db->affected_rows();
    }

    public function update_comment($idcomment, $comment) {
        $sql = "UPDATE comment set comment=? WHERE idcomment=?";
        $query = $this->db->query($sql, array($comment, $idcomment));
        return $this->db->affected_rows();
    }

    public function delete_comment($idcomment) {
        $sql = "DELETE FROM comment WHERE idcomment=?";
        $query = $this->db->query($sql, array($idcomment));
        return $this->db->affected_rows();
    }

}
