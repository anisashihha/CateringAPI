<?php

defined('BASEPATH') OR exit('No direct script access allowed');
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

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';

class City_Content extends REST_Controller {

    function __construct() {
        // Construct the parent class
        parent::__construct();
        $this->load->model('City_Content_Model');
    }

    public function index_get() {
        // Users from a data store e.g. database
        $action = $this->get('action');
        /* $iduser = $this->get('iduser');
          $token = $this->get('token');
          $this->load->model('tenant_model');
          if (isset($iduser) && isset($token) && $this->tenant_model->get_token($iduser, $token) > 0) { */
        switch ($action) {
            case "select_city":
                $this->select_city();
                break;
            case "contact":
                $this->contact();
                break;
            case "photo_gallery":
                $this->photo_gallery();
                break;
            case "select_page":
                $this->select_page();
                break;
            case "select_news":
                $this->select_news();
                break;
            case "select_tag":
                $this->select_tag();
                break;
            case "select_posttag":
                $this->select_posttag();
                break;
            case "select_transport":
                $this->select_transport();
                break;
            default:
                $this->not_found();
                break;
        }
        /* } else {
          $this->set_response(array("status" => FALSE, "message" => "invalid token"), REST_Controller::HTTP_NON_AUTHORITATIVE_INFORMATION);
          } */
    }

    public function index_post() {
        $action = $this->post('action');
        /* $iduser = $this->get('iduser');
          $token = $this->get('token');
          $this->load->model('tenant_model');
          if (isset($iduser) && isset($token) && $this->tenant_model->get_token($iduser, $token) > 0) { */
        switch ($action) {
            case "insert_news":
                $this->insert_news();
                break;
            case "update_news":
                $this->update_news();
                break;
            case "delete_news":
                $this->delete_news();
                break;
            case "insert_page":
                $this->insert_page();
                break;
            case "update_page":
                $this->update_page();
                break;
            case "delete_page":
                $this->delete_page();
                break;
            case "insert_tag":
                $this->insert_tag();
                break;
            case "insert_tagpost":
                $this->insert_tagpost();
                break;
            case "insert_city":
                $this->insert_city();
                break;
            case "update_city":
                $this->update_city();
                break;
            case "delete_city":
                $this->delete_city();
                break;
            case "insert_photo_gallery":
                $this->insert_photo_gallery();
                break;
            case "update_photo_gallery":
                $this->update_photo_gallery();
                break;
            case "delete_photo_gallery";
                $this->delete_photo_gallery();
                break;
            case "insert_contact":
                $this->insert_contact();
                break;
            case "update_contact":
                $this->update_contact();
                break;
            case "delete_contact":
                $this->delete_contact();
                break;
            case "insert_transport":
                $this->insert_transport();
                break;
            case "delete_transport":
                $this->delete_transport();
                break;
            case "delete_transport_category":
                $this->delete_transport_category();
                break;
            /* case "insert_rute":
              $this->insert_rute();
              break; */
            default:
                $this->not_found();
                break;
        }
    }
    
