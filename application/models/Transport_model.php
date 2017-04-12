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
 * Description of Transport_model
 *
 * @author Anisa' Shihhatin Sholihah 
 * 27 Juni 2016
 */
class transport_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function listbytransportcategory($idtransportcategory, $pagenumber, $pagesize) {
        $offset = ($pagenumber * $pagesize) - $pagesize;
        $squery = "select * from fn_get_listtenants($idtransportcategory, $offset, $pagesize);";
        $query = $this->db->query($squery);
        $listbytransportcategory = array();
        foreach ($query->result_array() as $row) {
            $temp = array('idtransportcategory' => $row['idtransportcategory'], 'categoryname' => $row['categoryname'], 'level' => $row['level'], 'idtransport' => $row['idtransport'], 'avatar' => $row['avatar'], 'tenantsname' => $row['tenantsname'], 'address' => $row['address'], 'longlat' => $row['longlat'], 'premium' => $row['premium'], 'phone' => $row['phone'], 'rate' => $row['rate'], 'openstatus' => $row['openstatus'], 'openhour' => $row['openhour'], 'closehour' => $row['closehour']); // access attributes
            array_push($listbytransportcategory, $temp);
        }
        return $listbytransportcategory;
    }

    public function listtransportcategoryfilterbyname($idtransportcategory, $pagenumber, $pagesize, $tenantname) {
        $offset = ($pagenumber * $pagesize) - $pagesize;
        $query = "select * from fn_get_listtenants($idtransportcategory, $offset, $pagesize , '" . strtolower($tenantname) . "')";
        $query = $this->db->query($query);
        $listtransportcategoryfilterbyname = array();
        foreach ($query->result_array() as $row) {
            $temp = array('idtransportcategory' => $row['idtransportcategory'], 'categoryname' => $row['categoryname'], 'level' => $row['level'], 'idtransport' => $row['idtransport'], 'avatar' => $row['avatar'], 'tenantsname' => $row['tenantsname'], 'address' => $row['address'], 'longlat' => $row['longlat'], 'premium' => $row['premium'], 'phone' => $row['phone'], 'rate' => $row['rate'], 'openstatus' => $row['openstatus'], 'openhour' => $row['openhour'], 'closehour' => $row['closehour']); // access attributes
            array_push($listtransportcategoryfilterbyname, $temp);
        }
        return $listtransportcategoryfilterbyname;
    }
    
    public function retrieve_get($idtransport) {
       $query = "SELECT * FROM fn_get_detailtenants ($idtransport)";
        $query = $this->db->query($query);
        $retrieve_get = array();
        foreach ($query->result_array() as $row) {
            $temp = array('idtransportcategory' => $row['idtransportcategory'], 'rating' => $row['rating'], 'avatar' => $row['avatar'], 'name' => $row['name'], 'address' => $row['address'], 'phone' => $row['phone'], 'longlat' => $row['longlat'], 'premium' => $row['premium'], 'open' => $row['openstatusid'], 'openstatus' => $row['openstatus'], 'openhour' => $row['openhour'], 'closehour' => $row['closehour'], 'longlat' => $row['longlat'], 'idtransport' => $row['idtransport']); // access attribute
            array_push($retrieve_get, $temp);
        }
        $detail['detail'] = $retrieve_get;
        
        $menu = "SELECT * FROM fn_get_listmenu_bytenants($idtransport) ";
        $menu = $this->db->query($menu);

        if ($menu->result_array()) {
            $menuarray = array();
            foreach ($menu->result_array() as $row) {
                $temp = array('idmenu' => $row['idmenu'], 'idtransport' => $row['idtransport'], 'menu' => $row['menu'], 'price' => $row['price'], 'linkcatalog' => $row['linkcatalog']); // access attribute
                array_push($menuarray, $temp);
            }
            $detail['menu'] = $menuarray;
        }
        
        $promotion = "SELECT * FROM fn_get_listpromo_bytenants($idtransport) ";
        $promotion = $this->db->query($promotion);
        if ($promotion->result_array()) {
            $promotionarray = array();
            foreach ($promotion->result_array() as $row) {
                $temp = array('idmenu' => $row['idmenu'], 'idtransport' => $row['idtransport'], 'menu' => $row['menu'], 'price' => $row['price'], 'linkcatalog' => $row['linkcatalog']); // access attribute
                array_push($promotionarray, $temp);
            }
            $detail['promotion'] = $promotionarray;
        }

        $openh = "SELECT * FROM fn_get_listopenhour_bytenants($idtransport) ";
        $openh = $this->db->query($openh);
        if ($openh->result_array()) {
            $openharray = array();
            foreach ($openh->result_array() as $row) {
                $temp = array('idopenhour' => $row['idopenhour'], 'idtransport' => $row['idtransport'], 'dayname' => $row['dayname'], 'openhour' => $row['openhour'], 'closehour' => $row['closehour'],  'open' => $row['open']); // access attribute
                array_push($openharray, $temp);
            }
            $detail['openhour'] = $openharray;
        }
//Tambahan untuk detail avatar
        $avatar = "select * from avatar where idtransport = ? ";
        $avatar = $this->db->query($avatar, array($idtransport));
        if ($avatar->result_array()) {
            $avatararray = array();
            foreach ($avatar->result_array() as $row) {
                $temp = array('idavatar' => $row['idavatar'], 'idtransport' => $row['idtransport'], 'linkavatar' => $row['linkavatar']); // access attribute
                array_push($avatararray, $temp);
            }
            $detail['avatar'] = $avatararray;
        }

        $gallery = "SELECT * FROM fn_get_listgallery_bytenants($idtransport) ";
        $gallery = $this->db->query($gallery);

        if ($gallery->result_array()) {
            $galleryarray = array();
            foreach ($gallery->result_array() as $row) {
                $temp = array('idgallery' => $row['idgallery'], 'idtransport' => $row['idtransport'], 'imageurl' => $row['imageurl'], 'title' => $row['title'], 'caption' => $row['caption']); // access attribute
                array_push($galleryarray, $temp);
            }
            $detail['gallery'] = $galleryarray;
        }
                
        return $detail;
        
        
        $discountcoupon = "SELECT * FROM discountcoupon ";
        $discountcoupon = $this->db->query($discountcoupon);

        if ($discountcoupon->result_array()) {
            $discountcouponarray = array();
            foreach ($discountcoupon->result_array() as $row) {
                $temp = array('iddiscountcoupon' => $row['iddiscountcoupon'], 'idtransport' => $row['idtransport'], 'imageurl' => $row['imageurl'], 'title' => $row['title'], 'caption' => $row['caption']); // access attribute
                array_push($discountcouponarray, $temp);
            }
            $detail['discountcoupon'] = $discountcouponarray;
        }
                
        return $detail;
    }

////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function insert_tenant($idtransportcategory, $name, $avatar, $address, $longlat, $premium, $phone) {
        $this->db->set('idtransportcategory', $idtransportcategory);
        $this->db->set('name', $name);
        $this->db->set('avatar', $avatar);
        $this->db->set('address', $address);
        $this->db->set('longlat', $longlat);
        $this->db->set('premium', $premium);
        $this->db->set('phone', $phone);
        $this->db->insert('tenants');
        return $this->db->affected_rows();
      }

    public function update_tenant($idtransport, $idtransportcategory, $name, $avatar, $address, $longlat, $premium, $phone) {
        $query = "UPDATE tenants set name='$name', avatar='$avatar', address='$address', longlat='$longlat', premium='$premium', phone='$phone',idtransportcategory='$idtransportcategory' WHERE idtransport='$idtransport'";
        $this->db->query($query);
        return $this->db->affected_rows();
    }

    public function delete_tenant($idtransport) {
        $sql = "DELETE FROM tenants WHERE idtransport=?";
        $query = $this->db->query($sql, array($idtransport));;
        return $this->db->affected_rows();
    }

}
