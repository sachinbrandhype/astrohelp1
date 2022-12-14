<?php 


function sh_get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

function sh_limit_words($string, $word_limit = 20)
{
    $words = explode(" ", $string);
    if (count($words) > $word_limit) {
        return implode(" ", array_splice($words, 0, $word_limit)) . ' ...';
    }
    return implode(" ", array_splice($words, 0, $word_limit));
}

function sh_breakLongText($text, $length = 150, $maxLength = 200){
    //Text length
    $textLength = strlen($text);
   
    //initialize empty array to store split text
    $splitText = array();
   
    //return without breaking if text is already short
    if (!($textLength > $maxLength)){
     $splitText[] = $text;
     return $splitText;
    }
   
    //Guess sentence completion
    $needle = '.';
   
    /*iterate over $text length 
      as substr_replace deleting it*/  
    while (strlen($text) > $length){
   
     $end = strpos($text, $needle, $length);
   
     if ($end === false){
   
      //Returns FALSE if the needle (in this case ".") was not found.
      $splitText[] = substr($text,0);
      $text = '';
      break;
   
     }
   
     $end++;
     $splitText[] = substr($text,0,$end);
     $text = substr_replace($text,'',0,$end);
   
    }
    
    if ($text){
     $splitText[] = substr($text,0);
    }
   
    return $splitText;
   
}