<?php
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
class user_model extends CI_Model {
    
    public function __construct (){
      parent::__construct ();
    }
    
    function login($username, $password){
        $query = $this->db->query("SELECT * FROM user;");
        $user = array();
        foreach ($query->result_array() as $row){
            $temp = array('username' => $row['username'], 'fullName' => $row['fullName']); // access attributes
            array_push($user, $temp);
        }
        return $user;
    }
}