<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Applib
{
    private $CI;
 
    public function __construct()
    {
        $this->CI = get_instance();

    }

    function CallAPI($method, $url, $data = false,$application_json=false)
    {
        @$curl = curl_init();

        switch ($method)
        {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);

                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_PUT, 1);
                break;
            default:
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data));
        }

        // Optional Authentication:
        // curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        // curl_setopt($curl, CURLOPT_USERPWD, "username:password");

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            $application_json ? 'Content-Type: application/json' : '',
            'Access-Control-Allow-Origin: *',
            'Authorization: '.$this->CI->session->userdata('user_token').'',
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($curl);

        curl_close($curl);

        return $result;
    }

    public function node_api_curl($end_point='',$method='POST',$data,$application_json=false)
    {
        $base_url = 'https://astrohelp24.com:5030/api/'.$end_point;
        return $this->CallAPI($method,$base_url,$data,$application_json);
    }

    public function get_user_session()
    {
        if($this->CI->session->userdata('sh_customer_loggedIn')){
            return  $this->CI->session->userdata('sh_customer_data');
        }
        return false;
       
    }
    public function check_if_login($data)
    {
        if (!empty($data)) {

           $data['user_id'] = $this->CI->session->userdata('user_id');
           $data['user_data'] = $this->CI->session->userdata('user_data');
           $data['user_token'] = $this->CI->session->userdata('user_token');
           return $data;


        }else{
            return false;
        }
    }

    public function register_login_otp($phone)
    {
        # code...
        $result = $this->node_api_curl('register_login_otp','POST',['phone'=>trim(substr($phone, -10))]);
        // print_r($result);die;

        return json_decode($result,true);
    }

    public function verify_register_login($arr)
    {
        # code...
        $result = $this->node_api_curl('verify_register_login','POST',$arr);
        // print_r($result);die;

        return json_decode($result,true);
    }

    public function fetch_astrologers($arr)
    {
        # code...
        $result = $this->node_api_curl('fetch_astrologers','POST',$arr);
        // print_r($result);die;

        return json_decode($result);
    }

    public function fetch_astrologer_details($arr)
    {
        # code...
        $result = $this->node_api_curl('fetch_astrologer_details','POST',$arr);
        return json_decode($result);
    }

    public function user_profile($arr)
    {
        # code...
        $result = $this->node_api_curl('get_userdetails','POST',$arr);
        return json_decode($result);
    }

    public function get_booking_status($arr)
    {
        # code...
        $result = $this->node_api_curl('get_booking_status','POST',$arr);
        return json_decode($result);
    }

    public function realtime_bookinghistory($arr)
    {
        # code...
        $result = $this->node_api_curl('realtime_bookinghistory','POST',$arr);
        return json_decode($result);
    }
    
    public function end_live_session($arr)
    {
        # code...
        $result = $this->node_api_curl('end_live_session','POST',$arr);
        return json_decode($result);
    }

    public function fetch_astrohelp24_home($arr)
    {
        # code...
        $result = $this->node_api_curl('fetch_astrohelp24_home','POST',$arr);
        return json_decode($result);
    }

    

 

    public function add_member($arr)
    {
        # code...
        $result = $this->node_api_curl('add_member','POST',$arr);
        return json_decode($result);
    }
    
    

    // public function send_mail($email,$subject,$message)
    // {

    //     $this->CI->load->helper('string');
    //     $this->CI->load->library('My_PHPMailer');
    //     $subject = $subject;
    //     $body= $message;
    //     $mail = new PHPMailer;
    //     $mail->isSMTP();
    //     $mail->Host = 'smtp.gmail.com'; //'md-70.webhostbox.net';
    //     $mail->SMTPAuth = true;
    //     $mail->Username = 'tenonprime@gmail.com';//'form41app@gmail.com'; //'mail@appsgenic.com';
    //     $mail->Password = '';//'appslure123'; // '@appsgenic123@';

    //     $mail->SMTPSecure = 'tls';
    //     $mail->Port =587;
    //     $mail->From = 'tenonprime@gmail.com';
    //     $mail->FromName = 'Tenon';
    //     $mail->addAddress($email, 'Tenon');
    //     $mail->WordWrap = 500;
    //     $mail->isHTML(true);
    //     $mail->Subject = $subject;
    //     $mail->Body    = $body;
    //     if(!$mail->send())
    //     {
    //         return 0;
    //     }
    //     else
    //     {
    //         return 1;
    //     }
    // }
}

?>