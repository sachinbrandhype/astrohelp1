<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct() {
		parent::__construct();
		date_default_timezone_set("Asia/Kolkata");
		
		$this->load->helper(array('form'));
		
		$this->load->model('login_model');
		$this->load->model('user_model');
		
		
		
		if($this->session->userdata('logged_in')) { 
			redirect(base_url().'dashboard');
		}
 	}
	
	public function index(){

	
		$template['page_title'] = "Login";
		if(isset($_POST)) {
			$this->load->library('form_validation');
			
			
			$this->form_validation->set_rules('username', 'Username', 'trim|required');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|callback_check_database');
			
			                  
			if($this->form_validation->run() == TRUE) {
				redirect(base_url().'dashboard');
			}
			
			
		}
		
		$this->load->view('Templates/header', $template);
		$this->load->view('Login/login_form');
		$this->load->view('Templates/footer');
		
	}
	
	function check_database($password) {
		$username = $this->input->post('username');
		$otp = $this->input->post('otp');
		$result = $this->login_model->login($username, md5($password));
		
	
		if($result) {
			$sess_array = array();
			foreach($result as $row) {
			  $sess_array = array(
			    'id' => $row->id,
			    'username' => $row->username,
			    'name' => $row->fname.' '.$row->lname,
			    'user_type'=> $row->user_type,
			    'profile_pic'=> $row->profile_pic,
			    'designation'=> $row->designation,
			    'created_user' =>$row->created_user
			    
			     );
			  $this->session->set_userdata('logged_in',$sess_array);
			  $this->session->set_userdata('admin',1);
			  $this->session->set_userdata('role_id',$row->user_type);
			   $this->session->set_userdata('id',$row->id);
			 // $this->session->set_userdata('user','$user->id');
		    }
		    return TRUE;
		}
		else {
			$this->form_validation->set_message('check_database', 'Invalid username or password');
			return false;
		}
		
		
	}
	public function check_login_ajax(){
		
		$email = $_POST['email'];
		$password = $_POST['password'];
		$otp = $_POST['otp'];
		$result = $this->login_model->check_login_otp($email,$otp);
		if($result) {
			$res = $this->login_model->login($email, md5($password));
			if($res) {
				
			   $dd['otp_status'] = 0;
 			$result = $this->user_model->update_user_by_email($dd, $email);
				echo 1;
			} else {
				echo 2;
			}
			
		} else {
			echo 3;
		}
		
	}
	function forgot_password(){
		$template['page_title'] = "Forgot";
		if($_POST) {
			//echo "fd";die;
			//print_r($_POST);die;
			$result = $this->login_model->check_email($_POST['email']);
			//print_r($result);die;
			if($result){
				$subject = "Forgot Password"; 
				$idd =	urlencode(base64_encode($result[0]->id));
				$data['link'] = base_url().'login/reset_password/'.$idd;
				$msg =  $this->load->view('email/forgot_template',$data,true);
				//$msg='ABC';
				//print_r($msg);die;
				$this->send_email_post($_POST['email'],$subject,$msg);
				$this->session->set_flashdata('message', array('message' => 'Please check your email and reset password!','class' => 'success'));
				redirect(base_url().'login');
				
			} else {
				$this->session->set_flashdata('message', array('message' => 'Invalid Email','class' => 'danger'));
			}
			redirect(base_url().'login/forgot_password');
		}
		$this->load->view('Templates/header', $template);
		$this->load->view('Login/forgot_form');
		$this->load->view('Templates/footer');
	}
	function reset_password(){
		
		$id = $this->uri->segment(3);
		$idd = base64_decode(urldecode($id)); 
		$template['page_title'] = "Reset Password";
		if($_POST) {
			$data = $_POST;
			unset($data['submit']);
			
			if($data['password'] == $data['con_password']) {
			$d['password'] = md5($data['password']);
			$result = $this->user_model->update_user_app($d, $idd);
			$this->session->set_flashdata('message', array('message' => 'Password Changed  Successfully','class' => 'success'));
			redirect(base_url());
			} else {
			
			$this->session->set_flashdata('message', array('message' => 'Password not match.','class' => 'danger'));
			redirect(base_url().'login/reset_password/'.$id);
			   }
			
			
		}
		$this->load->view('Templates/header', $template);
		$this->load->view('Login/reset_form');
		$this->load->view('Templates/footer');
	}
	public function send_otp_by_email(){
		$email = $_POST['email'];
		$result = $this->login_model->check_email_for_login($email);
		$otp = rand(1111,9999);
		if($result) {
			$subject = "Login Otp";
			$msg = "One time OTP for Login. OTP =".$otp;
			
			$dd['otp'] = $otp;
			$dd['otp_status'] = 1;
 			$result = $this->user_model->update_user_by_email($dd, $email);
			$this->send_email_post($email,$subject,$msg);
			echo 1;
			
		} else {
			echo 2;
		}
	}
	public function send_email_post($email,$subject,$message)
    {
        $this->CI = get_instance();
//echo "gfd";die;
        $this->CI->load->helper('string');
		
        $this->CI->load->library('My_PHPMailer');
        $subject = $subject;
        $body= $message;
        $mail = new PHPMailer;
        $mail->isSMTP();  
        $mail->Host = 'smtp.gmail.com'; //'md-70.webhostbox.net';
        $mail->SMTPAuth = true;
        $mail->Username = 'absolutes155@gmail.com';//'form41app@gmail.com'; //'mail@appsgenic.com';
         $mail->Password = 'appslure@123';
        $mail->SMTPSecure = 'tls';
       // $mail->Port =587;
        $mail->From = 'absolutes155@gmail.com';
        $mail->FromName = 'Ledger';
        $mail->addAddress($email, 'Ledger');
        $mail->WordWrap = 500;
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;
		
        if(!$mail->send())
        {
			return 0;
            echo 'Message could not be sent.';
				echo 'Mailer Error: ' . $mail->ErrorInfo;die;
        }
        else
        {
			return 1;
           echo 'Message  sent.';
				
        } 
        
        
    }
}
