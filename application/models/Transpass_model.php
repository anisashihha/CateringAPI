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
class Transpass_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    function update($fidaccount, $lidaccount) {
        $count_succ = 0;

        for($idaccount=$fidaccount; $idaccount<=$lidaccount; $idaccount++) {
            $sql = "SELECT * FROM account WHERE idaccount=?";
            $query = $this->db->query($sql, array($idaccount));

            if($this->db->affected_rows()>0) {
                foreach ($query->result_array() as $row) {
                    $password_ori = $row['password'];
                }

                if(substr($password_ori, 0, 6)!='$2y$11') {

                    $query = "UPDATE account SET password2=?, password=? WHERE idaccount=?";
                    $this->db->query($query, array($password_ori, $this->hashing($password_ori), $idaccount));

                    $count_succ += $this->db->affected_rows();
                }
            }
        }

        return $count_succ;
    }

    function hashing($pwd) {
        $options = [
        'cost' => 11,
        'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
        ];

        return password_hash($pwd, PASSWORD_BCRYPT, $options);
    }

}