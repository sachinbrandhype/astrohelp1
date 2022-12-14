<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/* New aliases. */
use PHPMailer\PHPMailer\OAuth;
use League\OAuth2\Client\Provider\Google; 
// Allow from any origin
if (isset($_SERVER['HTTP_ORIGIN'])) {
	header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
	header('Access-Control-Allow-Credentials: true');
	header('Access-Control-Max-Age: 86400');    // cache for 1 day
}

// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
	if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
		header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         
	if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
		header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
		exit(0);
}
class Ivrapi extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		// $this->load->model('Api_Model','w_m');
		$this->load->library('form_validation');
	}

	public function index()
	{
		// print_r($this->input->get_request_header('HTTP_X_API_KEY'));
	}

	private function fail_auth()
	{
		echo json_encode([
				'status'	=> 	'failed',
				'message'	=> 	'Unable to authenticate the request. It seems like the API key provided is not valid.' 
			]);
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

    public function create_ivr_token()
    {
    	$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://client.easygoivr.com/masterapi/gentoken',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_POSTFIELDS =>'{
		    
		}',
		  CURLOPT_HTTPHEADER => array(
		    'Authorization: Basic aW5mb0Bhc3Ryb2hlbHAyNC5jb206OGQwZmI1ODc5YmE2ODc4OWE5YmJhYjMxMWRhZmVmODY=',
		    'Content-Type: application/json',
		    'Cookie: ci_session=n0dsib4m6h1cqloksevnj7c44l3ljbjd'
		  ),
		));

		$response = curl_exec($curl);
		curl_close($curl);
		if ($response) 
        {
            $r = json_decode($response,TRUE);
            if (isset($r['status'])) 
            {
            	if ($r['status'] == 'success') 
            	{
            		$update_array = array("token"=>$r['API_TOKEN'],"token_expirytime"=>$r['expiry_time']);
            		$this->db->where("id",1);
            		$this->db->update("ivr_config",$update_array);
            	}
            }
        }
    }

    public function updatetoken()
    {
    	// $get_setting = $this->db->get_where("ivr_config",array("id"=>1))->row();
    	// $currenttime = time();
    	// $token_time = strtotime($get_setting->token_expirytime);
    	// $endtime = strtotime(date('Y-m-d H:i:s',strtotime("-10 seconds", $token_time)));
    	// if ($currenttime >= $endtime) 
    	// {
    		$this->create_ivr_token();
    	// }
    }

    public function makecallSD()
    {
		$this->create_ivr_token();
    	$data =json_decode(file_get_contents('php://input'), true);	
		if(isset($data) && !empty($data))
		{
			$res = array("status"=>false,"message"=>"sometjing error happen please try again!");
			$user_id = $data['user_id'];
			$astrologer_id = $data['astrologer_id'];
			$get_user = $this->db->get_where("user",array("id"=>$user_id))->row();
			if ($get_user) 
			{
				$get_astrologer = $this->db->get_where("astrologers",array("id"=>$astrologer_id))->row();
				if ($get_astrologer) 
				{
					$get_user = $this->db->get_where("user",array("id"=>$user_id))->row();
					$user_wallet = $get_user->wallet;
					if ($user_wallet >= $data['price_per_mint']) 
					{
						$astrologer_number = sprintf("%011d", (int)$get_astrologer->phone);//$this->refine($get_astrologer->phone);
						$user_number = sprintf("%011d", (int)$get_user->phone);//$this->refine($get_user->phone);
						// $length = 11;
						// echo "<br>".$string = substr(str_repeat(0, $length).$astrologer_number, - $length);
						// echo "<br>".$string2 = substr(str_repeat(0, $length).$user_number, - $length);

						$unique_id = $get_user->id.time().$get_astrologer->id;
						$get_setting = $this->db->get_where("ivr_config",array("id"=>1))->row();
						$did = $get_setting->did;
						$API_TOKEN = $get_setting->token;
						$a = json_encode(array("exten"=>$astrologer_number,'number'=>$get_user->phone,'did'=>'6882714','uniqueid'=>$unique_id));
						$curl = curl_init();
						curl_setopt_array($curl, array(
						  CURLOPT_URL => 'https://client.easygoivr.com/easygoapi/request/dial',
						  CURLOPT_RETURNTRANSFER => true,
						  CURLOPT_ENCODING => '',
						  CURLOPT_MAXREDIRS => 10,
						  CURLOPT_TIMEOUT => 0,
						  CURLOPT_FOLLOWLOCATION => true,
						  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
						  CURLOPT_CUSTOMREQUEST => 'POST',
						  CURLOPT_POSTFIELDS =>'{
						"exten":"'.$astrologer_number.'",
						"number":"'.$user_number.'",
						"did":"'.$did.'",
						"uniqueid":"'.$unique_id.'"
						}',
						  CURLOPT_HTTPHEADER => array(
						    'Content-Type: application/json',
						    'API_TOKEN: '.$API_TOKEN,
						    'Cookie: ci_session=6k6t275j5ueo2peim7m8nhcko971eg02'
						  ),
						));

						$response = curl_exec($curl);

						curl_close($curl);
						if ($response) 
						{	
							
							$a = json_decode($response,true);
							if (isset($a['status'])) 
							{
								if ($a['status'] == 'success') 
								{
									$get_user = $this->db->get_where("user",array("id"=>$user_id))->row();
									$user_wallet = $get_user->wallet;
									$how_much_minutes = 0;
									$price_lag = $user_wallet / $data['price_per_mint'];
									$how_much_minutes = floor($price_lag);

									$date = date('Y-m-d H:i:s');
									$schedule_date = date('Y-m-d');
									$schedule_time = date("H:i:s",strtotime($date));
									$array = array("orderID"=>"AST".time().$user_id.$astrologer_id,
												   "user_id"=>$user_id,
												   "type"=>intval($data['type']),
												   "booking_type"=>2,
												   "assign_id"=>$astrologer_id,
												   "user_name"=>$get_user->name,
												   "user_phone"=>$get_user->phone,
												   "user_email"=>$get_user->email,
												   "user_gender"=>$get_user->gender,
												   "user_dob"=>$get_user->dob,
												   "user_tob"=>$get_user->birth_time,
												   "user_pob"=>$get_user->place_of_birth,
												   "schedule_date"=>$schedule_date,
												   "schedule_time"=>$schedule_time,
												   "schedule_date_time"=>$date,
												   "total_minutes"=>$how_much_minutes,
												   "time_minutes"=>$how_much_minutes,
												   "total_seconds"=>0,
												   "payment_mode"=>'wallet',
												   "bridge_id"=>$unique_id,
												   "price_per_mint"=>$data['price_per_mint'],
												   "created_at"=>$dtime=date('Y-m-d H:i:s'),
												   "updated_at"=>$dtime,
												   "ivr_unique_id"=>$unique_id);
									$this->db->insert("bookings",$array);
									$id = $this->db->insert_id();
									if ($id > 0) 
									{
										$res = array("status"=>true,"message"=>"done");		
									}
								}
							}
						}
					}
					else
					{
						$res = array("status"=>false,"message"=>"not enough balance!");
					}
				}
			}
			echo json_encode($res);
		}
    }

    public function refine($number)
    {
    	$n = (int)$number;
    	return $n;
    }

    public function ivr_outgoing_response()
    {
    	$data1 = json_decode(file_get_contents('php://input'), true);
        $data2 = json_encode($data1);
        $this->load->helper('file');
        $date = date('Y-m-d');
        $time = date('h-i-s');
        $file_name_ = $date.' '.$time;
        $path = './ivr/'.$file_name_.'.txt';
        
		if ( ! write_file($path,$data2))
		{
	    }
		else
		{
		   $f = json_decode($data2,true);
		   if (isset($f['action'])) 
		   {
		   		$unique_id = $f['Linkedid'];
		   		if ($f['action'] == 'Ringing') 
		   		{
		   			
		   		}
		   		elseif ($f['action'] == 'ANSWER') 
		   		{
		   			$get_bookings = $this->db->get_where("bookings",array("status"=>0,"ivr_unique_id"=>$unique_id))->row();
		   			if ($get_bookings) 
		   			{
		   				$update_array = array("status"=>1,
						   						"is_confirmed"=>1,
		   									  "start_time"=>date('Y-m-d H:i:s'),
		   									  "is_chat_or_video_start"=>2);
		   				$this->db->where("id",$get_bookings->id);
		   				$this->db->update("bookings",$update_array);
		   			}
		   		}
		   		elseif ($f['action'] == 'Hangup') 
		   		{
		   			if ($f['disposition'] == 'ANSWER') 
		   			{
		   				$get_bookings = $this->db->get_where("bookings",array("status"=>1,"ivr_unique_id"=>$unique_id))->row();
			   			if ($get_bookings) 
			   			{
			   				$seconds = $f['durn'];
			   				if ($seconds > 0) 
			   				{
			   					$price_per_mint = $get_bookings->price_per_mint;
			   					$callingminutes = ceil($seconds / 60);
			   					// $one_sec_price = $price_per_mint / 60;
			   					// $total_price = $seconds * $one_sec_price;
			   					$total_price = $price_per_mint * $callingminutes;
			   					$total_price = number_format($total_price,2);
			   					
			   					$get_user_detail = $this->db->get_where("user",array("id"=>$get_bookings->user_id))->row();
			   					$checkwallethaveanycut = $this->db->get_where('transactions',array("user_id"=>$get_bookings->user_id,"booking_id"=>$get_bookings->id,"type"=>"debit"))->row();
			   					if ($checkwallethaveanycut) {
			   						//not do anything
			   					}
			   					else
			   					{
									   $txn_id=time();
									if ($total_price > 0) 
									{
										$user_wallet = $get_user_detail->wallet;
										$update_wallet = $get_user_detail->wallet - $total_price;
										if ($update_wallet < 0) 
										{
											$update_wallet = 0;
										}
										$this->db->where("id",$get_user_detail->id);
										$this->db->update("user",array("wallet"=>$update_wallet));
										$array = array( "user_id"=>$get_user_detail->id,
													"name"=>$get_user_detail->name,
													"type"=>"debit",
													"txn_name"=>"Calling from astrologer",
													"booking_id"=>$get_bookings->id,
													"booking_txn_id"=>$txn_id,
													"payment_mode"=>"wallet",
													"txn_for"=>"booking",
													"old_wallet"=>$user_wallet,
													"txn_amount"=>$total_price,
													"update_wallet"=>$update_wallet,
													"status"=>1,
													"txn_mode"=>'other',
													"bank_name"=>'',
													"bank_txn_id"=>'',
													"ifsc"=>'',
													"account"=>'',
													"created_at"=>date("Y-m-d H:i:s"),
													"updated_at"=>date("Y-m-d H:i:s")
													  );
										$this->db->insert("transactions",$array);
									}
									$minutes_a = ceil($seconds/60);
									$time_minutes = '';
									$secondsleft = $seconds%60;
									if($minutes_a<10)
										$minutes = "0" . $minutes_a;
									if($secondsleft<10)
										$secondsleft = "0" . $secondsleft;
									$time_minutes = "$minutes_a:$secondsleft minutes";
									$get_astrologer = $this->db->get_where("astrologers",array("id"=>$get_bookings->assign_id))->row();

									$share_percentage = $astrologer_comission_perct= floatval($get_astrologer->share_percentage);
									$astrologer_comission_amount = $total_price*($share_percentage/100);

									$update_array = array("status"=>2,
				   									  	  "end_time"=>$f['end_time'],
				   									  	  "total_seconds"=>$seconds,
				   									  	  "total_minutes"=>$minutes_a,
				   									  	  "time_minutes"=>$minutes_a,//$time_minutes,
				   									  	  "wallet_deduct"=>$total_price,
				   									  	  "subtotal"=>$price_per_mint,
															   "is_paid"=>1,
															   "txn_id"=>$txn_id,
				   									  	  "payable_amount"=>$total_price,
															   "astrologer_comission_perct"=>$astrologer_comission_perct,
															   "astrologer_comission_amount"=>$astrologer_comission_amount,
				   									  	  "ivr_recording"=>'https://client.easygoivr.com/monitor/'.$f['recfile']);
				   					$this->db->where("id",$get_bookings->id);
				   					$this->db->update("bookings",$update_array);
			   					// $get_user_detail = $this->w_m->get_user($get_bookings->user_id);
								}
			   				}
			   				
			   			}
			   			else
			   			{
			   				$get_bookings = $this->db->get_where("bookings",array("status"=>2,"ivr_unique_id"=>$unique_id))->row();
			   				if ($get_bookings) 
			   				{
			   					if ($get_bookings->ivr_recording == NULL) 
			   					{
			   						$update_array = array("ivr_recording"=>'https://client.easygoivr.com/monitor/'.$f['recfile']);
				   					$this->db->where("id",$get_bookings->id);
				   					$this->db->update("bookings",$update_array);
			   					}
			   				}
			   			}
		   			}
		   			else
		   			{
		   				$get_bookings = $this->db->get_where("bookings",array("status"=>0,"ivr_unique_id"=>$unique_id))->row();
			   			if ($get_bookings) 
			   			{
			   				$status = 3;
							$completed_on = date('Y-m-d H:i:s');
							$this->db->query("UPDATE `bookings` SET `complete_date`='".$completed_on."', `status` = '".$status."' WHERE `id` = '$get_bookings->id'");
							$get_astrologer = $this->db->get_where("astrologers",array("id"=>$get_bookings->assign_id))->row();
							$get_setting = $this->db->get_where("ivr_config",array("id"=>1))->row();
				    		$did = $get_setting->did;
							$API_TOKEN = $get_setting->token;
							
							$curl = curl_init();
							curl_setopt_array($curl, array(
							  CURLOPT_URL => 'https://client.easygoivr.com/easygoapi/request/hangup',
							  CURLOPT_RETURNTRANSFER => true,
							  CURLOPT_ENCODING => '',
							  CURLOPT_MAXREDIRS => 10,
							  CURLOPT_TIMEOUT => 0,
							  CURLOPT_FOLLOWLOCATION => true,
							  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
							  CURLOPT_CUSTOMREQUEST => 'POST',
							  CURLOPT_POSTFIELDS =>'{
							    "exten":"'.$get_astrologer->phone.'"
							}',
							  CURLOPT_HTTPHEADER => array(
							    'API_TOKEN: '.$API_TOKEN,
							    'Content-Type: application/json'
							  ),
							));

							$response = curl_exec($curl);

							curl_close($curl);
						}
		   			}
		   			
		   		}
		   }
		}
		echo json_encode(array("status"=>true));
    }

    public function autohangup()
    {
    	$date = date('Y-m-d');
		for ($i = 0; $i < 51; ++$i) {
			$current_date_time = strtotime(date('Y-m-d H:ia'));
			$get_booking = $this->db->query("SELECT * FROM `bookings` WHERE schedule_date = '$date' AND `schedule_time` <> 'ANY TIME' AND `status` IN (0,1) AND `type` = '2' AND `booking_type`='2' AND `is_premium`='0'")->result();
			if (count($get_booking) > 0) 
			{
				foreach ($get_booking as $key)
				{
					// print_r($key);
					$current_time = time();
					$booking_date_time_list = strtotime($key->schedule_date_time);
					$get_astrologer = $this->db->get_where("astrologers",array("id"=>$key->assign_id))->row();
					if ($key->status == 0) 
					{
						$endTime_list = strtotime(date('Y-m-d H:i:s',strtotime("+2 minutes", $booking_date_time_list)));
						// $endTime_list_5seconds = strtotime(date('Y-m-d H:i:s',strtotime("4 second", $endTime_list)));
						if ($current_time > $endTime_list) 
						{
							$status = 3;
							$completed_on = date('Y-m-d H:i:s');
							$this->db->query("UPDATE `bookings` SET `complete_date`='".$completed_on."', `status` = '".$status."' WHERE `id` = '$key->id'");
							// $get_astrologer = $this->db->get_where("astrologers",array("id"=>$key->assign_id))->row();
							$get_setting = $this->db->get_where("ivr_config",array("id"=>1))->row();
				    		$did = $get_setting->did;
							$API_TOKEN = $get_setting->token;
							
							$curl = curl_init();
							curl_setopt_array($curl, array(
							  CURLOPT_URL => 'https://client.easygoivr.com/easygoapi/request/hangup',
							  CURLOPT_RETURNTRANSFER => true,
							  CURLOPT_ENCODING => '',
							  CURLOPT_MAXREDIRS => 10,
							  CURLOPT_TIMEOUT => 0,
							  CURLOPT_FOLLOWLOCATION => true,
							  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
							  CURLOPT_CUSTOMREQUEST => 'POST',
							  CURLOPT_POSTFIELDS =>'{
							    "exten":"0'.$get_astrologer->phone.'"
							}',
							  CURLOPT_HTTPHEADER => array(
							    'API_TOKEN: '.$API_TOKEN,
							    'Content-Type: application/json'
							  ),
							));

							$response = curl_exec($curl);

							curl_close($curl);
							$autohangupdata = $response.'status=0ivr_unique_id='.$key->ivr_unique_id;
					        $this->load->helper('file');
					        $autohangdate = date('Y-m-d');
					        $autohangtime = date('h-i-s');
					        $file_name_ = $autohangdate.' '.$autohangtime;
					        $path = './autohangup/'.$file_name_.'.txt';
					        
							if ( ! write_file($path,$autohangupdata))
							{
						    }
							// $this->common_notification($key->id,'complete_astrologer_bookings');
						}
					}
					elseif ($key->status == 1) 
					{
						$checkwallethaveanycut = $this->db->get_where('transactions',array("user_id"=>$key->user_id,"booking_id"=>$key->id,"type"=>"debit"))->row();
	   					if ($checkwallethaveanycut) {
	   						//not do anything
	   					}
	   					else
	   					{
							$endTime_list = strtotime(date('Y-m-d H:i:s',strtotime("+".$key->total_minutes." minutes", $booking_date_time_list)));
							$endTime_list_5seconds = strtotime(date('Y-m-d H:i:s',strtotime("1 second", $endTime_list)));
							if ($current_time >= $endTime_list) 
							{
								$get_astrologer = $this->db->get_where("astrologers",array("id"=>$key->assign_id))->row();
								$get_setting = $this->db->get_where("ivr_config",array("id"=>1))->row();
					    		$did = $get_setting->did;
								$API_TOKEN = $get_setting->token;
								
								$curl = curl_init();
								curl_setopt_array($curl, array(
								  CURLOPT_URL => 'https://client.easygoivr.com/easygoapi/request/hangup',
								  CURLOPT_RETURNTRANSFER => true,
								  CURLOPT_ENCODING => '',
								  CURLOPT_MAXREDIRS => 10,
								  CURLOPT_TIMEOUT => 0,
								  CURLOPT_FOLLOWLOCATION => true,
								  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
								  CURLOPT_CUSTOMREQUEST => 'POST',
								  CURLOPT_POSTFIELDS =>'{
								    "exten":"0'.$get_astrologer->phone.'"
								}',
								  CURLOPT_HTTPHEADER => array(
								    'API_TOKEN: '.$API_TOKEN,
								    'Content-Type: application/json'
								  ),
								));

								$response = curl_exec($curl);

								curl_close($curl);
								// $autohangupdata1 = json_encode($response);
								$autohangupdata = $response.'status=1ivr_unique_id='.$key->ivr_unique_id;
						        $this->load->helper('file');
						        $autohangdate = date('Y-m-d');
						        $autohangtime = date('h-i-s');
						        $file_name_ = $autohangdate.' '.$autohangtime;
						        $path = './autohangup/'.$file_name_.'.txt';
						        
								if ( ! write_file($path,$autohangupdata))
								{
							    }
								$completed_on = date('Y-m-d H:i:s');
								$seconds = $key->total_minutes * 60;
								$price_per_mint = $key->price_per_mint;
			   					$callingminutes = ceil($seconds / 60);
			   					$total_price = $price_per_mint * $callingminutes;
			   					// $one_sec_price = $price_per_mint / 60;
			   					// $total_price = $seconds * $one_sec_price;
			   					$total_price = number_format($total_price,2);
			   					$checkwallethaveanycut = $this->db->get_where('transactions',array("user_id"=>$key->user_id,"booking_id"=>$key->id,"type"=>"debit"))->row();
			   					if ($checkwallethaveanycut) {
			   						//not do anything
			   					}
			   					else
			   					{
									   $txn_id = time();
				   					$get_user_detail = $this->db->get_where("user",array("id"=>$key->user_id))->row();
				   					if ($total_price > 0) 
									{
										$user_wallet = $get_user_detail->wallet;
										$update_wallet = $get_user_detail->wallet - $total_price;
										if ($update_wallet < 0) 
										{
											$update_wallet = 0;
										}
										$this->db->where("id",$get_user_detail->id);
										$this->db->update("user",array("wallet"=>$update_wallet));
										$array = array( "user_id"=>$get_user_detail->id,
													"name"=>$get_user_detail->name,
													"type"=>"debit",
													"txn_name"=>"Calling from astrologer",
													"booking_id"=>$key->id,
													"booking_txn_id"=>$txn_id,
													"payment_mode"=>"wallet",
													"txn_for"=>"booking",
													"old_wallet"=>$user_wallet,
													"txn_amount"=>$total_price,
													"update_wallet"=>$update_wallet,
													"status"=>1,
													"txn_mode"=>'other',
													"bank_name"=>'',
													"bank_txn_id"=>'',
													"ifsc"=>'',
													"account"=>'',
													"created_at"=>date("Y-m-d H:i:s"),
													"updated_at"=>date("Y-m-d H:i:s")
													  );
										$this->db->insert("transactions",$array);
									}

									$share_percentage = $astrologer_comission_perct= floatval($get_astrologer->share_percentage);
									$astrologer_comission_amount = floatval($total_price)*($share_percentage/100);
										
									$update_array = array("status"=>2,
				   									  	  "end_time"=>$completed_on,
				   									  	  "total_seconds"=>$seconds,
				   									  	  "wallet_deduct"=>$total_price,
														  "txn_id"=>$txn_id,
														  "is_paid"=>1,
														  "total_minutes"=>$callingminutes,
				   									  	  "time_minutes"=>$callingminutes,
				   									  	  "subtotal"=>$price_per_mint,
				   									  	  "payable_amount"=>$total_price,
				   									  	  "complete_date"=>$completed_on,
														"astrologer_comission_perct"=>$astrologer_comission_perct,
														"astrologer_comission_amount"=>$astrologer_comission_amount
				   									  	 );
				   					$this->db->where("id",$key->id);
				   					$this->db->update("bookings",$update_array);
				   					//$this->common_notification($key->id,'complete_astrologer_bookings');
			   					}
							}
						}
					}
					
					
				}	
			}
			sleep(1);
		}
    }

    public function makecallrecording()
    {
		$this->create_ivr_token();
    	$data =json_decode(file_get_contents('php://input'), true);	
		if(isset($data) && !empty($data))
		{
			$res = array("status"=>false,"message"=>"sometjing error happen please try again!");
			$user_id = $data['user_id'];
			$astrologer_id = $data['astrologer_id'];
			// $get_user = $this->db->get_where("user",array("id"=>$user_id))->row();
			// if ($get_user) 
			// {
				$get_astrologer = $this->db->get_where("astrologers",array("id"=>$astrologer_id))->row();
				if ($get_astrologer) 
				{
					$get_user = $this->db->get_where("user",array("id"=>$user_id))->row();
					$user_number = $this->refine($get_astrologer->phone);
					$unique_id = '1'.time().$get_astrologer->id;
					$get_setting = $this->db->get_where("ivr_config",array("id"=>1))->row();
		    		$astrologer_number =  $this->refine($get_setting->recrordingnumber);
					$did = $get_setting->did;
					$API_TOKEN = $get_setting->token;
					
					$curl = curl_init();
					curl_setopt_array($curl, array(
					  CURLOPT_URL => 'https://client.easygoivr.com/easygoapi/request/dial',
					  CURLOPT_RETURNTRANSFER => true,
					  CURLOPT_ENCODING => '',
					  CURLOPT_MAXREDIRS => 10,
					  CURLOPT_TIMEOUT => 0,
					  CURLOPT_FOLLOWLOCATION => true,
					  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					  CURLOPT_CUSTOMREQUEST => 'POST',
					  // CURLOPT_POSTFIELDS =>'{ "exten":"0'.$astrologer_number.'", "number":"0'.$user_number.'", "did":"6882714","uniqueid":"'.$unique_id.'" }',
					  CURLOPT_POSTFIELDS =>'{ "exten":"0'.$user_number.'", "number":"0'.$astrologer_number.'", "did":"6882714","uniqueid":"'.$unique_id.'" }',
					  CURLOPT_HTTPHEADER => array(
					    'Content-Type: application/json',
					    'API_TOKEN: '.$API_TOKEN,
					    'Cookie: ci_session=oi4rsq1mmkkitoud0hmomlab64l76ktc'
					  ),
					));

					$response = curl_exec($curl);

					curl_close($curl);
					// print_r($response);
					if ($response) 
					{	
						$a = json_decode($response,true);
						if (isset($a['status'])) 
						{
							if ($a['status'] == 'success') 
							{
								$res = array("status"=>true,"message"=>"done");		
							}
						}
					}
				}
			// }
			echo json_encode($res);
		}
    }


    public function cutcallrecording()
    {
    	$data =json_decode(file_get_contents('php://input'), true);	
		if(isset($data) && !empty($data))
		{
			$response1 = array("status"=>true);
	    	$get_astrologer = $this->db->get_where("astrologers",array("id"=>$data['astrologer_id']))->row();
			$get_setting = $this->db->get_where("ivr_config",array("id"=>1))->row();
    		$did = $get_setting->did;
			$API_TOKEN = $get_setting->token;
			
			$curl = curl_init();
			curl_setopt_array($curl, array(
			  CURLOPT_URL => 'https://client.easygoivr.com/easygoapi/request/hangup',
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'POST',
			  CURLOPT_POSTFIELDS =>'{
			    "exten":"0'.$get_astrologer->phone.'"
			}',
			  CURLOPT_HTTPHEADER => array(
			    'API_TOKEN: '.$API_TOKEN,
			    'Content-Type: application/json'
			  ),
			));
			$response = curl_exec($curl);
			echo json_encode($response1);
		}
	}

    public function FunctionName($value='')
    {
    	$init = 156;
		echo $minutes = ceil($init / 60);
	}
    	
    public function makecallrecordingnew()
    {
		$this->create_ivr_token();
    	$data =json_decode(file_get_contents('php://input'), true);	
		if(isset($data) && !empty($data))
		{
			$res = array("status"=>false,"message"=>"sometjing error happen please try again!");
			$user_id = $data['user_id'];
			$astrologer_id = $data['astrologer_id'];
			// $get_user = $this->db->get_where("user",array("id"=>$user_id))->row();
			// if ($get_user) 
			// {
				$get_astrologer = $this->db->get_where("astrologers",array("id"=>$astrologer_id))->row();
				if ($get_astrologer) 
				{
					$get_user = $this->db->get_where("user",array("id"=>$user_id))->row();
					$user_number = $this->refine($get_astrologer->phone);
					$unique_id = '1'.time().$get_astrologer->id;
					$get_setting = $this->db->get_where("ivr_config",array("id"=>1))->row();
		    		if ($data['for'] == 'chat') 
					{
						$astrologer_number =  $this->refine($get_setting->recrordingnumber2);
						$did = $get_setting->did2;
					}
					elseif ($data['for'] == 'video') 
					{
						$astrologer_number =  $this->refine($get_setting->recrordingnumber1);
						$did = $get_setting->did1;
					}
					elseif ($data['for'] == 'report') 
					{
						$astrologer_number =  $this->refine($get_setting->recrordingnumber);
						$did = $get_setting->did;
					}
					// if ($data['for'] == 'report') 
					// {
					// 	$astrologer_number =  $this->refine($get_setting->recrordingnumber3);
					// 	$did = $get_setting->did2;
					// }
					$API_TOKEN = $get_setting->token;
					
					$curl = curl_init();
					curl_setopt_array($curl, array(
					  CURLOPT_URL => 'https://client.easygoivr.com/easygoapi/request/dial',
					  CURLOPT_RETURNTRANSFER => true,
					  CURLOPT_ENCODING => '',
					  CURLOPT_MAXREDIRS => 10,
					  CURLOPT_TIMEOUT => 0,
					  CURLOPT_FOLLOWLOCATION => true,
					  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					  CURLOPT_CUSTOMREQUEST => 'POST',
					  // CURLOPT_POSTFIELDS =>'{ "exten":"0'.$astrologer_number.'", "number":"0'.$user_number.'", "did":"6882714","uniqueid":"'.$unique_id.'" }',
					  CURLOPT_POSTFIELDS =>'{ "exten":"0'.$user_number.'", "number":"0'.$astrologer_number.'", "did":"'.$did.'","uniqueid":"'.$unique_id.'" }',
					  CURLOPT_HTTPHEADER => array(
					    'Content-Type: application/json',
					    'API_TOKEN: '.$API_TOKEN,
					    'Cookie: ci_session=oi4rsq1mmkkitoud0hmomlab64l76ktc'
					  ),
					));

					$response = curl_exec($curl);

					curl_close($curl);
					// print_r($response);
					if ($response) 
					{	
						$a = json_decode($response,true);
						if (isset($a['status'])) 
						{
							if ($a['status'] == 'success') 
							{
								$res = array("status"=>true,"message"=>"done");		
							}
						}
					}
				}
			// }
			echo json_encode($res);
		}
    }

    public function HangupcallApi()
    {
		$this->create_ivr_token();
    	$data =json_decode(file_get_contents('php://input'), true);	
		if(isset($data) && !empty($data))
		{
			$res = array("status"=>false,"message"=>"sometjing error happen please try again!");
			$booking_id = $data['booking_id'];
			$key = $this->db->query("SELECT * FROM `bookings` WHERE id = '$booking_id' AND `status` IN (0,1) AND `type` = '2'")->row();
			if ($key) 
			{
				$get_astrologer = $this->db->get_where("astrologers",array("id"=>$key->assign_id))->row();
				$get_setting = $this->db->get_where("ivr_config",array("id"=>1))->row();
	    		$did = $get_setting->did;
				$API_TOKEN = $get_setting->token;
					
				$curl = curl_init();
				curl_setopt_array($curl, array(
				  CURLOPT_URL => 'https://client.easygoivr.com/easygoapi/request/hangup',
				  CURLOPT_RETURNTRANSFER => true,
				  CURLOPT_ENCODING => '',
				  CURLOPT_MAXREDIRS => 10,
				  CURLOPT_TIMEOUT => 0,
				  CURLOPT_FOLLOWLOCATION => true,
				  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				  CURLOPT_CUSTOMREQUEST => 'POST',
				  CURLOPT_POSTFIELDS =>'{
				    "exten":"0'.$get_astrologer->phone.'"
				}',
				  CURLOPT_HTTPHEADER => array(
				    'API_TOKEN: '.$API_TOKEN,
				    'Content-Type: application/json'
				  ),
				));

				$response = curl_exec($curl);

				curl_close($curl);
				$autohangupdata = $response.'status=0ivr_unique_id='.$key->ivr_unique_id;
		        $this->load->helper('file');
		        $autohangdate = date('Y-m-d');
		        $autohangtime = date('h-i-s');
		        $file_name_ = $autohangdate.' '.$autohangtime.'_byapi';
		        $path = './autohangup/'.$file_name_.'.txt';
		        
				if ( ! write_file($path,$autohangupdata))
				{
			    }
			    $res = array("status"=>true,"message"=>"call hangup");		
			}
			else
			{
				$res = array("status"=>false,"message"=>"booking not found");
			}
			echo json_encode($res);
		}
    }



}
	