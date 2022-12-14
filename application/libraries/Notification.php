<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notification {
   	
   	//private static $API_SERVER_KEY = 'AAAAqi3wrzA:APA91bHEciCM2djh7TuZSK6x5EIyI9MXFf64WgfgMnWCzfqaXbRAe7ujGbcf3qP5pmD1A3AcP_1Kb-03P8nwOAPzRa01fqhwBZcqdSqzOt3ZUmuHYrpPc4sgvS8SYB8IFWK-Irza32Pi';
   	private static $API_SERVER_KEY = 'AAAARx6_4L8:APA91bGLCBzbxBtH3O-jlijwTVTPlvDvO6rpqEQ_7KjRT7LS7XEMO5fdhOjSz1av834spuT-7oRMRQc3aN4ALDndYmdQkhQ8y7Wa7qUvZXhbtHETW0xV-W6eGYJ0h_LNpDGudsHpVHS-';
    private static $is_background = "TRUE";
    public function __construct() {     
     
    }
    public function sendPushNotificationToFCMSever($registatoin_ids, $message) {
        $path_to_firebase_cm = 'https://fcm.googleapis.com/fcm/send';
 	
        $fields = array(
            'registration_ids' => array($registatoin_ids),
            'data' => $message,
            'notification' => $message
        );
        $headers = array(
            'Authorization:key=' . self::$API_SERVER_KEY,
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



    public function sendPushNotificationToFCMSeverMultiple($registatoin_ids, $message) {
        $path_to_firebase_cm = 'https://fcm.googleapis.com/fcm/send';
 	
        $fields = array(
            'registration_ids' => $registatoin_ids,
            'data' => $message,
            'notification' => $message
        );
        $headers = array(
            'Authorization:key=' . self::$API_SERVER_KEY,
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
}