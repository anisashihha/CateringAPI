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
 * Description of Currency_model
 *
 * @author Anisa' Shihhatin Sholihah
 * 27 Juni 2016
 */
class Currency_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function listcountry($pagenumber, $pagesize) {
        $offset = ($pagenumber * $pagesize) - $pagesize;

        $query = $this->db->query("SELECT * FROM fn_get_listcountry($offset, $pagesize)");
        if (!empty($query)) {
            $listcountry = array();
            foreach ($query->result_array() as $row) {
                $temp = array('idcountry' => $row['idcountry'], 'country_code' => $row['country_code'], 'flag' => $row['flag']);
                array_push($listcountry, $temp);
            }
            return $listcountry;
        } else {
            return null;
        }
    }

    public function retrieve_get($idcurrency) {
        //$dayname = strtolower(date('l'));
        $query = "SELECT * FROM fn_get_detailcurrency ($idcurrency)";
        $query = $this->db->query($query);
        $retrieve_get = array();
        foreach ($query->result_array() as $row) {
            $temp = array('idcurrency' => $row['idcurrency'], 'flag' => $row['flag'], 'country' => $row['country'], 'code' => $row['code'], 'value' => $row['value']); // access attribute
            array_push($retrieve_get, $temp);
        }
        $detail['detail'] = $retrieve_get;
        return $detail;
    }

    ////////////////////////////////////////////////////////////////////////////

    public function insert_country($country_code, $flag) {
        $this->db->set('country_code', $country_code);
        $this->db->set('flag', $flag);
        $this->db->insert('currency_country');

        return $this->db->affected_rows();
    }

    public function update_country($idcountry, $country_code, $flag) {
        $sql = "UPDATE currency_country set country_code=?, flag=? WHERE idcountry=?";
        $query = $this->db->query($sql, array($country_code, $flag, $idcountry));

        return $this->db->affected_rows();
    }

    public function delete_country($idcountry) {
        $sql = "DELETE FROM currency_country WHERE idcountry=?";
        $query = $this->db->query($sql, array($idcountry));

        return $this->db->affected_rows();
    }

}
