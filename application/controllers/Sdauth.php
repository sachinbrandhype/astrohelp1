<?php

header("Access-Control-Allow-Origin: *"); 
header('Access-Control-Allow-Credentials: true'); 
header('Access-Control-Max-Age: 86400');  



// defined('BASEPATH') OR exit('No direct script access allowed');

class Sdauth extends CI_Controller {

	function __construct () {
		parent::__construct();
		$this->load->library('encryption');
		$this->load->library('pagination');
		$this->load->helper('url');
		$this->load->library('user_agent');
	}

	public function login()
	{
		$data = $_POST;
		$req_res = $this->nodeserverapi('login_with_password','POST',$data);
		if(@$req_res->status != 1){
			echo 0;
        } else {
			$this->loggedInSession($req_res->data);
			$this->session->set_flashdata('title', array('message' => "", 'class' => 'danger'));
			$this->session->set_flashdata('message', array('message' => "Welcome! ".ucfirst($req_res->data->name)." Login successfully", 'class' => 'success'));
			echo 1;
		}
	}

	public function nodeserverapi($end_point='',$method='POST',$data=[])
    {
    	return json_decode($this->applib->node_api_curl($end_point,$method,$data));
    }

    private function loggedInSession($data)
    { 
        if(!empty($data)){
            
            $this->session->set_userdata('user_id',$data->id);
            $this->session->set_userdata('user_data',$data);
            
        }
    }


    public function registration()
    {
    	$data = $_POST;
    	$data['confirm_password'] = $_POST['password'];
		$req_res = $this->nodeserverapi('register_user_otp','POST',$data);
		if(@$req_res->status != 1){
			echo 123;
        } else {
			$otp = $req_res->data->otp;
			$id = $req_res->data->id;
			$token_create = $this->encrypt_decrypt('encrypt',$otp.'|'.$id);
			$response = array("status"=>true,"token"=>$token_create,"otp"=>$otp);
			echo json_encode($response);
		}
    }

    function encrypt_decrypt($action, $string)
    {
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $secret_key = 'SECRET_KEY';
        $secret_iv = 'SECRET_IV';
        $key = hash('sha256', $secret_key);
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        if($action == 'encrypt')
        {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        }
        else if( $action == 'decrypt' )
        {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }
        return $output;
    }

    public function Otpverify()
    {
    	if ($_POST) 
		{
			$otp = $_POST['otp'];
			$_token = $_POST['_token'];
			$get_original_otp = $this->encrypt_decrypt('decrypt',$_token);
			if ($get_original_otp) 
			{
				$e = explode('|', $get_original_otp);
				$otp_c = $e[0];
				if ($otp_c == $otp) 
				{
					$id = $e[1];
					$data['id'] = $id;
					$data['otp'] = $otp;
					$req_res = $this->nodeserverapi('verify_register_user','POST',$data);
					if(@$req_res->status != 1){
						echo 2;
					}
					else
					{
						$this->loggedInSession($req_res->data);
						$this->session->set_flashdata('title', array('message' => "", 'class' => 'danger'));
						$this->session->set_flashdata('message', array('message' => "Welcome! ".ucfirst($req_res->data->name)." your registration successfully", 'class' => 'success'));
						echo 3;
					}
				}
				else
				{
					echo 1;
				}
			}
			else
			{
				echo 0;
			}
			
		}
		else
		{
			echo 0;
			
		}
    }

    public function ResendOtp()
    {
    	if ($_POST) 
		{
			$_token = $_POST['_token'];
			$get_original_otp = $this->encrypt_decrypt('decrypt',$_token);
			if ($get_original_otp) 
			{
				$e = explode('|', $get_original_otp);
				$data['otp'] = $e[0];
				$data['id'] = $e[1];
				
				$req_res = $this->nodeserverapi('resend_otp_register','POST',$data);
				if(@$req_res->status != 1){
				
					echo 0;
				}
				else
				{
					echo 1;
				}
			}
			else
			{
				echo 0;
			}
			
		}
		else
		{
			echo 0;
			
		}
    }

    public function forget()
    {
    	if ($_POST) 
		{
			$data['phone'] = $_POST['email'];
			$req_res = $this->nodeserverapi('forgot_otp','POST',$data);
			if(@$req_res->status != 1){
				echo 0;
			}
			else
			{
				$otp = $req_res->data->otp;
				$id = $req_res->data->id;
				$phone = $req_res->data->phone;
				$token_create = $this->encrypt_decrypt('encrypt',$otp.'|'.$id.'|'.$phone);
				$response = array("status"=>true,"token"=>$token_create,"otp"=>$otp);
				echo json_encode($response);
			}
		}
		else
		{
				echo 0;
			
		}
    }

