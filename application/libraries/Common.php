<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Common
{
    private $CI;
 
    public function __construct()
    {
        $this->CI = get_instance();

    }

    public function send_mail($email,$subject,$message)
    {

        $this->CI->load->helper('string');
        $this->CI->load->library('My_PHPMailer');
        $subject = $subject;
        $body= $message;
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; //'md-70.webhostbox.net';
        $mail->SMTPAuth = true;
        $mail->Username = 'tenonprime@gmail.com';//'form41app@gmail.com'; //'mail@appsgenic.com';
        $mail->Password = 'ra3sing#$12';//'appslure123'; // '@appsgenic123@';

        $mail->SMTPSecure = 'tls';
        $mail->Port =587;
        $mail->From = 'tenonprime@gmail.com';
        $mail->FromName = 'Tenon';
        $mail->addAddress($email, 'Tenon');
        $mail->WordWrap = 500;
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;
        if(!$mail->send())
        {
            return 0;
        }
        else
        {
            return 1;
        }
    }


    public function send_push_notification($registatoin_ids, $message) {
        $path_to_firebase_cm = 'https://fcm.googleapis.com/fcm/send';
		// $API_SERVER_KEY = "AAAAb0zS7Yo:APA91bHpdehHo2KvTHjjwr4WryWMSwSJH0TRw-rhZymhP6xv0BvdXqRtxwe6AUT2glPRRVzvNQIk8W7yBhGF0m1WodmC_YsrT1tRDfyjLCWOfj7EkayN8fhJddDYUTI4MkJvXaVC2pgY";

        $this->CI->db->where('id',1);
        $q = $this->CI->db->get('settings');
        $setting = $q->row();
        if (count($setting) > 0)
        {
            $API_SERVER_KEY = trim($setting->firebase_key);
            if(empty($API_SERVER_KEY)){
                $API_SERVER_KEY = 'AAAARuE3bSY:APA91bFcg99Zq7Npykdzl6gCCK17-yjniVBxjPZoI8cLq-o2Ex3Ta80ugYSWhnsSO204PpgSc7pPdv0e6x6AB2kCszf5w6QQe021hOqidfdRikIENkjUsCPVO8hHaYt7vd5dpDSUf3jR';
            }

        }
        else
        {
            $API_SERVER_KEY = 'AAAARuE3bSY:APA91bFcg99Zq7Npykdzl6gCCK17-yjniVBxjPZoI8cLq-o2Ex3Ta80ugYSWhnsSO204PpgSc7pPdv0e6x6AB2kCszf5w6QQe021hOqidfdRikIENkjUsCPVO8hHaYt7vd5dpDSUf3jR';
        }
        if(!is_array($registatoin_ids)){
            $device_tokens = [$registatoin_ids];
        }
        else{
            $device_tokens = $registatoin_ids;
        }
        $fields = array(
            'registration_ids' => $device_tokens,
            'data' => $message,
			'notification' => $message
			// 'sound'=>'default'
        );
        $headers = array(
            'Authorization:key=' .$API_SERVER_KEY,
            'Content-Type:application/json'
        );  
         
        // Open connection  
        $ch = curl_init(); 
        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $path_to_firebase_cm); 
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        // Execute post   
     
        $result = curl_exec($ch); 
     
        // Close connection      
		curl_close($ch);
		
        return $result;
       // print_r($result);
    }


    public function notif_msg($title,$body,$details = [])
    {
       return  array(
            'body' => $body,
            'booking_details'=>$details,
            'title' => $title,
            'sound' => 'default',
            "icon"=> "ic_launcher"

        );
    }
 

    public function professional_mail($data){

		$user_name = trim($data['firstname']." ".$data['lastname']);
        $logo_url = base_url()."assets/uploads/mail_template/logo.png";
        $fb_logo = base_url()."assets/uploads/mail_template/facebook.png";
        $tw_logo = base_url()."assets/uploads/mail_template/instgram.png";
        $inst_logo = base_url()."assets/uploads/mail_template/twitter.png";
        
        $message = '<table style="background-color:#eee;width:640px;height:100%"> 
            <tbody><tr>
                <td>
                    <center>
                        <table style="background-color:white;width:600px;margin-top:5%;margin-bottom:5%">
                            <tbody><tr>
                            <td>
                        <a href="#">

            <img src="'.$logo_url.'" style="max-width:100%;margin-top:16px;width:14%;margin-bottom:3px;margin-left:5%" alt="YAWD Logo" class="CToWUd"></a>


                            <hr style="border:0px;border-bottom:1px solid #eee">
                                            </td>
                                            </tr>
                            <tr style="margin:0px;margin-top:3%;padding:0px">
                    <td style="padding-left:5%;padding-right:5%;vertical-align:top;margin-bottom:0px;padding-bottom:0px">

                                    
                                    <p style="font-weight:bold;font-size:20px; color: #03a107">Registeration Successful!</p>
                                    <p style="font-size:14px">Hi '.$user_name.'</p>
            <p style="font-size:14px">Thank you for joining with YAWD.</p>
            <p style="font-size:14px">Your registeration is successful. </p>
                                    
                                    
                                                <br>
                                    
                                                <table>
                                            <tbody><tr>
                            <td style="width:250px;font-size:14px;color:#777">

                                            Professional Details:
												<p>Name:    <span style="color:black">'.$user_name.'</span></p>
												<p>Email:    <span style="color:black">'.$data['email_id'].'</span></p>
												<p>Phone:    <span style="color:black">'.$data['phone_no'].'</span></p>
												<p>Password:    <span style="color:black">'.$data['password'].'</span></p>
												<p>Birthdate:    <span style="color:black">'.$data['birthdate'].'</span></p>
												<p>Gender:    <span style="color:black">'.$data['gender'].'</span></p>
												<p>Experience:    <span style="color:black">'.$data['experience'].'</span></p>
												<p>Address:    <span style="color:black">'.$data['location'].'</span></p>
								
                                            </td>
                                            </tr>
                                    </tbody>
                                </table>

                                </td>

                            </tr>


                            
                        </tbody></table>
                            </center>
                    
                                </td>
                                </tr>

                                <tr>
                                <td>
                                <center>

                            <a href="">

            <img src="'.$fb_logo.'" width="4%;" style="margin-left:3%" class="CToWUd">
                                    </a>

                                <a href="">

            <img src="'.$tw_logo.'" width="4%;" style="margin-left:3%" class="CToWUd">
                                    </a>

                                <a href="">

            <img src="'.$inst_logo.'" width="4%;" style="margin-left:3%" class="CToWUd">
                                </a>

                                </center>
                                </td>
                                </tr>
                                <tr>
                                <td>

                    
                                <center>

            <p style="font-size:12px;color:#666;font-family:helvetica;margin-left:3%;margin-top:0px">Need Help? You may <a href="mailto:info@yawd.com" style="color:#666" target="_blank">

            email us </a>or visit us <a href="">here</a>. </p>
            </center>
                </td>
            </tr>
            </tbody>
            </table>
                    
                    ';

			$this->send_mail($data['email_id'],'Professional Registeration',$message);

    }



    public function booking_mail($data){

        $appointment_date = $data['appointment_date'];
        $appointment_time = $data['appointment_time'];
        $booking_id = $data['booking_id'];
        $user_name = $data['user_name'];
        $user_email = $data['user_email'];
        $services_name = $data['services_name'];

        $booking_type = $data['booking_type'];
        $location = $data['appartment'].", ".$data['location'];
        $time = '';
        $this->CI->load->model('common_model');

        
        $st = $this->CI->db->get('settings');
        $str = $st->row();
        
        if($booking_type == 'self'){
            $msg = $str->visit_at_home_booking_msg;
        }
        elseif($booking_type == 'saloon'){
            $msg = $str->visit_at_salon_booking_msg;

        }

        $services = $this->CI->common_model->bought_orders($booking_id);



        // $logo_url = base_url()."assets/uploads/mail_template/logo.png";

        // $fb_logo = base_url()."assets/uploads/mail_template/facebook.png";
        // $tw_logo = base_url()."assets/uploads/mail_template/instgram.png";
        // $inst_logo = base_url()."assets/uploads/mail_template/twitter.png";

        $message = '<center>
        <table style="background-color:#78297e;width:640px;">
            <tbody>
                <tr>
                    <td>
                        <center>
                            <table style="background-color:white;width:600px;margin-top:5%;margin-bottom:5%">
                                <tbody>
                                    <tr>
                                        <td>
                                            <a href="#" target="_blank"><img src="'.base_url().'assets/uploads/settings/logo.png" style="max-width:100%;margin-top:16px;width:30%;margin-bottom:3px;margin-left:5%" alt="Tenon Logo"></a>
                                            <hr style="border:0px;border-bottom:1px solid #eee">
                                        </td>
                                    </tr>
                                    <tr style="margin:0px;margin-top:3%;padding:0px">
                                        <td style="padding-left:5%;padding-right:5%;vertical-align:top;margin-bottom:0px;padding-bottom:0px">
    
                                            <p style="font-weight:bold;font-size:20px; font-family:helvetica;">Booking Request!</p>
                                            <p style="font-size:18px; font-family:helvetica;">Hi '.$user_name.',</p>
    
                                            <p style="font-size:16px; font-family:helvetica; line-height: 25px;">We have received your request for the '.$services_name.' at <strong>location - '.$location.' at '.$time.'.</strong>
    
                                            </p>
                                            <p style="font-size:16px; font-family:helvetica; line-height: 25px;"><strong>Your request id.: '.$booking_id.'. </strong>Our customer representative will call you within the next 24 hours to confirm your order.
    
                                            </p>
    

                                            <table>
                                                <tbody>
                                                    <tr>
                                                        <td style="width:250px;font-size:16px;color:#777;font-family:helvetica;">
                                                            Thank You
    
                                                        </td>
                                                    </tr>
                                                    <tr height="20"></tr>
                                                </tbody>
                                            </table>
    
                                        </td>
    
                                    </tr>
    
                                </tbody>
                            </table>
                        </center>
    
                    </td>
                </tr>
    
                <tr>
                    <td>
                        <center>
                            <a href="https://www.facebook.com/TenonWorld/" style="text-decoration:none" target="_blank">
                                <img src="file:///Users/macuser/Desktop/pradeep%20yadavoo/Tenon%20prime/email%20template/fb.png" width="4%;" style="margin-left:3%">
                            </a>
                            <a href="https://twitter.com/TenonWorld_" style="text-decoration:none" target="_blank">
                                <img src="file:///Users/macuser/Desktop/pradeep%20yadavoo/Tenon%20prime/email%20template/twitter.png" width="4%;" style="margin-left:3%">
                            </a>
                            <a href="https://www.linkedin.com/company/tenon-property-services?originalSubdomain=in" style="text-decoration:none" target="_blank">
                                <img src="file:///Users/macuser/Desktop/pradeep%20yadavoo/Tenon%20prime/email%20template/linkedin.png" width="4%;" style="margin-left:3%">
                            </a>

                        </center>
                    </td>
                </tr>
                <tr height="5"></tr>
                <tr>
                    <td>

                         <center>
                            <p style="font-size:12px;font-family:helvetica;margin-left:3%;margin-top:0px;color: #fff;">Need Help?
                                    Call us <a href="tel:1800-101-6020" style="color:#fff;">1800-101-6020</a>&nbsp;-&nbsp;<a href="tel:8130-950-950" style="color:#fff;">8130-950-950</a></p>
                            <p style="font-size:12px;color:#fff;font-family:helvetica;">© 2020 Tenon Group. All rights reserved.</p>
                        </center>
                    </td>
                </tr>
                <tr height="20"></tr>
            </tbody>
        </table>
    </center>';
        $this->send_mail($user_email,'BOOKING REQUEST',$message);

    }



    public function register_mail($data){

      
        $user_name = $data['user_name'];
        $user_email = $data['user_email'];



        $logo_url = base_url()."assets/uploads/mail_template/logo.png";

        $fb_logo = base_url()."assets/uploads/mail_template/facebook.png";
        $tw_logo = base_url()."assets/uploads/mail_template/instgram.png";
        $inst_logo = base_url()."assets/uploads/mail_template/twitter.png";
        
        $message = '<table style="background-color:#eee;width:640px;height:100%"> 
            <tbody><tr>
                <td>
                    <center>
                        <table style="background-color:white;width:600px;margin-top:5%;margin-bottom:5%">
                            <tbody><tr>
                            <td>
                        <a href="#">

            <img src="'.$logo_url.'" style="max-width:100%;margin-top:16px;width:14%;margin-bottom:3px;margin-left:5%" alt="YAWD Logo" class="CToWUd"></a>


                            <hr style="border:0px;border-bottom:1px solid #eee">
                                            </td>
                                            </tr>
                            <tr style="margin:0px;margin-top:3%;padding:0px">
                    <td style="padding-left:5%;padding-right:5%;vertical-align:top;margin-bottom:0px;padding-bottom:0px">

                                    
                                    <p style="font-weight:bold;font-size:20px; color: #03a107">Registeration Successful!</p>
                                    <p style="font-size:14px">Hi '.$user_name.'</p>
            <p style="font-size:14px">Thank you for Signing Up with YAWD.
            <p style="font-size:14px">Your registration has been successful. </p>
            <p style="font-size:14px">Regards, </p><br>
            <p>YAWD Team</p>

                                    
                                    
                                                <br>
                                    
                                             
                                </td>

                            </tr>


                            
                        </tbody></table>
                            </center>
                    
                                </td>
                                </tr>

                                <tr>
                                <td>
                                <center>

                            <a href="">

            <img src="'.$fb_logo.'" width="4%;" style="margin-left:3%" class="CToWUd">
                                    </a>

                                <a href="">

            <img src="'.$tw_logo.'" width="4%;" style="margin-left:3%" class="CToWUd">
                                    </a>

                                <a href="">

            <img src="'.$inst_logo.'" width="4%;" style="margin-left:3%" class="CToWUd">
                                </a>

                                </center>
                                </td>
                                </tr>
                                <tr>
                                <td>

                                <center>

            <p style="font-size:12px;color:#666;font-family:helvetica;margin-left:3%;margin-top:0px">Need Help? You may <a href="mailto:info@yawd.com" style="color:#666" target="_blank">

            email us </a>or visit us <a href="">here</a>. </p>
            </center>
                </td>
            </tr>
            </tbody>
            </table>

                    ';

            $this->send_mail($user_email,'YAWD REGISTERATION',$message);

    }



    public function cancel_booking_mail($data){

        $booking_id = $data['booking_id'];
        $user_name = $data['user_name'];
        $user_email = $data['user_email'];

        $this->CI->load->model('common_model');

        $st = $this->CI->db->get('settings');
        $str = $st->row();


        $services = $this->CI->common_model->bought_orders($booking_id);


        $logo_url = base_url()."assets/uploads/mail_template/logo.png";

        $fb_logo = base_url()."assets/uploads/mail_template/facebook.png";
        $tw_logo = base_url()."assets/uploads/mail_template/instgram.png";
        $inst_logo = base_url()."assets/uploads/mail_template/twitter.png";

        $message = '<table style="background-color:#eee;width:640px;height:100%"> 
            <tbody><tr>
                <td>
                    <center>
                        <table style="background-color:white;width:600px;margin-top:5%;margin-bottom:5%">
                            <tbody><tr>
                            <td>
                        <a href="#">

            <img src="'.$logo_url.'" style="max-width:100%;margin-top:16px;width:14%;margin-bottom:3px;margin-left:5%" alt="YAWD Logo" class="CToWUd"></a>


                            <hr style="border:0px;border-bottom:1px solid #eee">
                                            </td>
                                            </tr>
                            <tr style="margin:0px;margin-top:3%;padding:0px">
                    <td style="padding-left:5%;padding-right:5%;vertical-align:top;margin-bottom:0px;padding-bottom:0px">


                                    <p style="font-weight:bold;font-size:20px; color: #03a107">Booking Cancelled!</p>
                                    <p style="font-size:14px">Hi '.$user_name.'</p>
            <p style="font-size:14px">'.$str->cancel_booking_msg.'</p>
            <p>Booking ID:    <span style="color:black">'.$booking_id.'</span></p>

            <p>Services:    <span style="color:black">'.$services.'</span></p>


                                                <br>


                                </td>

                            </tr>

                        </tbody></table>
                            </center>

                                </td>
                                </tr>

                                <tr>
                                <td>
                                <center>

                            <a href="">

            <img src="'.$fb_logo.'" width="4%;" style="margin-left:3%" class="CToWUd">
                                    </a>

                                <a href="">

            <img src="'.$tw_logo.'" width="4%;" style="margin-left:3%" class="CToWUd">
                                    </a>

                                <a href="">

            <img src="'.$inst_logo.'" width="4%;" style="margin-left:3%" class="CToWUd">
                                </a>

                                </center>
                                </td>
                                </tr>
                                <tr>
                                <td>

                                <center>

            <p style="font-size:12px;color:#666;font-family:helvetica;margin-left:3%;margin-top:0px">Need Help? You may <a href="mailto:info@yawd.com" style="color:#666" target="_blank">

            email us </a>or visit us <a href="">here</a>. </p>
            </center>
                </td>
            </tr>
            </tbody>
            </table>

                    ';

        $this->send_mail($user_email,'YAWD BOOKING CANCELLATION',$message);

    }


    public function reschdule_booking_mail($data){

        $appointment_date = $data['appointment_date'];
        $appointment_time = $data['appointment_time'];
        $booking_id = $data['booking_id'];
        $user_name = $data['user_name'];
        $user_email = $data['user_email'];
        $location = $data['appartment'].", ".$data['location'];

        $booking_type = $data['booking_type'];

        $st = $this->CI->db->get('settings');
        $str = $st->row();

        if($booking_type == 'self'){
            $msg = $str->visit_at_home_booking_msg;
        }
        elseif($booking_type == 'saloon'){
            $msg = $str->visit_at_salon_booking_msg;

        }

        $this->CI->load->model('common_model');

        $services = $this->CI->common_model->bought_orders($booking_id);


        $logo_url = base_url()."assets/uploads/mail_template/logo.png";

        $fb_logo = base_url()."assets/uploads/mail_template/facebook.png";
        $tw_logo = base_url()."assets/uploads/mail_template/instgram.png";
        $inst_logo = base_url()."assets/uploads/mail_template/twitter.png";

        $message = '<table style="background-color:#eee;width:640px;height:100%"> 
            <tbody><tr>
                <td>
                    <center>
                        <table style="background-color:white;width:600px;margin-top:5%;margin-bottom:5%">
                            <tbody><tr>
                            <td>
                        <a href="#">

            <img src="'.$logo_url.'" style="max-width:100%;margin-top:16px;width:14%;margin-bottom:3px;margin-left:5%" alt="YAWD Logo" class="CToWUd"></a>


                            <hr style="border:0px;border-bottom:1px solid #eee">
                                            </td>
                                            </tr>
                            <tr style="margin:0px;margin-top:3%;padding:0px">
                    <td style="padding-left:5%;padding-right:5%;vertical-align:top;margin-bottom:0px;padding-bottom:0px">


                                    <p style="font-weight:bold;font-size:20px; color: #03a107">Appointment Rescheduled!</p>
                                    <p style="font-size:14px">Hi '.$user_name.'</p>
            <p style="font-size:14px">'.$str->rescheduled_booking_msg.'</p>

                                                <br>

                                                <table>
                                            <tbody><tr>
                            <td style="width:250px;font-size:14px;color:#777">

                                            Request Details:
                                            <p>Booking ID:    <span style="color:black">'.$booking_id.'</span></p>
                                            <p>Services:    <span style="color:black">'.$services.'</span></p>

                                            <p>Appointment Date:    <span style="color:black">'.$appointment_date.'</span></p>
                                            <p>Appointment Time:    <span style="color:black">'.$appointment_time.'</span></p>
                                            <p>Location:    <span style="color:black">'.$location.'</span></p>
                                            </td>
                                            </tr>
                                    </tbody>
                                </table>

                                </td>

                            </tr>

                        </tbody></table>
                            </center>

                                </td>
                                </tr>

                                <tr>
                                <td>
                                <center>

                            <a href="">

            <img src="'.$fb_logo.'" width="4%;" style="margin-left:3%" class="CToWUd">
                                    </a>

                                <a href="">

            <img src="'.$tw_logo.'" width="4%;" style="margin-left:3%" class="CToWUd">
                                    </a>

                                <a href="">

            <img src="'.$inst_logo.'" width="4%;" style="margin-left:3%" class="CToWUd">
                                </a>

                                </center>
                                </td>
                                </tr>
                                <tr>
                                <td>

                    
                                <center>

            <p style="font-size:12px;color:#666;font-family:helvetica;margin-left:3%;margin-top:0px">Need Help? You may <a href="mailto:info@yawd.com" style="color:#666" target="_blank">

            email us </a>or visit us <a href="">here</a>. </p>
            </center>
                </td>
            </tr>
            </tbody>
            </table>
                    
                    ';

                    $this->send_mail($user_email,'BOOKING RESCHEDULED',$message);

    }


    public function professional_assign_mail($bookingID,$professionalID)
    {

        $booking = $this->CI->db->get_where('booking_details',array('id'=>$bookingID))->row();
    	$user = $this->CI->db->get_where('users',array('id'=>$booking->user_id))->row();
    	$professional = $this->CI->db->get_where('professionals',array('id'=>$professionalID))->row();
    	if(!empty($user))
    	{
    		$name = $user->firstname." ".$user->lastname;
    		$email = $user->email_id;
    		$phone_no = $user->phone_no;
    	}
    	if(!empty($professional))
    	{
    		$pro_name = $professional->firstname." ".$professional->lastname;
    		$pro_email = $professional->email_id;
    		$pro_phone_no = $professional->phone_no;
    	}
    	$discount = $booking->discount+$booking->wallet_discount;
    	$image = base_url()."assets/logo.png";
        
        $message= '<table cellpadding="5" style="width:100%; border-collapse: collapse;">
		   <tr>
		      <td><img src="'.$image.'"></td>
		   </tr>
		</table>

		<table>
		   <tr height="10"></tr>
		</table>

		<table  cellpadding="10" cellspacing="10" style="width:100%; text-align: left; border-collapse: collapse;" border="1">
			
		<tr bgcolor="#ddd"><th>Booking ID : YAWD-'.$bookingID.'<span style="float:right">Appointment Date : '.$booking->appointment_date.' '.$booking->appointment_time.'</span></th></tr>

		</table>
		<table>
		   <tr height="10"></tr>
		</table>
		<table  cellpadding="10" cellspacing="10" style="width:100%; text-align: left; border-collapse: collapse;" border="1">
		   <tr bgcolor="#ddd">
		      <th>Professional Details</th>
		      <th>Customer Details</th>
		   </tr>
		   <tr>
		      <td>Name : '.$pro_name.'</td>
		      <td>Name : '.$name.'</td>
		   </tr>
		   <tr>
		      <td>Email : '.$pro_email.'</td>
		      <td>Email : '.$email.'</td>
		   </tr>
		   <tr>
		      <td>Mobile : '.$pro_phone_no.'</td>
		      <td>Mobile : '.$phone_no.'</td>
		   </tr>
		</table>


		<table>
		   <tr height="10"></tr>
		</table>
		<table  cellpadding="10" cellspacing="10" style="width:100%; text-align: left; border-collapse: collapse;" border="1">
		   <tr bgcolor="#ddd">
		      <th>Transaction Details</th>
		   </tr>
		   
		   <tr>
		      <td>Discount : '.$discount.'</td>
		   </tr>
		   <tr>
		      <td>Counpon Discount : '.$booking->coupan_discount.'</td>
		   </tr>
		   <tr>
		      <td>Total Amount : '.$booking->total_amount.'</td>
		   </tr>
		</table>
		<table>
		   <tr height="10"></tr>
		</table>
        ';
        
        $this->send_mail($email,'PROFESSIONAL ASSIGNED',$message);

    }

    public function forgot_password_mail($email,$password)
    {
        $message= "Dear ".$email.",
        <br>Looks like you forgot your password. If you really did, your password is ".$password.":<br>
        <br>
        If you didn't request for password you can ignore this mail.<br>Thanks, Team YAWD";

        $this->send_mail($email,'Forgot Password',$message);

    }
}

?>