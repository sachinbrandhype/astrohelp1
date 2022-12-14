<?php 

class Login_model extends CI_Model {
	
	public function _consruct(){
		parent::_construct();
 	}
	 function login($username, $password) {
		$this -> db -> select('id, username, fname,lname,profile_pic,designation,user_type');
		$this -> db -> from('admin_users');
		$this -> db -> where('email_id', $username);
		$this -> db -> where('password', $password);
		$this -> db -> limit(1);
		$query = $this -> db -> get();
		if ($query -> num_rows() == 1) {
			return $query->result();
		}
		else {
			return false;
		}
	}
	function check_login_otp($email, $otp) {
		$this -> db -> select('id, username, fname,lname,profile_pic,designation');
		$this -> db -> from('admin_users');
		$this -> db -> where('email_id', $email);
		$this -> db -> where('otp', $otp);
		$this -> db -> limit(1);
		$query = $this -> db -> get();
		if ($query -> num_rows() == 1) {
			return $query->result();
		}
		else {
			return false;
		}
	}
	function login_saloon($username, $password) {
      $check_email =$this->db->query("SELECT * FROM `shop_details` WHERE ( `phone_no` = '$username' OR `email_id` = '$username') AND `password` = '$password' AND status = 1");
	  if ($check_email -> num_rows() == 1) {
	  		return $check_email->row();
	  }
	  else{
	  	return false;
	  }
	}
	function check_email($email){
		$this -> db -> select('id');
		$this -> db -> from('admin_users');
		$this -> db -> where('email_id', $email);
		$this -> db -> limit(1);
		$query = $this -> db -> get();
		if ($query -> num_rows() == 1) {
			return $query->result();
		}
		else {
			return false;
		}
	}
	function check_email_for_login($email){
		$this -> db -> select('id');
		$this -> db -> from('admin_users');
		$this -> db -> where('email_id', $email);
		//$this -> db -> where('user_type', 1);
		$this -> db -> limit(1);
		$query = $this -> db -> get();
		if ($query -> num_rows() == 1) {
			return $query->result();
		}
		else {
			return false;
		}
	}

}