    public function resendOtppwd($value='')
    {
    	if ($_POST) 
		{
			$_token = $_POST['_token'];
			$get_original_otp = $this->encrypt_decrypt('decrypt',$_token);
			if ($get_original_otp) 
			{
				$e = explode('|', $get_original_otp);
				$data['otp'] = $e[0];
				$data['id'] = $e[1];
				
				$req_res = $this->nodeserverapi('resend_otp_register','POST',$data);
				if(@$req_res->status != 1){
				
					echo 0;
				}
				else
				{
					$response = array("status"=>true,"token"=>$_token);
					echo json_encode($response);
				}
			}
			else
			{
				echo 0;
			}
			
		}
		else
		{
			echo 0;
			
		}
    }


    public function change_password()
    {
    	if ($_POST) 
		{
			$_token = $_POST['_token'];
			$get_original_otp = $this->encrypt_decrypt('decrypt',$_token);
			if ($get_original_otp) 
			{
				$data['password'] = $_POST['password'];
				$data['confirm_password'] = $_POST['password'];
				$e = explode('|', $get_original_otp);
				$data['otp'] = $e[0];
				$data['phone'] = $e[2];
				$data['id'] = $e[1];
				$req_res = $this->nodeserverapi('forgot_change_password','POST',$data);
				if(@$req_res->status != 1){
					echo 0;
				}
				else
				{
					$this->session->set_flashdata('title', array('message' => "", 'class' => 'danger'));
					$this->session->set_flashdata('message', array('message' => "Hi, ".ucfirst($req_res->data->name)." password change successfully!", 'class' => 'success'));
					echo 1;
				}
			}
			else
			{
				echo 0;
			}
		}
		else
		{
			echo 0;
			
		}
    }

    public function Otpverifypwd()
    {
    	if ($_POST) 
		{
			$otp = $_POST['otp'];
			$_token = $_POST['_token'];
			$get_original_otp = $this->encrypt_decrypt('decrypt',$_token);
			if ($get_original_otp) 
			{
				$e = explode('|', $get_original_otp);
				$otp_c = $e[0];
				if ($otp_c == $otp) 
				{
					echo 1;
				}
				else
				{
					echo 0;
				}
			}
			else
			{
				echo 0;
			}
			
		}
		else
		{
			echo 0;
			
		}
    }


    public function GetAstrologer()
    {
    	$response = array("status"=>false);
    	$get_online_astrologer = $this->db->query("SELECT * FROM `astrologers` WHERE `status` = '1' AND `online_status` = '1' AND `approved`='1'")->result();
    	if (count($get_online_astrologer) > 0) 
    	{
    		shuffle($get_online_astrologer);
    		$response = array("status"=>true,"list"=>$get_online_astrologer);
    	}
    	echo json_encode($response);

    }

    public function GetAstrologer_specialty()
    {
    	$specialty = '';
    	$astrid = $_POST['id'];
    	$get_specialty = $this->db->get_where("skills",array("user_id"=>$astrid,"type"=>1))->result();
    	if (count($get_specialty)) 
    	{
    		$a = array();
    		foreach ($get_specialty as $keys) 
			{
				$get_name = $this->db->get_where("master_specialization",array("id"=>$keys->speciality_id))->row();
				if ($get_name) 
				{
					array_push($a, ucfirst($get_name->name));
					// $skills[] = array("skill_id"=>$keys->speciality_id,
								  // "skill_name"=>$get_name->name);
				}
			}

			if (!empty($a)) 
			{
				$specialty = implode(', ', $a);
			}
    	}
    	echo $specialty;
    }


    public function GetAstrologeravail()
    {
    	$id = $_POST['id'];
    	//schedule_date = '$today_date' AND
    	$get_booking_ = $this->db->query("SELECT * FROM `bookings` WHERE  `assign_id` = '".$id."' AND `type` IN ('1','2','3') AND `booking_type`='2' AND `status` IN (0,1,6)  LIMIT 1");
		if ($get_booking_->num_rows() > 0) 
		{
			echo 1;
		}
		else
		{
			$astrologer_details = $this->db->query("SELECT * FROM `astrologers` WHERE `status` = '1' AND `online_status` = '1' AND `approved`='1' AND `id`='".$id."'")->row();	
			if ($astrologer_details) 
			{
				// phone
				$audio_status = '';
				if ($astrologer_details->audio_status == 1) 
				{
					$audio_status = 1;
				}

				$chat_status = '';
				if ($astrologer_details->chat_status == 1) 
				{
					$chat_status = 1;
				}

				$video_status = '';
				if ($astrologer_details->video_status == 1) 
				{
					$video_status = 1;
				}

				if ($audio_status != '' || $chat_status != '' || $video_status != '') 
				{
					echo 2;
				}
				else
				{
					echo 0;
				}
			}
			else
			{
				echo 0;	
			}
			
		}
    }

