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
 * Description of Property_model
 *
 * @author Anisa' Shihhatin Sholihah
 * 05 Agustus 2016
 */
class Property_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function listbycategory($idcategory, $pagenumber, $pagesize, $status, $idaccount) {
        $offset = ($pagenumber * $pagesize) - $pagesize;
        $squery = "select * from fn_get_listpropertybycategory($idcategory, $offset, $pagesize, '%$status%');";
        $query = $this->db->query($squery);
        $listbycategory = array();
        foreach ($query->result_array() as $row) {
            //===== BOOKMARKED ====================================
            $bookmarked = null;
            $idbookmark = null;

            if($idaccount!=null) {
                $subquery = "SELECT * FROM bookmark WHERE idproperty=? AND idaccount=?";
                $subquery = $this->db->query($subquery, array($row['idproperty'], $idaccount));

                if($this->db->affected_rows()>0) {
                    foreach ($subquery->result_array() as $subrow) {
                        $idbookmark = $subrow['idbookmark'];
                    }
                    $bookmarked = true;
                } else {
                    $bookmarked = false;
                }
            }

            //===== COUNT HISTORY ====================================
            $subquery2 = "SELECT count(*) as historycount FROM history WHERE idproperty=?";
            $subquery2 = $this->db->query($subquery2, array($row['idproperty']));
            if($this->db->affected_rows()>0) {
                foreach ($subquery2->result_array() as $subrow2) {
                    $historycount = $subrow2['historycount'];
                }
            }

            //===== DATA INSERT ====================================
            $temp = array('idproperty' => $row['idproperty'], 'idcategory' => $row['idcategory'], 'categoryname' => $row['categoryname'], 'name' => stripslashes($row['name']), 'type' => $row['type'], 'price' => $row['price'], 'avatar' => $row['avatar'], 'lb' => $row['lb'], 'lt' => $row['lt'], 'status' => $row['status'], 'bookmarked' => $bookmarked, 'idbookmark' => $idbookmark, 'historycount' => $historycount); // access attributes
            array_push($listbycategory, $temp);
        }
        return $listbycategory;
    }

    public function listpropertybyname($idcategory, $pagenumber, $pagesize, $status, $keyword, $idaccount) {
        $offset = ($pagenumber * $pagesize) - $pagesize;
        $squery = "select * from fn_get_listproperty($idcategory, $offset, $pagesize, '%$status%', '" . strtolower($keyword) . "');";
        $query = $this->db->query($squery);
        $listpropertybyname = array();
        foreach ($query->result_array() as $row) {
            //===== BOOKMARKED ====================================
            $bookmarked = null;
            $idbookmark = null;

            if($idaccount!=null) {
                $subquery = "SELECT * FROM bookmark WHERE idproperty=? AND idaccount=?";
                $subquery = $this->db->query($subquery, array($row['idproperty'], $idaccount));

                if($this->db->affected_rows()>0) {
                    foreach ($subquery->result_array() as $subrow) {
                        $idbookmark = $subrow['idbookmark'];
                    }
                    $bookmarked = true;
                } else {
                    $bookmarked = false;
                }
            }

            //===== COUNT HISTORY ====================================
            $subquery2 = "SELECT count(*) as historycount FROM history WHERE idproperty=?";
            $subquery2 = $this->db->query($subquery2, array($row['idproperty']));
            if($this->db->affected_rows()>0) {
                foreach ($subquery2->result_array() as $subrow2) {
                    $historycount = $subrow2['historycount'];
                }
            }

            //===== DATA INSERT ====================================
            $temp = array('idproperty' => $row['idproperty'], 'idcategory' => $row['idcategory'], 'categoryname' => $row['categoryname'], 'name' => stripslashes($row['name']), 'type' => $row['type'], 'price' => $row['price'], 'avatar' => $row['avatar'], 'lb' => $row['lb'], 'lt' => $row['lt'], 'status' => $row['status'], 'bookmarked' => $bookmarked, 'idbookmark' => $idbookmark, 'historycount' => $historycount); // access attributes
            array_push($listpropertybyname, $temp);
        }
        return $listpropertybyname;
    }

    public function listbyagent($idagent, $pagenumber, $pagesize) {
        $offset = ($pagenumber * $pagesize) - $pagesize;
        $squery = "select * from fn_get_listpropertybyagent($idagent, $offset, $pagesize);";
        $query = $this->db->query($squery);
        $listbyagent = array();
        foreach ($query->result_array() as $row) {
            $temp = array('idproperty' => $row['idproperty'], 'idagent' => $row['idagent'], 'name' => stripslashes($row['name']), 'type' => $row['type'], 'price' => $row['price'], 'avatar' => $row['avatar'], 'lb' => $row['lb'], 'lt' => $row['lt'], 'status' => $row['status'], 'email' => $row['email'], 'phone' => $row['phone'] ); // access attributes
            array_push($listbyagent, $temp);
        }
        return $listbyagent;
    }

    public function retrieve_get($idproperty, $idaccount) {
        $query = "SELECT * FROM fn_get_detailproperty ('$idproperty')";
        $query = $this->db->query($query);
        $retrieve_get = array();
        foreach ($query->result_array() as $row) {
            $temp = array('idproperty' => $row['idproperty'], 'idcategory' => $row['idcategory'], 'categoryname' => $row['categoryname'], 'name' => stripslashes($row['name']), 'type' => $row['type'], 'price' => $row['price'], 'description' => $row['description'], 'lb' => $row['lb'], 'lt' => $row['lt'], 'avatar' => $row['avatar'], 'idagent' => $row['idagent'], 'status' => $row['status'], 'agentname' => stripslashes($row['agentname']), 'agentavatar' => $row['agentavatar'], 'agentphone' => $row['agentphone'], 'agentemail' => stripslashes($row['agentemail'])); // access attribute
            array_push($retrieve_get, $temp);
        }
        $detail['detail'] = $retrieve_get;

        $room = "SELECT * FROM fn_get_listroom_byproperty($idproperty) ";
        $room = $this->db->query($room);

        if ($room->result_array()) {
            $roomarray = array();
            foreach ($room->result_array() as $row) {
                $temp = array('idproperty' => $row['idproperty'], 'idroom' => $row['idroom'], 'name' => stripslashes($row['name']), 'jumlah' => $row['jumlah']); // access attribute
                array_push($roomarray, $temp);
            }
            $detail['room'] = $roomarray;
        }

        $gallery = "SELECT * FROM fn_get_listpropertygallery($idproperty)";
        $gallery = $this->db->query($gallery);

        if ($gallery->result_array()) {
            $galleryarray = array();
            foreach ($gallery->result_array() as $row) {
                $temp = array('idpropertygallery' => $row['idpropertygallery'], 'idproperty' => $row['idproperty'], 'image' => $row['avatar'], 'title' => stripslashes($row['title'])); // access attribute
                array_push($galleryarray, $temp);
            }
            $detail['gallery'] = $galleryarray;
        }

        if($idaccount!=null) {
            $squery = "SELECT * FROM property WHERE idproperty = ?";
            $query = $this->db->query($squery, array($idproperty));
            foreach ($query->result_array() as $row) {
                $this->db->set('idaccount', $idaccount);
                $this->db->set('activities', "Looking for-".addslashes($row['name']));
                $this->db->set('visitdate', date('Y-m-d H:i:s'));
                $this->db->set('idcategory', $row['idcategory']);
                $this->db->set('idproperty', $row['idproperty']);
                $this->db->insert('history');
            }
        }

        return $detail;
    }

    ////////////////////////////////////////////////////////////////////////////
    
    public function insert_property($idcategory, $name, $type, $price, $description, $lb, $lt, $avatar, $idagent, $status, $description_en) {
        $this->db->set('idcategory', $idcategory);
        $this->db->set('name', $name);
        $this->db->set('type', $type);
        $this->db->set('price', $price);
        $this->db->set('description', $description);
        $this->db->set('lb', $lb);
        $this->db->set('lt', $lt);
        $this->db->set('avatar', $avatar);
        $this->db->set('idagent', $idagent);
        $this->db->set('status', $status);
        $this->db->set('description_en', $description_en);
        $this->db->insert('property');
        return $this->db->affected_rows();
    }

    public function update_property($idproperty, $idcategory, $name, $type, $price, $description, $lb, $lt, $avatar, $idagent, $status, $description_en) {
        $sql = "UPDATE property set name=?, type=?, price=?, description=?, lb=?, lt=?, avatar=?, idagent=?, status=?, idcategory=?, description_en=? WHERE idproperty=?";
        $query = $this->db->query($sql, array($name, $type, $price, $description, $lb, $lt, $avatar, $idagent, $status, $idcategory, $description_en, $idproperty));
        return $this->db->affected_rows();
    }

//    public function update_property($idproperty, $idcategory, $name, $type, $price, $description, $lb, $lt, $avatar, $idagent, $status, $description_en) {
//         $sql = "UPDATE property set name='$name', type='$type', price='$price', description='$description', lb=$lb, lt=$lt, avatar='$avatar', idagent='$idagent', status='$status', idcategory='$idcategory' WHERE idproperty=$idproperty";
//         $query = $this->db->query($sql);

//         return $this->db->affected_rows();
//     }

    public function delete_property($idproperty) {
        $sql = "DELETE FROM property WHERE idproperty=?";
        $query = $this->db->query($sql, array($idproperty));
        return $this->db->affected_rows();
    }

}
