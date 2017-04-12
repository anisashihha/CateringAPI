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
 * Description of Tenant_model
 *
 * @author Anisa' Shihhatin Sholihah
 * 27 Juni 2016
 */
class Tenant_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function listbycategory($idcategory, $pagenumber, $pagesize) {
        $offset = ($pagenumber * $pagesize) - $pagesize;
        $dayname = strtolower(date('l'));
        $squery = "select * from fn_get_listtenants($idcategory, '$dayname', $offset, $pagesize);";
        $query = $this->db->query($squery);
        $listbycategory = array();
        foreach ($query->result_array() as $row) {
            $temp = array('idcategory' => $row['idcategory'], 'categoryname' => $row['categoryname'], 'level' => $row['level'], 'idtenant' => $row['idtenant'], 'avatar' => $row['avatar'], 'tenantsname' => stripslashes($row['tenantsname']), 'address' => stripslashes($row['address']), 'longlat' => $row['longlat'], 'premium' => $row['premium'], 'phone' => $row['phone'], 'link' => $row['link'], 'logo' => $row['logo'], 'color' => $row['color'], 'rate' => $this->round_dec($this->get_rate($row['idtenant'])), 'open' => $this->datepass($row['openhour'], $row['closehour'], $row['open']), 'openhour' => $row['openhour'], 'closehour' => $row['closehour']);
            array_push($listbycategory, $temp);
        }
        return $listbycategory;
    }

    public function listcategoryfilterbyname($idcategory, $pagenumber, $pagesize, $keyword) {
        $offset = ($pagenumber * $pagesize) - $pagesize;
        $dayname = strtolower(date('l'));
        $query = "select * from fn_get_listtenants($idcategory, '$dayname', $offset, $pagesize ,  '" . strtolower($keyword) . "')";
        $query = $this->db->query($query);
        $listcategoryfilterbyname = array();
        foreach ($query->result_array() as $row) {
            $temp = array('idcategory' => $row['idcategory'], 'categoryname' => $row['categoryname'], 'level' => $row['level'], 'idtenant' => $row['idtenant'], 'avatar' => $row['avatar'], 'tenantsname' => stripslashes($row['tenantsname']), 'address' => stripslashes($row['address']), 'longlat' => $row['longlat'], 'premium' => $row['premium'], 'phone' => $row['phone'], 'link' => $row['link'], 'logo' => $row['logo'], 'color' => $row['color'], 'rate' => $this->round_dec($this->get_rate($row['idtenant'])), 'open' => $this->datepass($row['openhour'], $row['closehour'], $row['open']), 'openhour' => $row['openhour'], 'closehour' => $row['closehour']); // access attributes
            array_push($listcategoryfilterbyname, $temp);
        }
        return $listcategoryfilterbyname;
    }

    public function listcategoryfilterbyrecommended($idcategory, $pagenumber, $pagesize, $keyword, $idaccount) {
        $offset = ($pagenumber * $pagesize) - $pagesize;
        $dayname = strtolower(date('l'));
        $query = "select * from fn_get_listtenantsrecomended($idcategory, '$dayname', $offset, $pagesize , '" . strtolower($keyword) . "')";
        $query = $this->db->query($query);
        $listcategoryfilterbyrecommended = array();
        foreach ($query->result_array() as $row) {
            $bookmarked = 'empty';

            if($idaccount!=null) {
                $subquery = "SELECT * FROM bookmark WHERE idtenant=? AND idaccount=?";
                $subquery = $this->db->query($subquery, array($row['idtenant'], $idaccount ));

                if($this->db->affected_rows()>0) {
                    $bookmarked = true;
                } else {
                    $bookmarked = false;
                }
            }

            $temp = array('idcategory' => $row['idcategory'], 'categoryname' => $row['categoryname'], 'level' => $row['level'], 'idtenant' => $row['idtenant'], 'avatar' => $row['avatar'], 'tenantsname' => stripslashes($row['tenantsname']), 'address' => stripslashes($row['address']), 'longlat' => $row['longlat'], 'premium' => $row['premium'], 'phone' => $row['phone'], 'link' => $row['link'], 'logo' => $row['logo'], 'color' => $row['color'], 'rate' => $this->round_dec($this->get_rate($row['idtenant'])), 'open' => $this->datepass($row['openhour'], $row['closehour'], $row['open']), 'openhour' => $row['openhour'], 'closehour' => $row['closehour'], 'bookmarked' => $bookmarked); // access attributes
            array_push($listcategoryfilterbyrecommended, $temp);
        }
        return $listcategoryfilterbyrecommended;
    }

    public function listalltenant($keyword, $pagenumber, $pagesize) {
        $offset = ($pagenumber * $pagesize) - $pagesize;
        $dayname = strtolower(date('l'));

        $query = $this->db->query("SELECT * FROM fn_get_listalltenants('$dayname', $offset, $pagesize, '" . strtolower($keyword) . "')");
        if ($query) {
            $listalltenant = array();
            foreach ($query->result_array() as $row) {
                $temp = array('idcategory' => $row['idcategory'], 'categoryname' => $row['categoryname'], 'level' => $row['level'], 'idtenant' => $row['idtenant'], 'avatar' => $row['avatar'], 'tenantsname' => stripslashes($row['tenantsname']), 'address' => stripslashes($row['address']), 'longlat' => $row['longlat'], 'premium' => $row['premium'], 'phone' => $row['phone'], 'link' => $row['link'], 'logo' => $row['logo'], 'color' => $row['color'], 'rate' => $this->round_dec($this->get_rate($row['idtenant'])), 'open' => $this->datepass($row['openhour'], $row['closehour'], $row['open']), 'openhour' => $row['openhour'], 'closehour' => $row['closehour']);
                array_push($listalltenant, $temp);
            }
            return $listalltenant;
        } else {
            return null;
        }
    }

    public function retrieve_get($idtenant, $idaccount) {
        $dayname = strtolower(date('l'));
        $query = "SELECT * FROM fn_get_detailtenants ($idtenant, '$dayname')";
        $query = $this->db->query($query);
        $retrieve_get = array();
        foreach ($query->result_array() as $row) {
            $temp = array('idcategory' => $row['idcategory'], 'rating' => $this->round_dec($this->get_rate($idtenant)), 'avatar' => $row['avatar'], 'name' => stripslashes($row['name']), 'address' => stripslashes($row['address']), 'phone' => $row['phone'], 'link' => $row['link'], 'logo' => $row['logo'], 'color' => $row['color'], 'longlat' => $row['longlat'], 'premium' => $row['premium'], 'open' => $this->datepass($row['openhour'], $row['closehour'], $row['open']), 'openhour' => $row['openhour'], 'closehour' => $row['closehour'], 'longlat' => $row['longlat'], 'idtenant' => $row['idtenant']); // access attribute
            array_push($retrieve_get, $temp);
        }
        $detail['detail'] = $retrieve_get;

        $menu = "SELECT * FROM fn_get_listmenu_bytenants($idtenant) ";
        $menu = $this->db->query($menu);

        if ($menu->result_array()) {
            $menuarray = array();
            foreach ($menu->result_array() as $row) {
                $temp = array('idmenu' => $row['idmenu'], 'idtenant' => $row['idtenant'], 'menu' => stripslashes($row['menu']), 'price' => $row['price'], 'linkcatalog' => $row['linkcatalog']); // access attribute
                array_push($menuarray, $temp);
            }
            $detail['menu'] = $menuarray;
        }

        $promotion = "SELECT * FROM fn_get_listpromo_bytenants($idtenant) ";
        $promotion = $this->db->query($promotion);
        if ($promotion->result_array()) {
            $promotionarray = array();
            foreach ($promotion->result_array() as $row) {
                $temp = array('idmenu' => $row['idmenu'], 'idtenant' => $row['idtenant'], 'menu' => stripslashes($row['menu']), 'price' => $row['price'], 'linkcatalog' => $row['linkcatalog']); // access attribute
                array_push($promotionarray, $temp);
            }
            $detail['promotion'] = $promotionarray;
        }

        $openh = "SELECT * FROM fn_get_listopenhour_bytenants($idtenant) ";
        $openh = $this->db->query($openh);
        if ($openh->result_array()) {
            $openharray = array();
            foreach ($openh->result_array() as $row) {
                $temp = array('idopenhour' => $row['idopenhour'], 'idtenant' => $row['idtenant'], 'dayname' => $row['dayname'], 'openhour' => $row['openhour'], 'closehour' => $row['closehour'], 'open' => $row['open']); // access attribute
                array_push($openharray, $temp);
            }
            $detail['openhour'] = $openharray;
        }

        //Tambahan untuk detail avatar
        $avatar = "select * from avatar where idtenant=?";
        $avatar = $this->db->query($avatar, array($idtenant));
        if ($avatar->result_array()) {
            $avatararray = array();
            foreach ($avatar->result_array() as $row) {
                $temp = array('idavatar' => $row['idavatar'], 'idtenant' => $row['idtenant'], 'linkavatar' => $row['linkavatar']); // access attribute
                array_push($avatararray, $temp);
            }
            $detail['avatar'] = $avatararray;
        }

        $gallery = "SELECT * FROM fn_get_listgallery_bytenants($idtenant) ";
        $gallery = $this->db->query($gallery);

        if ($gallery->result_array()) {
            $galleryarray = array();
            foreach ($gallery->result_array() as $row) {
                $temp = array('idgallery' => $row['idgallery'], 'idtenant' => $row['idtenant'], 'avatar' => $row['avatar'], 'title' => stripslashes($row['title'])); // access attribute
                array_push($galleryarray, $temp);
            }
            $detail['gallery'] = $galleryarray;
        }

        $discountcoupon = "SELECT * FROM fn_get_listdiscountbytenant($idtenant)";
        $discountcoupon = $this->db->query($discountcoupon);

        if ($discountcoupon->result_array()) {
            $discountcouponarray = array();
            foreach ($discountcoupon->result_array() as $row) {
                $temp = array('iddiscountcoupon' => $row['iddiscountcoupon'], 'idtenant' => $row['idtenant'], 'imageurl' => $row['imageurl'], 'title' => stripslashes($row['title']), 'caption' => stripslashes($row['caption']), 'fileurl' => $row['fileurl'], 'filename' => $row['filename'], 'filesize' => $row['filesize']); // access attribute
                array_push($discountcouponarray, $temp);
            }
            $detail['discountcoupon'] = $discountcouponarray;
        }

        if($idaccount!=null) {
            $squery = "SELECT * FROM tenants WHERE idtenant = ?";
            $query = $this->db->query($squery, array($idtenant));
            foreach ($query->result_array() as $row) {
                $this->db->set('idaccount', $idaccount);
                $this->db->set('activities', "Looking for-".addslashes($row['name']));
                $this->db->set('visitdate', date('Y-m-d H:i:s'));
                $this->db->set('idcategory', $row['idcategory']);
                $this->db->set('idtenant', $row['idtenant']);
                $this->db->insert('history');
            }
        }

        return $detail;
    }

    ////////////////////////////////////////////////////////////////////////////
    public function insert_tenant($idcategory, $name, $avatar, $address, $longlat, $premium, $phone, $link, $logo, $color) {
        $this->db->set('idcategory', $idcategory);
        $this->db->set('name', $name);
        $this->db->set('avatar', $avatar);
        $this->db->set('address', $address);
        $this->db->set('longlat', $longlat);
        $this->db->set('premium', $premium);
        $this->db->set('phone', $phone);
        $this->db->set('link', $link);
        $this->db->set('logo', $logo);
        $this->db->set('color', $color);
        $this->db->insert('tenants');
        return $this->db->affected_rows();
    }

    public function update_tenant($idtenant, $idcategory, $name, $avatar, $address, $longlat, $premium, $phone, $link, $logo, $color) {
        $sql = "UPDATE tenants set name=?, avatar=?, address=?, longlat=?, premium=?, phone=?, link=?, logo=?, color=?, idcategory=? WHERE idtenant=?";
        $query = $this->db->query($sql, array($name, $avatar, $address, $longlat, $premium, $phone, $link, $logo, $color, $idcategory, $idtenant));
        return $this->db->affected_rows();
    }

    public function delete_tenant($idtenant) {
        $sql = "DELETE FROM tenants WHERE idtenant=?";
        $query = $this->db->query($sql, array($idtenant));
        return $this->db->affected_rows();
    }