    public function GetUserdetails()
    {
    	$user = array("status"=>false);
    	$user_id = $_SESSION['user_id'];
    	$get_user = $this->db->get_where("user",array("id"=>$user_id))->row();
    	if ($get_user) 
    	{
    		$user= array("status"=>true,"user_details"=>$get_user);
    	}
    	echo json_encode($user);

    }


    public function sendrequest()
    {
    	if (isset($_SESSION['user_id'])) 
    	{
    		$user_id = $_SESSION['user_id'];
	    	$astrologer_id = $this->uri->segment(3);
	    	$money = $this->uri->segment(4);
	    	$type = $this->uri->segment(5);
	    	$get_user_data = $this->db->get_where("user", array("id" => $user_id))->row();
	    	$check_member = $this->db->query("select * from members where user_id  = $user_id")->row();
	    	if (empty($check_member)) 
	    	{
				$array11 = array(
						"user_id"=>$user_id,
					   "type"=>"host",
					   "name"=>$get_user_data->name,
					   "email"=>$get_user_data->email,
					   "dob"=>$get_user_data->dob,
					   "tob"=>$get_user_data->birth_time,
					   "gender"=>$get_user_data->gender,
					   "pob"=>$get_user_data->place_of_birth,
					   "is_default"=>1,
					   "status"=>1,
					   "created_at"=>date('Y-m-d H:i:s'));
				$insert_id = $this->db->insert("members",$array11);
				$user_insert_id = $this->db->insert_id();

				$array = array("user_id"=>$user_id,
	    				   "astrologer_id"=>$astrologer_id,
	    				   "price_per_mint"=>$money,
	    				   "member_id"=>$user_insert_id,
	    				   "type"=>$type,
	    				   "created_at"=>date('Y-m-d H:i:s'));
			    	$this->db->insert("booking_request",$array);
			    	$id = $this->db->insert_id();
			    	if ($id > 0) 
			    	{
			    		$reqeust_array = array("requestid"=>$id,
			    							   "is_request"=>1);
			    		$this->session->set_userdata($reqeust_array);
			    		redirect($_SERVER['HTTP_REFERER']);
		    		}



	    	}
	    	else{

	    		$array = array("user_id"=>$user_id,
	    				   "astrologer_id"=>$astrologer_id,
	    				   "price_per_mint"=>$money,
	    				   "member_id"=>$check_member->id,
	    				   "type"=>$type,
	    				   "created_at"=>date('Y-m-d H:i:s'));
		    	$this->db->insert("booking_request",$array);
		    	$id = $this->db->insert_id();
		    	if ($id > 0) 
		    	{
		    		$reqeust_array = array("requestid"=>$id,
		    							   "is_request"=>1);
		    		$this->session->set_userdata($reqeust_array);
		    		redirect($_SERVER['HTTP_REFERER']);
	    		}

	    	}
	    	
	    }
    	else
    	{
    		$this->session->set_flashdata('message', array('message' => 'You have to login first for booking','class' => 'success')); 
            redirect($_SERVER['HTTP_REFERER']);
    	}
    	

	}

	public function unsetsession()
    {
    	$this->session->unset_userdata('requestid');
    	$this->session->unset_userdata('is_request');

    }


    public function checkrequest()
    {
    	$response = array("status"=>true,"flag"=>1);	
    	if (isset($_SESSION['is_request'])) 
    	{
    		if ($_SESSION['is_request'] == 1) 
    		{
    			$check_request_status = $this->db->get_where("booking_request",array("id"=>$_SESSION['requestid']))->row();
    			if ($check_request_status) 
    			{
    				if ($check_request_status->status == 0) 
    				{
    					$title = '';
    					if ($check_request_status->type == 1) 
    					{
    						$title = 'Your Video Consultation request in waiting!';
    					}
    					elseif ($check_request_status->type == 2) 
    					{
    						$title = 'Your Audio Consultation request in waiting!';
    					}
    					elseif ($check_request_status->type == 3) 
    					{
    						$title = 'Your Chat Consultation request in waiting!';
    					}
    					$response = array("status"=>true,"flag"=>2,"added_on"=>$check_request_status->created_at,"title"=>$title);
    				}
    				else
			    	{
			    		$this->unsetsession();
			    	}
    			}
    			else
		    	{
		    		$this->unsetsession();
		    	}
    		}
    		else
	    	{
	    		$this->unsetsession();
	    	}
    	}
    	else
    	{
    		$this->unsetsession();
    	}
    	echo json_encode($response);
    }


    public function chatwindow()
    {
    	if (isset($_SESSION['user_id'])) 
		{
			// print_r("expression"); die;
		    $template['page'] = 'home/chat';
			$template['page_title'] = "Astrokul";
			$this->load->view('template', $template);
		}
		else
		{
			redirect(base_url());
		}
    	
    }

