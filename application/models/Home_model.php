<?php

class Home_model extends CI_Model
{

	public function _consruct()
	{
		parent::_construct();
		date_default_timezone_set("Asia/Kolkata");
	}



	function get_user()
	{
		$this->db->where('status', 1);
		$this->db->order_by('created_date', 'desc');
		$query = $this->db->get('admin_users');
		$result = $query->result();
		return $result;
	}
	



	
}
