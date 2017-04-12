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
 * Description of City_model
 *
 * @author Anisa' Shihhatin Sholihah
 * 27 Juni 2016
 */

class City_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function listgallery($idcity, $pagenumber, $pagesize) {
        $offset = ($pagenumber * $pagesize) - $pagesize;
        //echo '('.$pagenumber.' * '.$pagesize.') - '.$pagesize;
        $query = $this->db->query("SELECT * FROM fn_get_listcitygallery_bycity($idcity, $offset, $pagesize)");
        if (!empty($query)) {
            $listgallery = array();
            foreach ($query->result_array() as $row) {
                $temp = array('status' => true, 'idcitygallery' => $row['idcitygallery'], 'idcity' => $row['idcity'], 'title' => stripslashes($row['title']), 'avatar' => $row['avatar']); // access attributes
                array_push($listgallery, $temp);
            }
            return $listgallery;
        } else {
            return null;
        }
    }

    public function select_datacity($idcity) {
        $query = $this->db->query("SELECT * FROM fn_get_datacity_bycity($idcity)");
        if (!empty($query)) {
            $select_datacity = array();
            foreach ($query->result_array() as $row) {
                $temp = array('status' => true, 'idcity' => $row['idcity'], 'cityname' => stripslashes($row['cityname']), 'cityarea' => $row['cityarea'], 'residentpopulation' => $row['residentpopulation'], 'employmentpopulation' => $row['employmentpopulation'], 'jobspopulation' => $row['jobspopulation'], 'jobsinformation' => stripslashes($row['jobsinformation']), 'treesinformation' => stripslashes($row['treesinformation']), 'roadinformation' => stripslashes($row['roadinformation']), 'houseinformation' => stripslashes($row['houseinformation']), 'shophouseinformation' => stripslashes($row['shophouseinformation']), 'schoollinformation' => stripslashes($row['schoollinformation']), 'internationalschoollinformation' => stripslashes($row['internationalschoollinformation']), 'serviceapartmentinformation' => stripslashes($row['serviceapartmentinformation']), 'timezone' => $row['timezone'], 'areacode' => $row['areacode'], 'vehicleregistration' => $row['vehicleregistration'], 'website' => stripslashes($row['website'])); // access attributes
                array_push($select_datacity, $temp);
            }
            return $select_datacity;
        } else {
            return null;
        }
    }

    public function listgalleryfilterbyname($idcity, $pagenumber, $pagesize, $keyword) {
        $offset = ($pagenumber * $pagesize) - $pagesize;
        $query = $this->db->query("SELECT * FROM fn_get_listcitygallery_bycity(".$idcity.", ".$offset.", ".$pagesize.", '".strtolower($keyword)."')");
        $listgalleryfilterbyname = array();
        foreach ($query->result_array() as $row) {
            $temp = array('idcitygallery' => $row['idcitygallery'], 'idcity' => $row['idcity'], 'avatar' => $row['avatar'], 'title' => stripslashes($row['title'])); // access attributes
            array_push($listgalleryfilterbyname, $temp);
        }

        return $listgalleryfilterbyname;
    }

    public function listglobal($idcity, $pagenumber, $pagesize, $keyword) {
        $listglobal = array();
        $offset = ($pagenumber * $pagesize) - $pagesize;

        //=== LIST TENANT ======================
        $dayname = strtolower(date('l'));

        $query = $this->db->query("SELECT * FROM fn_get_listalltenants('$dayname', $offset, $pagesize, '".strtolower($keyword)."')");
        if ($this->db->affected_rows()>0) {
            $tenants = array();

            $sql = "SELECT count(*) as count FROM tenants WHERE LOWER(name) LIKE ?";
            $subquery = $this->db->query($sql, array(strtolower($keyword)));
            foreach($subquery->result_array() as $subrow) {array_push($tenants, array('count' => $subrow['count']));}

            foreach ($query->result_array() as $row) {
                $temp = array('idcategory' => $row['idcategory'], 'categoryname' => $row['categoryname'], 'level' => $row['level'], 'idtenant' => $row['idtenant'], 'avatar' => $row['avatar'], 'tenantsname' => stripslashes($row['tenantsname']), 'address' => stripslashes($row['address']), 'longlat' => $row['longlat'], 'premium' => $row['premium'], 'phone' => $row['phone'], 'link' => $row['link'], 'rate' => $row['rate'], 'open' => $row['open'], 'openhour' => $row['openhour'], 'closehour' => $row['closehour']);
                array_push($tenants, $temp);
            }
            $listglobal['tenants'] = $tenants;
        }

        //=== LIST PROPERTY ======================
        $squery = "select * from fn_get_listproperty(39, $offset, $pagesize, '%%', '" . strtolower($keyword) . "');";
        $query = $this->db->query($squery);
        if ($this->db->affected_rows()>0) {
            $property = array();

            $sql = "SELECT count(*) as count FROM property WHERE LOWER(name) LIKE ?";
            $subquery = $this->db->query($sql, array(strtolower($keyword)));
            foreach($subquery->result_array() as $subrow) {array_push($property, array('count' => $subrow['count']));}

            foreach ($query->result_array() as $row) {
                $temp = array('idproperty' => $row['idproperty'], 'idcategory' => $row['idcategory'], 'categoryname' => $row['categoryname'], 'name' => stripslashes($row['name']), 'type' => $row['type'], 'price' => $row['price'], 'avatar' => $row['avatar'], 'lb' => $row['lb'], 'lt' => $row['lt'], 'status' => $row['status']); // access attributes
                array_push($property, $temp);

            }
            $listglobal['property'] = $property;
        }

        //=== LIST DISCOUNTCOUPON ======================
        $squery = "SELECT * FROM fn_get_listdiscount($offset, $pagesize, '" . strtolower($keyword) . "')";
        $query = $this->db->query($squery);
        if ($this->db->affected_rows()>0) {
            $discountcoupon = array();

            $sql = "SELECT count(*) as count FROM discountcoupon WHERE LOWER(title) LIKE ?";
            $subquery = $this->db->query($sql, array(strtolower($keyword)));
            foreach($subquery->result_array() as $subrow) {array_push($discountcoupon, array('count' => $subrow['count']));}

            foreach ($query->result_array() as $row) {
                $temp = array('iddiscountcoupon' => $row['iddiscountcoupon'], 'idtenant' => $row['idtenant'], 'imageurl' => $row['imageurl'], 'title' => stripslashes($row['title']), 'caption' => $row['caption'], 'name' => stripslashes($row['name']), 'fileurl' => $row['fileurl'], 'filename' => $row['filename'], 'filesize' => $row['filesize']); // access attributes
                array_push($discountcoupon, $temp);
            }
            $listglobal['discountcoupon'] = $discountcoupon;
        }

        //=== LIST CITYGALLERY ======================
        $sql = "SELECT * FROM fn_get_listcitygallery_bycity(?, ?, ?, ?)";
        $query = $this->db->query($sql, array($idcity, $offset, $pagesize, strtolower($keyword)));
        if ($this->db->affected_rows()>0) {
            $citygallery = array();

            $sql = "SELECT count(*) as count FROM citygallery WHERE LOWER(title) LIKE ?";
            $subquery = $this->db->query($sql, array(strtolower($keyword)));
            foreach($subquery->result_array() as $subrow) {array_push($citygallery, array('count' => $subrow['count']));}

            foreach ($query->result_array() as $row) {
                $temp = array('idcitygallery' => $row['idcitygallery'], 'idcity' => $row['idcity'], 'avatar' => $row['avatar'], 'title' => stripslashes($row['title'])); // access attributes
                array_push($citygallery, $temp);
            }
            $listglobal['citygallery'] = $citygallery;
        }

        //=== LIST NEWS =============================
        $sql = "SELECT * FROM fn_get_listnews(?, ?, ?)";
        $query = $this->db->query($sql, array($offset, $pagesize, strtolower($keyword)));
        if ($this->db->affected_rows()>0) {
            $news = array();

            $sql = "SELECT count(*) as count FROM news WHERE LOWER(title) LIKE ?";
            $subquery = $this->db->query($sql, array(strtolower($keyword)));
            foreach($subquery->result_array() as $subrow) {array_push($news, array('count' => $subrow['count']));}

            foreach ($query->result_array() as $row) {
                $temp = array('status' => true, 'idnews' => $row['idnews'], 'avatar' => $row['avatar'], 'createdate' => $row['createdate'], 'title' => stripslashes($row['title']), 'description' => stripslashes($row['description'])); // access attributes
                array_push($news, $temp);
            }
            $listglobal['news'] = $news;
        }

        return $listglobal;
    }


    ////////////////////////////////////////////////////////////////////////////
    public function insert_gallery($idcity, $title, $avatar) {
        $this->db->set('idcity', $idcity);
        $this->db->set('title', $title);
        $this->db->set('avatar', $avatar);
        $this->db->insert('citygallery');
        return $this->db->affected_rows();
    }

    public function update_gallery($idcitygallery, $title, $avatar) {
        $sql = "UPDATE citygallery set title=?, avatar=? WHERE idcitygallery=?";
        $query = $this->db->query($sql, array($title, $avatar, $idcitygallery ));
        return $this->db->affected_rows();
    }

    public function delete_gallery($idcitygallery) {
        $sql = "DELETE FROM citygallery WHERE idcitygallery=?";
        $query = $this->db->query($sql, array($idcitygallery));
        return $this->db->affected_rows();
    }

    ////////////////////////////////////////////////////////////////////////////
    public function insert_datacity($cityname, $title, $residentpopulation, $employmentpopulation, $jobspopulation, $jobsinformation, $treesinformation, $roadinformation, $houseinformation, $shophouseinformation, $schoollinformation, $internationalschoollinformation, $serviceapartmentinformation, $timezone, $areacode, $vehicleregistration, $website) {
        $this->db->set('cityname', $cityname);
        $this->db->set('cityarea', $title);
        $this->db->set('residentpopulation', $residentpopulation);
        $this->db->set('employmentpopulation', $employmentpopulation);
        $this->db->set('jobspopulation', $jobspopulation);
        $this->db->set('jobsinformation', $jobsinformation);
        $this->db->set('treesinformation', $treesinformation);
        $this->db->set('roadinformation', $roadinformation);
        $this->db->set('houseinformation', $houseinformation);
        $this->db->set('shophouseinformation', $shophouseinformation);
        $this->db->set('schoollinformation', $schoollinformation);
        $this->db->set('internationalschoollinformation', $internationalschoollinformation);
        $this->db->set('serviceapartmentinformation', $serviceapartmentinformation);
        $this->db->set('timezone', $timezone);
        $this->db->set('areacode', $areacode);
        $this->db->set('vehicleregistration', $vehicleregistration);
        $this->db->set('website', $website);
        $this->db->insert('city');
        return $this->db->affected_rows();
    }

    public function update_datacity($idcity, $cityname, $cityarea, $residentpopulation, $employmentpopulation, $jobspopulation, $jobsinformation, $treesinformation, $roadinformation, $houseinformation, $shophouseinformation, $schoollinformation, $internationalschoollinformation, $serviceapartmentinformation, $timezone, $areacode, $vehicleregistration, $website) {
        $sql = "UPDATE city set cityname=?, cityarea=?, residentpopulation=?, employmentpopulation=?, jobspopulation=?, jobsinformation=?, treesinformation=?, roadinformation=? , houseinformation=?, shophouseinformation=?, schoollinformation=?, internationalschoollinformation=?, serviceapartmentinformation=?, timezone=?, areacode=?, vehicleregistration=?, website=? WHERE idcity=?";
        $query = $this->db->query($sql, array($cityname, $cityarea, $residentpopulation, $employmentpopulation, $jobspopulation, $jobsinformation, $treesinformation, $roadinformation, $houseinformation, $shophouseinformation, $schoollinformation, $internationalschoollinformation, $serviceapartmentinformation, $timezone, $areacode, $vehicleregistration, $website, $idcity));
        return $this->db->affected_rows();
    }

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

}