    public function save_file(){
		$target_path = "assets/chat_file/";

           if(is_array($_FILES))
           {
            $imagename = basename($_FILES["file"]["name"]);
               $extension = substr(strrchr($_FILES['file']['name'], '.'), 1);
               $actual_image_name = 'chat_file'.time().".".$extension;
				move_uploaded_file($_FILES["file"]["tmp_name"],$target_path.$actual_image_name);
               if(!empty($actual_image_name) && !empty($extension))
               {
                $aadhar_front_image_ = $actual_image_name;
               }
			}
			echo base_url('assets/chat_file/')."/".$aadhar_front_image_;
	}


	public function checkbookingend()
	{
		$check = $this->db->get_where("bookings",array("id"=>$_POST['id']))->row();
		if ($check) 
		{
			if ($check->status == 0) 
			{
				$this->session->set_flashdata('message', array('message' => 'You Consultation Ended!','class' => 'success'));
				echo 1;
			}
			else
			{
				echo 0;
			}	
		}
		else
		{
			echo 0;
		}
	}



	public function filter_data()
	{
		$output="";
		if ($_POST) 
    	{
    		
    				// print_r($_POST['search']); die;
    				if (isset($_POST['search']) ){
    					$data['search']= $_POST['search'];
    					$data['mode']= "chat";
    					// print_r($data); die;
    					$req_search = $this->nodeserverapi('search_astrologers','POST',$data);

    				}
    				else{
    					$data['language'] = $_POST['language'];
						$data['speciality'] = $_POST['speciality'];
						$data['service'] = $_POST['service'];
						$data['gender'] = $_POST['gender'];
						$data['country'] = $_POST['country'];
						$data['mode'] = $_POST['mode'];
						$data['rating'] = "";
						$data['online_ofline'] = "";
						$data['price_min'] = "";
						$data['price_max'] = "";
						$data['sort_by'] = $_POST['sort_by'];
						//$search_data = json_encode($data, JSON_FORCE_OBJECT);
	    				// $search_data = json_encode($data); 
	    				$req_search = $this->nodeserverapi('search_astro_by_filter','POST',$data);
    				}
					
    				// print_r($req_search->data); die;
    				if (!empty($req_search->data)) 
    				{
    					
    				
    					foreach ($req_search->data as $key) {
    						$a_name = $key->name;
    						$experience = $key->experience;
    						$price_per_mint_chat = $key->price_per_mint_chat;
    						$video = base_url("assets/img/video-icon.png");
    						$chat = base_url("assets/img/chat-icon.png");
    						$call = base_url("assets/img/call-icon.png");
    						$url = base_url('home/astrologer_profile/'.$key->id);

    						$languages =  preg_replace('/\s+?(\S+)?$/', '', substr($key->languages, 0, 12))."..";
    						$experties_string =  substr($key->experties_string, 0, 20)."..";  

    						$a_image= BASE_URL_IMAGE.'astrologers/'.$key->image;
    						$a_profile_url = base_url('home/astrologer_profile/'.$key->id);
 
							if ($key->online_status == 1) {
							 
							 $online_status = '<p class="online-a">&nbsp;<i class="fa fa-circle" aria-hidden="true"></i>&nbsp;Online</p>';
							 
							}
							if ($key->online_status == 2) {
							
							 $online_status =   '<p class="busy-a">&nbsp;<i class="fa fa-circle" aria-hidden="true"></i>&nbsp;Busy <br>
							           <span class="wait-time">Wait time ~ <?php echo $key->wait_time; ?>min</span></p>';
							
							}
							if (empty($key->online_status)) {

							   $online_status = '<p class="offline-a">&nbsp;<i class="fa fa-circle" aria-hidden="true"></i>&nbsp;Offline</p>';

							}

							 $r = round($key->rating->average,1);
							if ($r >= 5) 
							{ 
							$reting = 	'<div class="rating">
								  <i class="fas fa-star filled"></i>
								  <i class="fas fa-star filled"></i>
								  <i class="fas fa-star filled"></i>
								  <i class="fas fa-star filled"></i>
								  <i class="fas fa-star filled"></i>
								  <span class="d-inline-block average-rating">('.$r.'/5)</span>
								</div>';
							}
							elseif ($r >= 4) 
							{
								$reting = '<div class="rating">
								  <i class="fas fa-star filled"></i>
								  <i class="fas fa-star filled"></i>
								  <i class="fas fa-star filled"></i>
								  <i class="fas fa-star filled"></i>
								  <i class="fas fa-star "></i>
								  <span class="d-inline-block average-rating">('.$r.'/5)</span>
								</div>';
							}
							elseif ($r >= 3) 
							{
								
								$reting ='<div class="rating">
								  <i class="fas fa-star filled"></i>
								  <i class="fas fa-star filled"></i>
								  <i class="fas fa-star filled"></i>
								  <i class="fas fa-star "></i>
								  <i class="fas fa-star "></i>
								  <span class="d-inline-block average-rating">('.$r.'/5)</span>
								</div>';
								
							}
							elseif ($r >= 2) 
								  {
								 
								$reting ='<div class="rating">
								  <i class="fas fa-star filled"></i>
								  <i class="fas fa-star filled"></i>
								  <i class="fas fa-star "></i>
								  <i class="fas fa-star "></i>
								  <i class="fas fa-star "></i>
								  <span class="d-inline-block average-rating">('.$r.'/5)</span>
								</div>';
								
								  }
								  elseif ($r >= 1) 
								  {
									$reting ='<div class="rating">
									  <i class="fas fa-star filled"></i>
									  <i class="fas fa-star "></i>
									  <i class="fas fa-star "></i>
									  <i class="fas fa-star "></i>
									  <i class="fas fa-star "></i>
									  <span class="d-inline-block average-rating">('.$r.'/5)</span>
									</div>';
								  }
								  elseif (empty($r)) 
								  {
								 
								$reting ='<div class="rating">
								  <i class="fas fa-star "></i>
								  <i class="fas fa-star "></i>
								  <i class="fas fa-star "></i>
								  <i class="fas fa-star "></i>
								  <i class="fas fa-star "></i>
								  <span class="d-inline-block average-rating">(<?php echo "0/5"; ?>)</span>
								</div>';
									}	          
										                
    						


                              $output .='
										 	<div class="col-md-3 astro-list">
										   <div class="card1">
										      <div class="card-header1">
										         <div class="media">
										            <div class="media-left">
										               <img src='.$a_image.'  style="border-radius: 50%;" class="media-object astro-img">
										            </div>
										            <div class="media-body">
										               <a href='.$a_profile_url.'>
										                  <h4 class="media-heading astro-name">'.$a_name.'</h4>
										               </a>
										               <p class="astro-rating">

										               '.$reting.'
										               </p>
										               '.$online_status.'
										             
										            </div>
										         </div>
										      </div>
										      <div class="card-body1">
										         <div class="row">
										           
										          <div class="col-md-6 col-6">
												   <ul class="astro-info">
												      <li><i class="fa fa-graduation-cap" aria-hidden="true"></i>&nbsp;&nbsp;'.$experience.' Years</li>
												      <li><i class="fa fa-language" aria-hidden="true"></i>&nbsp;&nbsp;
												      '.$languages.'
												      </li>
												      <li><i class="fas fa-shield-alt"></i>&nbsp;&nbsp;'.$experties_string.'</li>
												      <li><i class="fas fa-rupee-sign"></i>&nbsp;&nbsp;'.$price_per_mint_chat.'/Min</li>
												   </ul>
												</div>
												<div class="col-md-6 col-6 text-right video-call-btn">
												   <a href="#" data-toggle="modal" data-target="#download-popup"><img src="'.$call.'" class="img-width"></a>  
												   <a href="#" data-toggle="modal" data-target="#download-popup"><img src="'.$video.'" class="img-width"></a> 
												   <a href='.$url.'><img src="'.$chat.'" class="img-width"></a>
												</div>

										         </div>
										      </div>
										   </div>
										   </div>
										 
										';
    						}	
    						}
    						else{
    							echo "No sufficient data available";
    						}
    				
    					  echo $output;
    			
    	}
	}

