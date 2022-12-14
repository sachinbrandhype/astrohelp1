<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct() {
		parent::__construct();
		date_default_timezone_set("Asia/Kolkata");
		
		$this->load->model('dashboard_model');
		if(!$this->session->userdata('logged_in')) {
			redirect(base_url());
		}
 	}
	
	
	public function index() {
		$role_id = $this->session->userdata('role_id');
		$template['page_title'] = "Dashboard";
		$template['page'] = 'dashboard';
		$this->load->view('template',$template);
	}

}