    public function contact() {
        $id_contact = $this->get('idphonenumber');
        $contact = $this->City_Content_Model->contact($id_contact);
        if (!empty($contact)) {
            $this->set_response($contact, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function insert_contact() {
        $id_city = $this->post('idcity');
        $name = $this->post('name');
        $phone_number = $this->post('phonenumber');
        $caption = $this->post('caption');
        $insert_contact = $this->City_Content_Model->insert_contact($id_city, $name, $phone_number, $caption);
        if (!empty($insert_contact)) {
            $this->set_response($insert_contact, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function update_contact() {
        $id_city = $this->post('idcity');
        $name = $this->post('name');
        $phone_number = $this->post('phonenumber');
        $id_phone_number = $this->post('idphonenumber');
        $update_contact = $this->City_Content_Model->update_contact($id_city, $name, $phone_number, $id_phone_number);
        if (!empty($update_contact)) {
            $this->set_response($update_contact, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
        //var_dump($update_contact);
    }

    public function delete_contact() {
        $id_phone_number = $this->post('idphonenumber');
        $delete_contact = $this->City_Content_Model->delete_contact($id_phone_number);
        if (!empty($delete_contact)) {
            $this->set_response($delete_contact, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
        //var_dump($update_contact);
    }

    public function select_post() {
        $id_post = $this->get('idpost');
        $select_post = $this->City_Content_Model->select_post($id_post);
        if (!empty($select_post)) {
            $this->set_response($select_post, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function insert_post() {
        $id_city = $this->post('idcity');
        $id_user = $this->post('iduser');
        $title_post = $this->post('title');
        $content_post = $this->post('content');
        $date_posted = date('Y-m-d');
        $tag = $this->post('tag');
        $insert_post = $this->City_Content_Model->insert_post($id_city, $id_user, $title_post, $content_post, $date_posted, $tag);
        if (!empty($insert_post)) {
            $this->set_response($insert_post, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code   
        } else {
            $this->not_found();
        }
    }

    public function update_post() {
        $title_post = $this->post('title');
        $content_post = $this->post('content');
        $date_posted = $this->post('dateposted');
        $update_post = $this->City_Content_Model->update_post($title_post, $content_post, $date_posted);
        if (!empty($update_post)) {
            $this->set_response($update_post, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function delete_post() {
        $id_post = $this->post('idpost');
        $delete_post = $this->City_Content_Model->delete_post($id_post);
        if (!empty($delete_post)) {
            $this->set_response($delete_post, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
        //var_dump($update_contact);
    }

    public function select_page() {
        $id_page = $this->get('idpage');
        $select_page = $this->City_Content_Model->select_page($id_page);
        if (!empty($select_page)) {
            $this->set_response($select_page, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function insert_page() {
        $id_city = $this->post('idcity');
        $title_page = $this->post('title');
        $content_page = $this->post('content');
        $insert_page = $this->City_Content_Model->insert_page($id_city, $title_page, $content_page);
        if (!empty($insert_page)) {
            $this->set_response($insert_page, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function update_page() {
        $title_page = $this->post('title');
        $content_page = $this->post('content');
        $id_page = $this->post('idpage');
        $update_page = $this->City_Content_Model->update_page($title_page, $content_page, $id_page);
        if (!empty($update_page)) {
            $this->set_response($update_page, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function delete_page() {
        $id_page = $this->post('idpage');
        $delete_page = $this->City_Content_Model->delete_page($id_page);
        if (!empty($delete_page)) {
            $this->set_response($delete_page, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
        //var_dump($update_contact);
    }

    public function insert_tag() {
        $tag = $this->post('tag');
        $insert_tag = $this->city_content_model->insert_tag($tag);
        if (!empty($insert_tag)) {
            $this->set_response($insert_tag, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function select_tag() {
        $id_tag = $this->get('idtag');
        $select_tag = $this->City_Content_Model->select_tag($id_tag);
        if (!empty($select_tag)) {
            $this->set_response($select_tag, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function insert_tagpost() {
        $id_tag = $this->post('idtag');
        $id_post = $this->post('idpost');
        $insert_tagpost = $this->City_Content_Model->insert_tagpost($id_tag, $id_post);
        if (!empty($insert_tagpost)) {
            $this->set_response($insert_tagpost, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code   
        } else {
            $this->not_found();
        }
    }

    public function select_posttag() {
        $id_tag = $this->get('idtag');
        $select_posttag = $this->City_Content_Model->select_posttag($id_tag);
        if (!empty($select_posttag)) {
            $this->set_response($select_posttag, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function select_city() {
        $id_city = $this->get('idcity');
        $select_city = $this->City_Content_Model->select_city($id_city);
        if (!empty($select_city)) {
            $this->set_response($select_city, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function insert_city() {
        $city_name = $this->post('cityname');
        $city_area = $this->post('cityarea');
        $metro_area = $this->post('metroarea');
        $resident_population = $this->post('residentpopulation');
        $employment_population = $this->post('employmetpopulation');
        $jobs_population = $this->post('jobspopulation');
        $jobs_information = $this->post('jobsinformation');
        $trees_information = $this->post('treesinformation');
        $roads_information = $this->post('roadsinformation');
        $house_information = $this->post('houseinformation');
        $shop_house_information = $this->post('shophouseinformation');
        $school_information = $this->post('schoolinformation');
        $international_school_information = $this->post('internationalschoolinformation');
        $service_apartment_information = $this->post('serviceapartmentinformation');
        $time_zone = $this->post('timezone');
        $area_code = $this->post('areacode');
        $vehicle_registration = $this->post('vehicleregistration');
        $website = $this->post('website');
        $insert_city = $this->City_Content_Model->insert_city($city_name, $city_area, $metro_area, $resident_population, $employment_population, $jobs_population, $jobs_information, $trees_information, $roads_information, $house_information, $shop_house_information, $school_information, $international_school_information, $service_apartment_information, $time_zone, $area_code, $vehicle_registration, $website);
        if (!empty($insert_city)) {
            $this->set_response($insert_city, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function update_city() {
        $city_name = $this->post('cityname');
        $city_area = $this->post('cityarea');
        $metro_area = $this->post('metroarea');
        $resident_population = $this->post('residentpopulation');
        $employment_population = $this->post('employmetpopulation');
        $jobs_population = $this->post('jobspopulation');
        $jobs_information = $this->post('jobsinformation');
        $trees_information = $this->post('treesinformation');
        $roads_information = $this->post('roadsinformation');
        $house_information = $this->post('houseinformation');
        $shop_house_information = $this->post('shophouseinformation');
        $school_information = $this->post('schoolinformation');
        $international_school_information = $this->post('internationalschoolinformation');
        $service_apartment_information = $this->post('serviceapartmentinformation');
        $time_zone = $this->post('timezone');
        $area_code = $this->post('areacode');
        $vehicle_registration = $this->post('vehicleregistration');
        $website = $this->post('website');
        $id_city = $this->post('id_city');
        $update_city = $this->City_Content_Model->update_city($city_name, $city_area, $metro_area, $resident_population, $employment_population, $jobs_population, $jobs_information, $trees_information, $roads_information, $house_information, $shop_house_information, $school_information, $international_school_information, $service_apartment_information, $time_zone, $area_code, $vehicle_registration, $website, $id_city);
        if (!empty($update_city)) {
            $this->set_response($update_city, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function photo_gallery() {
        $id_city = $this->get('idcity');
        $photo_gallery = $this->City_Content_Model->photo_gallery($id_city);
        if (!empty($photo_gallery)) {
            $this->set_response($photo_gallery, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function update_photo_gallery() {
        $title_post = $this->post('title');
        $caption = $this->post('caption');
        $id_photo_gallery = $this->post('idphotogallery');
        $update_photo_gallery = $this->City_Content_Model->update_photo_gallery($title_post, $caption, $id_photo_gallery);
        if (!empty($update_photo_gallery)) {
            $this->set_response($update_photo_gallery, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function insert_photo_gallery() {
        $id_city = $this->post('idcity');
        $image_url = $this->post('imageurl');
        $title = $this->post('title');
        $caption = $this->post('caption');
        $insert_photo_gallery = $this->City_Content_Model->insert_photo_gallery($id_city, $image_url, $title, $caption);
        if (!empty($insert_photo_gallery)) {
            $this->set_response($insert_photo_gallery, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function delete_photo_gallery() {
        $id_photo_gallery = $this->post('idphotogallery');
        $delete_photo_gallery = $this->City_Content_Model->delete_photo_gallery($id_photo_gallery);
        if (!empty($delete_photo_gallery)) {
            $this->set_response($delete_photo_gallery, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function select_transport() {
        $id_transport = $this->get('idtransport');
        $select_transport = $this->City_Content_Model->select_transport($id_transport);
        if (!empty($select_transport)) {
            $this->set_response($select_transport, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function insert_transport() {
        $id_transport_category = $this->post('idtransportcategory');
        $id_city = $this->post('idcity');
        $name = $this->post('name');
        $location = $this->post('location');
        $latitude = $this->post('latitude');
        $longitude = $this->post('longitude');
        $time = $this->post('time');
        $insert_transport = $this->City_Content_Model->insert_transport($id_transport_category, $id_city, $name, $location, $latitude, $longitude, $time);
        if (!empty($insert_transport)) {
            $this->set_response($insert_transport, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function delete_transport() {
        $id_transport = $this->post('idtransport');
        $delete_transport = $this->City_Content_Model->delete_transport($id_transport);
        if (!empty($delete_transport)) {
            $this->set_response($delete_transport, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    public function delete_transport_category() {
        $id_transport_category = $this->post('idtransportcategory');
        $delete_transport_category = $this->City_Content_Model->delete_transport_category($id_transport_category);
        if (!empty($delete_transport_category)) {
            $this->set_response($delete_transport_category, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->not_found();
        }
    }

    /* public function insert_rute() {
      $location = $this->post('location');
      $latitude = $this->post('latitude');
      $longitude = $this->post('longitude');
      $time = $time->post('time');
      $insert_rute = $this->City_Content_Model->insert_rute($location, $latitude, $longitude, $time);
      if (!empty($insert_rute)) {
      $this->set_response($insert_rute, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
      } else {
      $this->not_found();
      }
      } */

    public function not_found() {
        $this->set_response([
            'status' => FALSE,
            'message' => 'not found'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
    }
}