	public function filter_astrologers($type='')
    {
		$user_id = $this->session->userdata('user_id');
		if(!$user_id){
			$user_id = 0;
		}
		if($type=='chat'){
			$data = array(
				'mode' => "chat",
				'user_id' => $user_id,
			  
			);
		}elseif($type =='audio'){
			$data = array(
				'mode' => "audio",
				'user_id' => $user_id,
			  
			);
		}else{

			$data = array(
				'mode' => "chat",
				'user_id' => $user_id,
			  
			);
		}

    	
    	
                 $req_res = $this->applib->fetch_astrologers($data);
                  if(@$req_res->status != 1){
                  
                    echo 0; die;
                  }
                  else
                  {
                  	$template['astro_data'] = $req_res->data;
                  }

				$data = array('user_id' => 0);
				$req_res1 = $this->nodeserverapi('fetch_astrologer_filters','POST',$data);
				  if(@$req_res1->status != 1){
                  
                    echo 0; die;
                  }
                  else
                  {
                  	$template['astro_sort'] = $req_res1;
                  }

				// print_r($template); die;
                


    	$template['page'] = 'home/astrologer_list_new';
		$template['page_title'] = "Astrohelp24";
        $this->load->view('template', $template);


    }


	public function filter_astrologers_new()
    {
    	$sorting = $this->input->post("sorting");
    	$search_keyword = $this->input->post("search_keyword");
    	if ($this->uri->segment(3))
    	{
    		$expertiseastro = array();
    		array_push($expertiseastro, $this->uri->segment(3));	
    	}
    	else
    	{
    		$expertiseastro = $this->input->post("expertiseastro");
    	}
    	$language = $this->input->post("language");
    	$rating = $this->input->post("rating");
    	$where = '';
    	if ($search_keyword) 
    	{
    		$where .= "AND `name` LIKE '%$search_keyword%' ";
    	}
    	if ($language) 
    	{
    		$lang = implode('|', $language);
    		$where .= ' AND CONCAT("|", `languages`, "|") REGEXP "'.$lang.'"';
    	}
    	$sortby = '';
    	$order = '';
    	if($sorting=="price")
		{
			$sortby								=	"ORDER BY `price_per_mint_chat`";
			$order								=	"ASC";
		}
		elseif($sorting=="experience")
		{
			$sortby								=	"ORDER BY `experience`";
			$order								=	"DESC";
		}
		$top_astrologer = array();
    	$get_online_astrologer = $this->db->query("SELECT * FROM `astrologers` WHERE `status` = '1' AND `approved`='1' $where ".$sortby.' '.$order)->result();
    	if (count($get_online_astrologer) > 0) 
    	{
    		foreach ($get_online_astrologer as $key) 
    		{
    			$expertiseflag_init = 0;
    			$expertiseflag = 0;
    				
    			if (!empty($expertiseastro)) 
    			{
    				$expertiseflag_init = 1;
    				$get_all_expertise = $this->db->query("SELECT `speciality_id` FROM `skills` WHERE `type`='2' AND `user_id`='$key->id'")->result();
	    			if (count($get_all_expertise) > 0) 
	    			{
	    				$asexid = array();
	    				foreach ($get_all_expertise as $ex) 
	    				{
	    					array_push($asexid, $ex->speciality_id);
	    				}
	    				if(array_intersect($asexid, $expertiseastro)) {
						   	$expertiseflag = 2;
						}
	    			}		
    			}
    			// echo $expertiseflag;
    			$rating_flag_init = 0;
    			if (!empty($rating)) 
    			{
    				$rating_flag = 1;
    				if (in_array('all', $rating)) 
    				{
    					$rating_flag = 0;
    				}
    				else
    				{
    					$get_all_ratings = $this->db->query("SELECT AVG(rate) AS A FROM `reviews` WHERE `type` = '2' AND `type_id`='$key->id'")->row();
		    			if ($get_all_ratings) 
		    			{
		    				if (in_array('3', $rating)) 
		    				{
		    					if ($get_all_ratings->A >= 3) 
		    					{
		    						$rating_flag = 2;
		    					}
		    					else
		    					{
		    						$rating_flag = 0;
		    					}
		    				}
		    				elseif (in_array('4', $rating)) 
		    				{
		    					if ($get_all_ratings->A >= 4) 
		    					{
		    						$rating_flag = 2;
		    					}
		    					else
		    					{
		    						$rating_flag = 0;
		    					}
		    				}
		    				else
		    				{
		    					$rating_flag = 0;
		    				}
		    			}
    				}

    			}

    			if ($expertiseflag_init == 0 && $rating_flag_init == 0) 
    			{
    				array_push($top_astrologer, $key);
    			}
    			elseif ($expertiseflag_init == 1 && $rating_flag_init == 0) 
    			{
    				if ($expertiseflag == 2) 
    				{
    					array_push($top_astrologer, $key);
    				}
    			}
    			elseif ($expertiseflag_init == 0 && $rating_flag_init == 1) 
    			{
    				if ($rating_flag == 2) 
    				{
    					array_push($top_astrologer, $key);
    				}
    			}
    			elseif ($expertiseflag_init == 1 && $rating_flag_init == 1) 
    			{
    				if ($expertiseflag == 2) 
    				{
    					array_push($top_astrologer, $key);
    				}
					if ($rating_flag == 2) 
    				{
    					array_push($top_astrologer, $key);
    				}
    			}
    			else
    			{
    				array_push($top_astrologer, $key);
    			}
    		}
    	}

    	$template['astro'] = $top_astrologer;
    	$template['page'] = 'home/astrologer_list_filtered';
		$template['page_title'] = "Astrokul";
        $this->load->view('template', $template);


    }


