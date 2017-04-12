
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
class Account_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    function login($email, $password) {
        $sql = "SELECT account.*, profile.fullname, profile.address, profile.phone FROM account, profile WHERE email=? AND account.idaccount=profile.idaccount";
        $query = $this->db->query($sql, array($email));
        if (sizeof($query->result()) > 0) {
            $row = $query->result()[0];

            if($row->isactive=='t') {
                if(password_verify($password, $row->password)) {
                    $dataresult = array(array('status' => true, 'idaccount' => $row->idaccount, 'fullname' => stripslashes($row->fullname), 'email' => stripslashes($row->email), 'privilege' => $row->privilege, 'address' => stripslashes($row->address), 'phone' => $row->phone));
                } else {
                    $dataresult = array(array('status' => false, 'messages' => 'Email or password is incorrect'));
                }
            } else if($row->isactive=='f') {
                $dataresult = array(array('status' => 'inactive', 'messages' => 'Please check your email to activate your account'));
            }
        } else {
            $dataresult = array(array('status' => false, 'messages' => "User Account Not Registered"));
        }

        return array('status' => true, 'dataresult' => $dataresult);
    }

    function register($email, $password, $privilege, $fullname, $gender, $dateofbirth, $phone, $pscode) {
        if($phone!=null) {
             $sql = "SELECT account.*, profile.fullname, profile.address, profile.phone FROM account, profile WHERE (account.email=? OR profile.phone=?) AND account.idaccount=profile.idaccount";
             $query = $this->db->query($sql, array($email, $phone));
        } else {
             $sql = "SELECT account.*, profile.fullname, profile.address, profile.phone FROM account, profile WHERE account.email=? AND account.idaccount=profile.idaccount";
             $query = $this->db->query($sql, array($email));
        }

        if (sizeof($query->result()) > 0) {
            foreach ($query->result_array() as $row) {
                $row = $query->result()[0];
                $dataresult = array(array('status' => false, 'message' => 'email or phone already exist', 'idaccount' => $row->idaccount, 'fullname' => stripslashes($row->fullname), 'email' => stripslashes($row->email), 'privilege' => $row->privilege, 'address' => stripslashes($row->address), 'phone' => $row->phone, 'isactive' => $row->isactive)); // access attributes
            }

            return array('affected' => 0, 'dataresult' => $dataresult);
        } else {
            $this->db->set("password", $password);
            $this->db->set("email", $email);
            $this->db->set("privilege", $privilege);
            $this->db->set("createdate", date('Y-m-d H:i:s'));
            $this->db->set("codeconfirm", rand(000000, 999999));
            $query_result = $this->db->insert("account");

            if ($query_result == false) {
                return null;
            } else {
                $idaccount = $this->db->insert_id();
                $this->db->set("idaccount", $idaccount);
                $this->db->set("fullname", $fullname);
                $this->db->set("gender", $gender);
                $this->db->set("dateofbirth", $dateofbirth);
                $this->db->set("phone", $phone);
                $this->db->set("pscode", $pscode);

                $this->db->insert("profile");

                return array('affected' => $this->db->affected_rows(), 'idaccount' => $idaccount);
            }
        }
    }

    function forget_password($contact, $type) {
        if($type=="email") {
            $sql = "select idaccount from account where email=?";
            $query = $this->db->query($sql, array($contact));
        } else if($type=="phone") {
            $sql = "select idaccount from profile where phone=?";
            $query = $this->db->query($sql, array($contact));
        } else {
            $sql = "select idaccount from account where email=?";
            $query = $this->db->query($sql, array('xxx123'));
        }

        if (sizeof($query->result()) > 0) {
            $row = $query->result()[0];

            return array('status' => true, 'idaccount' => $row->idaccount, 'contact' => $contact, 'type' => $type);
        } else {
            return array('status' => false, 'message' => 'email or phone doesn\'t exist');
        }
    }

    public function gen_code($idaccount, $contact) {
        $codeConfirm = rand(000000, 999999);

        $sql = "UPDATE account SET isconfirm=?, codeconfirm=? WHERE idaccount=?";
        $query_result = $this->db->query($sql, array(false, $codeConfirm, $idaccount));

        if ($query_result == false) {
            return array('status' => false, 'message' => 'system fail');
        } else {
            return array('status' => true, 'codeconfirm' => $codeConfirm, 'contact' => $contact);
        }
    }

    function check_code($code, $idaccount) {
        $sql = "UPDATE account SET isconfirm=? WHERE codeconfirm=? AND idaccount=?";
        $query = $this->db->query($sql, array(TRUE, $code, $idaccount ));
        return $this->db->affected_rows();
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function listaccount() {
        $query = $this->db->query("SELECT * FROM fn_get_listaccount()");
        if (!empty($query)) {
            $account = array();
            foreach ($query->result_array() as $row) {
                $temp = array('status' => true, 'idaccount' => $row['idaccount'], 'privilege' => $row['privilege'], 'fullname' => stripslashes($row['fullname']), 'email' => stripslashes($row['email']), 'createdate' => $row['createdate'], 'password' => $row['password']); // access attributes
                array_push($account, $temp);
            }
            return $account;
        } else {
            return null;
        }
    }

    public function retrieve_get($idaccount) {
        $sql = "SELECT a.idaccount, a.privilege, a.email, a.createdate, p.gender, p.dateofbirth, p.phone, p.fullname, p.address, p.avatar, p.pscode FROM account as a, profile as p WHERE a.idaccount=? AND a.idaccount=p.idaccount";
        $query = $this->db->query($sql, array($idaccount));
        $row = $query->result();

        if (!empty($row)) {
            $account_data = array();
            foreach ($query->result_array() as $account_item) {
                $temp = array('idaccount' => $account_item['idaccount'], 'privilege' => $account_item['privilege'], 'email' => stripslashes($account_item['email']), 'createdate' => $account_item['createdate'], 'gender' => $account_item['gender'], 'dateofbirth' => $account_item['dateofbirth'], 'phone' => $account_item['phone'], 'fullname' => stripslashes($account_item['fullname']), 'address' => stripslashes($account_item['address']), 'avatar' => $account_item['avatar'], 'pscode' => $account_item['pscode']);
                array_push($account_data, $temp);
            }
            $data['account'] = $account_data;

            $query = "SELECT * FROM fn_get_history ($idaccount)";
            $query = $this->db->query($query);
            $get_history = array();
            foreach ($query->result_array() as $history_item) {
                $temp = array('idhistory' => $history_item['idhistory'],  'idaccount' => $history_item['idaccount'], 'idcategory' => $history_item['idcategory'], 'activities' => stripslashes($history_item['activities']),  'visitdate' => $history_item['visitdate']); // access attribute
                array_push($get_history, $temp);
            }
            $data['history'] = $get_history;

            return $data;
        } else {
            return null;
        }
    }

////////////////////////////////////////////////////////////

    public function update_account($idaccount, $privilege, $gender, $phone, $dateofbirth, $fullname, $password, $email, $address, $avatar, $pscode) {
        $sql = "SELECT * FROM profile WHERE phone=? AND idaccount<>?";
        $query = $this->db->query($sql, array($phone, $idaccount));
        if (!($this->db->affected_rows() > 0)) {
            $query = "UPDATE account SET privilege=?, email=? WHERE idaccount=?";
            $this->db->query($query, array($privilege, $email, $idaccount));
            if ($this->db->affected_rows() > 0) {
                if($dateofbirth!=null && $pscode!=null) {
                    $query = "UPDATE profile SET fullname=?, gender=?, phone=?, dateofbirth=?, address=?, avatar=?, pscode=? WHERE idaccount=?";
                    $this->db->query($query, array($fullname, $gender, $phone, $dateofbirth, $address, $avatar, $pscode, $idaccount));
                } else {
                    $query = "UPDATE profile SET fullname=?, gender=?, phone=?, address=?, avatar=? WHERE idaccount=?";
                    $this->db->query($query, array($fullname, $gender, $phone, $address, $avatar, $idaccount));
                }

                if ($this->db->affected_rows() > 0) {
                    return array('status' => true);
                } else {
                    $dataresult = array(array('status' => false, 'messages' => 'Update profile failed'));
                    return array('status' => false, 'dataresult' => $dataresult);
                }
            } else {
                $dataresult = array(array('status' => false, 'messages' => 'Update account failed'));
                return array('status' => false, 'dataresult' => $dataresult);
            }
        } else {
            $dataresult = array(array('status' => false, 'messages' => 'Phone already exist'));
            return array('status' => false, 'dataresult' => $dataresult);
        }
    }

    public function delete_account($idaccount) {
        $sql = "DELETE FROM account WHERE idaccount=?";
        $this->db->query($sql, array($idaccount));

        return $this->db->affected_rows();
    }

    public function change_password($idaccount, $password) {
        $sql = "UPDATE account SET password=? WHERE idaccount=?";
        $query = $this->db->query($sql, array($password, $idaccount));
        return $this->db->affected_rows();
    }

}
