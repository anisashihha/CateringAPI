
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
 * @author          Shaquille Akbar Demsi
 * @license         DBA
 * @link            zakiakbardemsi@gmail.com
 */

/**
 * Description of Newsgallery
 *
 * @author Shaquille Akbar Demsi
 * 21 March 2017
 */
class Newsgallery_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function listnewsgallery($idnews) {
        $query = $this->db->query("SELECT * FROM fn_get_listnewsgallery($idnews)");
        if (!empty($query)) {
            $newsgallery = array();
            foreach ($query->result_array() as $row) {
                $temp = array('idnewsgallery' => $row['idnewsgallery'], 'idnews' => $row['idnews'], 'avatar' => $row['avatar']);
                array_push($newsgallery, $temp);
            }
            return $newsgallery;
        } else {
            return null;
        }
    }
       
    public function insert_newsgallery($idnews, $avatar) {
        $this->db->set('idnews', $idnews);
        $this->db->set('avatar', $avatar);
        $this->db->insert('newsgallery');
        return $this->db->affected_rows();
    }
    
    public function update_newsgallery($idnewsgallery, $avatar) {
        $sql = "UPDATE newsgallery set avatar=? WHERE idnewsgallery=?";
        $query = $this->db->query($sql, array($avatar, $idnewsgallery));
        return $this->db->affected_rows();
    }

    public function delete_newsgallery($idnewsgallery) {
        $sql = "DELETE FROM newsgallery WHERE idnewsgallery=?";
        $query = $this->db->query($sql, array($idnewsgallery));
        return $this->db->affected_rows();
    }

}