	public function filter_astrologers_old()
    {
    	$sorting = $this->input->post("sorting");
    	$search_keyword = $this->input->post("search_keyword");
    	if ($this->uri->segment(3))
    	{
    		$expertiseastro = array();
    		array_push($expertiseastro, $this->uri->segment(3));	
    	}
    	else
    	{
    		$expertiseastro = $this->input->post("expertiseastro");
    	}
    	$language = $this->input->post("language");
    	$rating = $this->input->post("rating");
    	$where = '';
    	if ($search_keyword) 
    	{
    		$where .= "AND `name` LIKE '%$search_keyword%' ";
    	}
    	if ($language) 
    	{
    		$lang = implode('|', $language);
    		$where .= ' AND CONCAT("|", `languages`, "|") REGEXP "'.$lang.'"';
    	}
    	$sortby = '';
    	$order = '';
    	if($sorting=="price")
		{
			$sortby								=	"ORDER BY `price_per_mint_chat`";
			$order								=	"ASC";
		}
		elseif($sorting=="experience")
		{
			$sortby								=	"ORDER BY `experience`";
			$order								=	"DESC";
		}
		$top_astrologer = array();
    	$get_online_astrologer = $this->db->query("SELECT * FROM `astrologers` WHERE `status` = '1' AND `approved`='1' $where ".$sortby.' '.$order)->result();
    	if (count($get_online_astrologer) > 0) 
    	{
    		foreach ($get_online_astrologer as $key) 
    		{
    			$expertiseflag_init = 0;
    			$expertiseflag = 0;
    				
    			if (!empty($expertiseastro)) 
    			{
    				$expertiseflag_init = 1;
    				$get_all_expertise = $this->db->query("SELECT `speciality_id` FROM `skills` WHERE `type`='2' AND `user_id`='$key->id'")->result();
	    			if (count($get_all_expertise) > 0) 
	    			{
	    				$asexid = array();
	    				foreach ($get_all_expertise as $ex) 
	    				{
	    					array_push($asexid, $ex->speciality_id);
	    				}
	    				if(array_intersect($asexid, $expertiseastro)) {
						   	$expertiseflag = 2;
						}
	    			}		
    			}
    			// echo $expertiseflag;
    			$rating_flag_init = 0;
    			if (!empty($rating)) 
    			{
    				$rating_flag = 1;
    				if (in_array('all', $rating)) 
    				{
    					$rating_flag = 0;
    				}
    				else
    				{
    					$get_all_ratings = $this->db->query("SELECT AVG(rate) AS A FROM `reviews` WHERE `type` = '2' AND `type_id`='$key->id'")->row();
		    			if ($get_all_ratings) 
		    			{
		    				if (in_array('3', $rating)) 
		    				{
		    					if ($get_all_ratings->A >= 3) 
		    					{
		    						$rating_flag = 2;
		    					}
		    					else
		    					{
		    						$rating_flag = 0;
		    					}
		    				}
		    				elseif (in_array('4', $rating)) 
		    				{
		    					if ($get_all_ratings->A >= 4) 
		    					{
		    						$rating_flag = 2;
		    					}
		    					else
		    					{
		    						$rating_flag = 0;
		    					}
		    				}
		    				else
		    				{
		    					$rating_flag = 0;
		    				}
		    			}
    				}

    			}

    			if ($expertiseflag_init == 0 && $rating_flag_init == 0) 
    			{
    				array_push($top_astrologer, $key);
    			}
    			elseif ($expertiseflag_init == 1 && $rating_flag_init == 0) 
    			{
    				if ($expertiseflag == 2) 
    				{
    					array_push($top_astrologer, $key);
    				}
    			}
    			elseif ($expertiseflag_init == 0 && $rating_flag_init == 1) 
    			{
    				if ($rating_flag == 2) 
    				{
    					array_push($top_astrologer, $key);
    				}
    			}
    			elseif ($expertiseflag_init == 1 && $rating_flag_init == 1) 
    			{
    				if ($expertiseflag == 2) 
    				{
    					array_push($top_astrologer, $key);
    				}
					if ($rating_flag == 2) 
    				{
    					array_push($top_astrologer, $key);
    				}
    			}
    			else
    			{
    				array_push($top_astrologer, $key);
    			}
    		}
    	}

    	$template['astro'] = $top_astrologer;
    	$template['page'] = 'home/astrologer_list_filtered_old';
		$template['page_title'] = "Astrokul";
        $this->load->view('template', $template);


    }