//===== INTERNAL FUNCTION ===================================================================================================

    public function round_dec($value) {
        $dec = substr($value, 2, 1);
        if($dec>7) {
            $result = ceil($value);
        } else if($dec>=3 && $dec<=7) {
            $result = substr($value, 0, 2)."5";
        } else {
            $result = floor($value);
        }

        return $result;
    }

    public function datepass($open, $close, $openclose){
        $now = strtotime(date("H:i:s"));
        $open = strtotime($open);
        $close = strtotime($close);

        $firststatus = $open - $now;
        $secondstatus = $close - $now;

        if($openclose==1) {
            if($firststatus<0 && $secondstatus>0)  {
                $openstatus = 1;
            } else if(($firststatus>0 && $secondstatus>0) || ($firststatus<0 && $secondstatus<0)) {
                $openstatus = 0;
            }
        } else {
            $openstatus = 0;
        }

        return $openstatus;
    }

    public function get_rate($idtenant) {
        $sql = "select rating.idaccount from rating where rating.idtenant=? group by rating.idaccount";
        $res = $this->db->query($sql, array($idtenant));
        $account_total = $this->db->affected_rows();

        if ($res->result_array()) {
            $rate_total = 0;
            foreach ($res->result_array() as $row) {
                $sql = "select * from rating where rating.idtenant=? and rating.idaccount=? order by rating.idrating desc limit ?";
                $subres = $this->db->query($sql, array($idtenant, $row['idaccount'], 1));

                if ($subres->result_array()) {
                    foreach ($subres->result_array() as $subrow) {
                        $rate_total += $subrow['rating'];
                    }
                }
            }
            
            $result = $rate_total / $account_total;
        }

        return $result;
    }

}