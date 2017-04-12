
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
 * Description of Propertygallery_model
 *
 * @author Anisa' Shihhatin Sholihah 
 * 27 Juni 2016
 */
class Propertygallery_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function listpropertygallery($idproperty) {
        $query = $this->db->query("SELECT * FROM fn_get_listpropertygallery($idproperty)");
        if (!empty($query)) {
            $propertygallery = array();
            foreach ($query->result_array() as $row) {
                $temp = array('status' => true, 'idpropertygallery' => $row['idpropertygallery'], 'idproperty' => $row['idproperty'], 'title' => $row['title'], 'avatar' => $row['avatar']); // access attributes
                array_push($propertygallery, $temp);
            }
            return $propertygallery;
        } else {
            return null;
        }
    }
       
    public function insert_propertygallery($idproperty, $title, $avatar) {
        $this->db->set('idproperty', $idproperty);
        $this->db->set('title', $title);
        $this->db->set('avatar', $avatar);
        $this->db->insert('propertygallery');
        return $this->db->affected_rows();
    }
    
    public function update_propertygallery($idpropertygallery, $title, $avatar) {
        $sql = "UPDATE propertygallery set title=?, avatar=? WHERE idpropertygallery=?";
        $query = $this->db->query($sql, array($title, $avatar, $idpropertygallery));
        return $this->db->affected_rows();
    }

    public function delete_propertygallery($idpropertygallery) {
        $sql = "DELETE FROM propertygallery WHERE idpropertygallery=?";
        $query = $this->db->query($sql, array($idpropertygallery));
        return $this->db->affected_rows();
    }

}