    public function add_wallet()
    {
    	if (isset($_SESSION['user_id'])) 
		{
			if (isset($_POST['AmounT'])) 
			{
				if ($_POST['AmounT'] > 0) 
				{
					$get_user_details = $this->db->get_where("user",array("id"=>$_SESSION['user_id']))->row();
					if ($get_user_details) {
						$add_to_wallet = $_POST['AmounT'];
						$user_wallet = $get_user_details->wallet;
						$update_wallet = $get_user_details->wallet + $add_to_wallet;
						$this->db->where("id",$get_user_details->id);
						$this->db->update("user",array("wallet"=>$update_wallet));
						$array = array( "user_id"=>$get_user_details->id,
									"name"=>$get_user_details->name,
									"booking_id"=>0,
									"booking_txn_id"=>time(),
									"payment_mode"=>"other",
									"type"=>'credit',
									"txn_for"=>"wallet",
									"txn_name"=>"Wallet Recharge",
									"old_wallet"=>$user_wallet,
									"txn_amount"=>$add_to_wallet,
									"update_wallet"=>$update_wallet,
									"status"=>1,
									"is_refund"=>1,
									"txn_mode"=>'other',
									"bank_name"=>'',
									"bank_txn_id"=>'',
									"ifsc"=>'',
									"account"=>'',
									"created_at"=>date("Y-m-d H:i:s"),
									"updated_at"=>date("Y-m-d H:i:s"),
									"gst_perct"=>0,
									"gst_amount"=>0
									  );
						$this->db->insert("transactions",$array);
						$id = $this->db->insert_id();
						if ($id > 0) 
						{
							$this->session->set_flashdata('message', array('message' => "Add Wallet Done!", 'class' => 'success'));
							redirect(base_url('home/wallet'));
						}
						else
						{
							$this->session->set_flashdata('message', array('message' => "Something error happen please try later!", 'class' => 'success'));
							redirect($_SERVER['HTTP_REFERER']);
						}
					}
					else
					{
						redirect(base_url());
					}
				}
				else
				{
					redirect($_SERVER['HTTP_REFERER']);
				}
			}
			else
			{
				redirect($_SERVER['HTTP_REFERER']);
			}
		}
		else
		{
			redirect(base_url());
		}
    }



