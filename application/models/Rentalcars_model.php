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
 * Description of Rentalcars_model
 *
 * @author Anisa' Shihhatin Sholihah 
 * 27 Juni 2016
 */
class Rentalcars_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function listrentalcars($pagenumber, $pagesize) {
        $offset = ($pagenumber * $pagesize) - $pagesize;
        $query = $this->db->query("SELECT * FROM fn_get_listrentalcars($offset, $pagesize)");
        if (!empty($query)) {
            $Rentalcars = array();
            foreach ($query->result_array() as $row) {
                $temp = array('status' => true, 'idrentalcars' => $row['idrentalcars'], 'name' => $row['name'], 'avatar' => $row['avatar'], 'latitude' => $row['latitude'], 'longitude' => $row['longitude']); // access attributes
                array_push($Rentalcars, $temp);
            }
            return $Rentalcars;
        } else {
            return null;
        }
    }
        public function retrieve_get($idrentalcars) {
        $query = "SELECT * FROM fn_get_detailrentalcars ($idrentalcars)";
        $query = $this->db->query($query);
        $retrieve_get = array();
        foreach ($query->result_array() as $row) {
             $temp = array('idrentalcars' => $row['idrentalcars'], 'name' => $row['name'], 'address' => $row['address'], 'avatar' => $row['avatar'], 'latitude' => $row['latitude'], 'longitude' => $row['longitude']); // access attribute
             array_push($retrieve_get, $temp);
        }
        $detail['detail'] = $retrieve_get;
        return $detail;
    }

    
    public function insert_rentalcars($name, $address, $avatar, $longitude, $latitude) {
        $this->db->set('name', $name);
        $this->db->set('address', $address);
        $this->db->set('avatar', $avatar);
        $this->db->set('longitude', $longitude);
        $this->db->set('latitude', $latitude);
        $this->db->insert('rentalcars');
        return $this->db->affected_rows();
    }
    
    public function update_rentalcars($idrentalcars, $name, $address, $avatar, $longitude, $latitude) {
        $sql = "UPDATE rentalcars set name=?, address=?, avatar=?, longitude=?, latitude=? WHERE idrentalcars=?";
        $query = $this->db->query($sql, array($name, $address, $avatar, $longitude, $latitude, $idrentalcars));
        return $this->db->affected_rows();

    }

    public function delete_rentalcars($idrentalcars) {
        $sql = "DELETE FROM rentalcars WHERE idrentalcars=?";
        $query = $this->db->query($sql, array($idrentalcars));
        return $this->db->affected_rows(); 
    }

}