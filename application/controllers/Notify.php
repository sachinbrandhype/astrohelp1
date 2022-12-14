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
class Notify extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->library('form_validation');
	}

	public function index()
	{
		// print_r($this->input->get_request_header('HTTP_X_API_KEY'));
	}


	public function sasasa()
	{
		date_default_timezone_set('Etc/UTC');
		/* Information from the XOAUTH2 configuration. */
		$google_email = 'astrokul7@gmail.com';
		$oauth2_clientId = '658292708463-2bg0ebu0pbqse19bos4bqqt08fdejm0f.apps.googleusercontent.com';
		$oauth2_clientSecret = '2TXl-bcmmhx-VE8UPoIU0Cm5';
		$oauth2_refreshToken = '1//0g4MzMmFjGcmDCgYIARAAGBASNwF-L9Ir8ON2fVAYO3_Yl_iCzmC2DSzK8yjpwgofohPV3FuygiQpT547yIPhDOsoodBLIwq227k';

		$mail = new PHPMailer(TRUE);

		try {
		   
		   $mail->setFrom($google_email, 'Darth Vader');
		   $mail->addAddress('sachinappslure@gmail.com', 'Emperor');
		   $mail->Subject = 'Force';
		   $mail->Body = 'There is a great disturbance in the Force.';
		   $mail->isSMTP();
		   $mail->Port = 587;
		   $mail->SMTPAuth = TRUE;
		   $mail->SMTPSecure = 'tls';
		   // if ($fil_package_deatils) 
		   // {
		   // 	$mail->addAttachment($fil_package_deatils);
		   // }
		   /* Google's SMTP */
		   $mail->Host = 'smtp.gmail.com';
		   
		   /* Set AuthType to XOAUTH2. */
		   $mail->AuthType = 'XOAUTH2';
		   
		   /* Create a new OAuth2 provider instance. */
		   $provider = new Google(
		      [
		         'clientId' => $oauth2_clientId,
		         'clientSecret' => $oauth2_clientSecret,
		      ]
		   );
		   
		   /* Pass the OAuth provider instance to PHPMailer. */
		   $mail->setOAuth(
		      new OAuth(
		         [
		            'provider' => $provider,
		            'clientId' => $oauth2_clientId,
		            'clientSecret' => $oauth2_clientSecret,
		            'refreshToken' => $oauth2_refreshToken,
		            'userName' => $google_email,
		         ]
		      )
		   );
		   
		   /* Finally send the mail. */
		   $mail->send();
		   echo 1;
		}
		catch (Exception $e)
		{
			echo $e->errorMessage();
		}
		catch (\Exception $e)
		{
		   echo $e->getMessage();
		}
	}
	



}
	