  public function recharge_wallet_invoice($booking_id)
  {
    // $booking_id = 97; 
    // print_r($booking_id); die;
    $get_details = $this->db->get_where("transactions", array("id" => $booking_id));
    if ($get_details->num_rows() > 0) {
      $get = $get_details->row();

      $user_detail = $this->db->query("SELECT * FROM user WHERE id = '$get->user_id'")->row();
    // echo $this->db->last_query(); die;
      // print_r($booking_detail); die;
      $get_Settings = $this->db->get_where("settings", array("id" => 1))->row();
      $pdf_data = array();
      $pdf_data['rechargeID'] = $booking_id;
      $pdf_data['invoice_number'] = $get->id;


      $pdf_data['available_wallet'] = $get->txn_amount - $get->gst_amount;
      $pdf_data['txn_amount'] = $get->txn_amount;
      $pdf_data['payment_mode'] = $get->payment_mode;
      $pdf_data['booking_txn_id'] = $get->booking_txn_id;
      $pdf_data['txn_name'] = $get->txn_name;
      $pdf_data['gst_perct'] = $get->gst_perct;
      $pdf_data['gst_amount'] = $get->gst_amount;
      $pdf_data['recharge_date'] = date('d/m/Y h:ia', strtotime($get->updated_at));

      $pdf_data['name'] = $user_detail->name;
      $pdf_data['phone'] = $user_detail->phone;
      $pdf_data['country'] = $user_detail->country;
      $pdf_data['address'] = $user_detail->address;
      $pdf_data['state'] = $user_detail->state;
      $pdf_data['city'] = $user_detail->city;
      $pdf_data['zip'] = $user_detail->zip;



 
      $htmlcode = $this->load->view('invoice/recharge_wallet_invoice', $pdf_data, TRUE);
     $ss =  $this->load->library('Pdf');
      // print_r($ss); die;
      $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);


      $pdf->setPrintHeader(false);
      $pdf->setPrintFooter(false);
      $pdf->SetCreator(PDF_CREATOR);
      $pdf->SetAuthor('Astrohelp24');
      $pdf->SetTitle('Invoice');
      $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
      $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
      $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
      $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
      $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
      $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
      $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
      $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
      if (@file_exists(dirname(_FILE_) . '/lang/eng.php')) {
        require_once(dirname(_FILE_) . '/lang/eng.php');
        $pdf->setLanguageArray($l);
      }
      $pdf->SetFont('dejavusans', '', 10);
      $pdf->AddPage();
      $htmlcode = $this->load->view('invoice/recharge_wallet_invoice', $pdf_data, TRUE);
      $pdf_data['order_number'] = time();
      $pdf->writeHTML($htmlcode, true, false, true, false, '');
      $newFile  = FCPATH . "/assets/booking_invoice/" . $pdf_data['order_number'] . '-recharge_wallet_invoice.pdf';
      ob_clean();
      $pdf->Output($newFile, 'I');
      $pdffname = $pdf_data['order_number'] . '-recharge_wallet_invoice.pdf';
      ob_end_clean();
      print_r($newFile); die;
      return $pdffname;

      if (isset($email)) {
      }
    } else {
      return false;
    }
  }
	
}
