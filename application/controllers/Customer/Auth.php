<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{


	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set("Asia/Kolkata");
		$this->load->library("pagination");
        $this->load->library('form_validation');
	}

    public function nodeserverapi($end_point='',$method='POST',$data=[])
    {
        // $data = json_encode($data);
        return json_decode($this->applib->node_api_curl($end_point,$method,($data)));
    }

	public function login()
	{

		$template['page'] = CUSTOMER_VIEW.'/auth/login';
		$template['page_title'] = "Shaktipeethdigital Login";
		$this->load->view( CUSTOMER_VIEW.'/auth/auth_template', $template);
	}
    
    public function login_req()
    {
        if($_POST){
            $this->form_validation->set_rules('phone', 'Mobile Number', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required');

            if ($this->form_validation->run() == FALSE)
            {
                $this->session->set_flashdata('message', array('message' => validation_errors(), 'class' => 'danger'));
                return redirect($this->agent->referrer());
            }
            else
            {
                $req_res = $this->nodeserverapi('login_with_password','POST',$this->input->post());
                if(!$req_res->status){
                    $this->session->set_flashdata('message', array('message' => $req_res->message, 'class' => 'danger'));
                    return redirect($this->agent->referrer());
                }
                // print_r($req_res);die;
                $this->loggedInSession($req_res->data,$req_res->token);
                return redirect(base_url(''));
            }
        }
    }


    public function register()
    {
        $template['page'] = CUSTOMER_VIEW.'/auth/register';
		$template['page_title'] = "Shaktipeethdigital Register";
		$this->load->view( CUSTOMER_VIEW.'/auth/auth_template', $template);
    }

    public function register_resend($phone)
    {
        $req_res = $this->nodeserverapi('register_otp','POST',['phone'=>$phone]);
        if(!$req_res->status){
            $this->session->set_flashdata('message', array('message' => $req_res->message, 'class' => 'danger'));
            return redirect($this->agent->referrer());
        }

        $this->session->set_userdata('otp_req', $req_res->data);
        return redirect($this->agent->referrer());
    }
    public function register_req()
    {
        if($_POST){
            $this->form_validation->set_rules('phone', 'Mobile Number', 'required');
            if ($this->form_validation->run() == FALSE)
            {
                $this->session->set_flashdata('message', array('message' => validation_errors(), 'class' => 'danger'));
                return redirect($this->agent->referrer());
            }
            else
            {
                $req_res = $this->nodeserverapi('register_otp','POST',$this->input->post());
                if(!$req_res->status){
                    $this->session->set_flashdata('message', array('message' => $req_res->message, 'class' => 'danger'));
                    return redirect($this->agent->referrer());
                }

                $this->session->set_userdata('otp_req', $req_res->data);
                return redirect(base_url('otp'));
            }
        }
    }

    public function otp_screen()
	{
        if(!$this->session->userdata('otp_req')){
            return redirect(base_url('login'));
        }
        $template['otp_req_obj'] =$otp_req= $this->session->userdata('otp_req');
        $template['phone']=$otp_req->phone;
		$template['page'] = CUSTOMER_VIEW.'/auth/otp_screen';
		$template['page_title'] = "Shaktipeethdigital Login";
		$this->load->view( CUSTOMER_VIEW.'/auth/auth_template', $template);
	}


    public function verify_otp_req()
    {
        if(!$this->session->userdata('otp_req')){
            return redirect(base_url('login'));
        }
        $this->session->unset_userdata('otp_req_verify');
        if($_POST){
            $otp = trim($_POST['one']).trim($_POST['two']).trim($_POST['three']).trim($_POST['four']);
            $req_obj = $this->session->userdata('otp_req');
            $req_obj->otp=$otp;

            $req_res = $this->nodeserverapi('verify_register','POST',$req_obj);
            if(!$req_res->status){
                $this->session->set_flashdata('message', array('message' => $req_res->message, 'class' => 'danger'));
                return redirect($this->agent->referrer());
            }
            $this->session->set_userdata('otp_req_verify', $req_res->data);
            return redirect(base_url('user_name_password'));
        }
    }

    
    public function user_name_password()
	{
        if(!$this->session->userdata('otp_req_verify')){
            return redirect(base_url('login'));
        }
        if($_POST){
            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required');
            $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required');
            if ($this->form_validation->run() == FALSE)
            {
                $this->session->set_flashdata('message', array('message' => validation_errors(), 'class' => 'danger'));
                return redirect($this->agent->referrer());
            }
            $req_obj = $this->session->userdata('otp_req_verify');
            $req_obj->name=$this->input->post('name');
            $req_obj->password=$this->input->post('password');
            $req_obj->confirm_password=$this->input->post('confirm_password');
            $req_res = $this->nodeserverapi('make_register_with_token','POST',$req_obj);
            if(!$req_res->status){
                $this->session->set_flashdata('message', array('message' => $req_res->message, 'class' => 'danger'));
                return redirect($this->agent->referrer());
            }
            $this->loggedInSession($req_res->data,$req_res->token);
            return redirect(base_url(''));
        }
        $template['otp_req_verify_obj'] = $this->session->userdata('otp_req_verify');
		$template['page'] = CUSTOMER_VIEW.'/auth/user_name_password';
		$template['page_title'] = "Shaktipeethdigital Signup Verified";
		$this->load->view( CUSTOMER_VIEW.'/auth/auth_template', $template);
	}


    private function loggedInSession($data,$token)
    {
        if(!empty($data)){
            $this->session->unset_userdata('otp_req_verify');
            $this->session->unset_userdata('otp_req');

            $this->session->set_userdata('sh_customer_loggedIn',true);
            $this->session->set_userdata('sh_customer_IP',sh_get_client_ip());
            $this->session->set_userdata('sh_customer_data',$data);
            $this->session->set_userdata('sh_customer_token',$token);
        }
    }

    public function destroy_session_user()
    {
        $this->session->sess_destroy();
        redirect(base_url('home'));
    }

}
