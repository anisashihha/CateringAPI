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
 * Description of menu_model
 *
 * @author Anisa' Shihhatin Sholihah 
 * 29 Juni 2016
 */
class menu_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

     public function menu_select($idtenant) {
        $sql = "SELECT idmenu, idtenant, menu, price, linkcatalog FROM menu WHERE idtenant = ?";
        $query = $this->db->query($sql, array($idtenant));
        $menu = array();
        foreach ($query->result_array() as $row) {
            $temp = array('idmenu' => $row['idmenu'], 'idtenant' => $row['idtenant'], 'menu' => $row['menu'], 'price' => $row['price'], 'linkcatalog' => $row['linkcatalog']); // access attributes
            array_push($menu, $temp);
        }
        return $menu;
    }
    
////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function insert_menu($idtenant, $menu, $price, $linkcatalog) {
        $this->db->set('idtenant', $idtenant);
        $this->db->set('menu', $menu);
        $this->db->set('price', $price);
        $this->db->set('linkcatalog', $linkcatalog);
        $this->db->insert('menu');
        return $this->db->affected_rows();
     }

    public function update_menu($idmenu, $menu, $price, $linkcatalog) {
        $sql = "UPDATE menu set menu=?, price=?, linkcatalog=? WHERE idmenu=?";
        $query = $this->db->query($sql, array($menu, $price, $linkcatalog, $idmenu));
        return $this->db->affected_rows();
    }

    public function delete_menu($idmenu) {
        $sql = "DELETE FROM menu WHERE idmenu=?";
        $query = $this->db->query($sql, array($idmenu));
        return $this->db->affected_rows();
    }

}
