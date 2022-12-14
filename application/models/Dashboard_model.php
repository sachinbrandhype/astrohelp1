<?php 

class Dashboard_model extends CI_Model {
	
	public function _consruct(){
		parent::_construct();
 	}
	
	function get_user_count() {
		
		//$menu = $this->session->userdata('admin');
				  $this->db->where('user_type',2);
		$result = $this->db->count_all_results('admin_users');
		return $result;
	}
	
}