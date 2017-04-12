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
 * Description of News_model
 *
 * @author Anisa' Shihhatin Sholihah
 * 27 Juni 2016
 */
class News_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function listnews($pagenumber, $pagesize, $lang) {
        $offset = ($pagenumber * $pagesize) - $pagesize;
        if($lang=="ina") { $query = $this->db->query("SELECT * FROM fn_get_listnews($offset, $pagesize)"); }
        else { $query = $this->db->query("SELECT * FROM fn_get_listnews_en($offset, $pagesize)"); }

        if (!empty($query)) {
            $News = array();
            foreach ($query->result_array() as $row) {

                $newsgallery = "SELECT * FROM fn_get_listnewsgallery(".$row['idnews'].")";
                $newsgallery = $this->db->query($newsgallery);
                $newsgalleryarray = array();

                if ($newsgallery->result_array()) {
                    foreach ($newsgallery->result_array() as $subrow) {
                        $subtemp = array('idnewsgallery' => $subrow['idnewsgallery'], 'avatar' => $subrow['avatar']); // access attribute
                        array_push($newsgalleryarray, $subtemp);
                    }
                }

                $temp = array('status' => true, 'idnews' => $row['idnews'], 'avatar' => $row['avatar'], 'createdate' => $row['createdate'], 'title' => stripslashes($row['title']), 'description' => stripslashes($row['description']), 'gallery' => $newsgalleryarray); // access attributes
                array_push($News, $temp);
            }

            return $News;
        } else {
            return null;
        }
    }

    public function listnewsfilterbyname($pagenumber, $pagesize, $keyword, $lang) {
        $offset = ($pagenumber * $pagesize) - $pagesize;
        if($lang=="ina") { $query = $this->db->query("SELECT * FROM fn_get_listnews($offset, $pagesize, '" . strtolower($keyword) . "')"); }
        else { $query = $this->db->query("SELECT * FROM fn_get_listnews_en($offset, $pagesize, '" . strtolower($keyword) . "')"); }

        if (!empty($query)) {
            $News = array();
            foreach ($query->result_array() as $row) {
                $newsgallery = "SELECT * FROM fn_get_listnewsgallery(".$row['idnews'].")";
                $newsgallery = $this->db->query($newsgallery);
                $newsgalleryarray = array();

                if ($newsgallery->result_array()) {
                    foreach ($newsgallery->result_array() as $subrow) {
                        $subtemp = array('idnewsgallery' => $subrow['idnewsgallery'], 'avatar' => $subrow['avatar']); // access attribute
                        array_push($newsgalleryarray, $subtemp);
                    }
                }

                $temp = array('status' => true, 'idnews' => $row['idnews'], 'avatar' => $row['avatar'], 'createdate' => $row['createdate'], 'title' => stripslashes($row['title']), 'description' => stripslashes($row['description']), 'gallery' => $newsgalleryarray); // access attributes
                array_push($News, $temp);
            }
            return $News;
        } else {
            return null;
        }
    }

    public function retrieve_get($idnews) {
        $dayname = strtolower(date('l'));
        $query = "SELECT * FROM fn_get_detailnews ($idnews)";
        $query = $this->db->query($query);
        $retrieve_get = array();
        foreach ($query->result_array() as $row) {
            $temp = array('idnews' => $row['idnews'], 'avatar' => $row['avatar'], 'createdate' => $row['createdate'], 'title' => stripslashes($row['title']), 'description' => stripslashes($row['description']), 'title_en' => stripslashes($row['title_en']), 'description_en' => stripslashes($row['description_en'])); // access attribute
            array_push($retrieve_get, $temp);
        }
        $detail['detail'] = $retrieve_get;
        $detail['gallery'] = array();

        $newsgallery = "SELECT * FROM fn_get_listnewsgallery($idnews)";
        $newsgallery = $this->db->query($newsgallery);

        if ($newsgallery->result_array()) {
            $newsgalleryarray = array();
            foreach ($newsgallery->result_array() as $row) {
                $temp = array('idnewsgallery' => $row['idnewsgallery'], 'idnews' => $row['idnews'], 'avatar' => $row['avatar']); // access attribute
                array_push($newsgalleryarray, $temp);
            }
            $detail['gallery'] = $newsgalleryarray;
        }

        return $detail;
    }

    ////////////////////////////////////////////////////////////////////////////
    public function insert_news($avatar, $createdate, $title, $description, $title_en, $description_en) {
        $this->db->set('avatar', $avatar);
        $this->db->set('createdate', date('Y-m-d H:i:s'));
        $this->db->set('title', $title);
        $this->db->set('description', $description);
        $this->db->set('title_en', $title_en);
        $this->db->set('description_en', $description_en);
        $this->db->insert('news');
        return $this->db->affected_rows();
    }

    public function update_news($idnews, $avatar, $title, $description, $title_en, $description_en) {
        $sql = "UPDATE news set avatar=?, title=?, description=?, title_en=?, description_en=? WHERE idnews=?";
        $query = $this->db->query($sql, array($avatar, $title, $description, $title_en, $description_en, $idnews));
        return $this->db->affected_rows();
    }

    public function delete_news($idnews) {
        $sql = "DELETE FROM news WHERE idnews=?";
        $query = $this->db->query($sql, array($idnews));
        return $this->db->affected_rows();
    }

}
