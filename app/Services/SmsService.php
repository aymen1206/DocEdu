<?php

namespace App\Services;

use \Illuminate\Support\Facades\Http;
class SmsService
{
    
    public static function convertPhoneNumber($phone) {
        $standard = array("0","1","2","3","4","5","6","7","8","9");
        $eastern_arabic_symbols = array("٠","١","٢","٣","٤","٥","٦","٧","٨","٩");
        $phone = str_replace($eastern_arabic_symbols, $standard, $phone);
        $phone = str_replace(' ', '', $phone);
        if (substr($phone, 0, 5) == '00966' &&substr($phone, 0, 6) != '009660'){
            $phone = str_replace("00966", "966", $phone);
        }
        else if (substr($phone, 0, 6) == '009660'){
            //IF PHONE NUMBER HAVING 966 and 0 after that
            $phone = str_replace("00966", "966", $phone);
            $phone = ltrim($phone, '966');
            $phone = ltrim($phone, '0');
            $phone = '966'.$phone;
        }
        else if (substr($phone, 0, 4) == '9660'){
            //IF PHONE NUMBER HAVING 966 and 0 after that
            $phone = ltrim($phone, '966');
            $phone = ltrim($phone, '0');
            $phone = '966'.$phone;
        }

        //IF PHONE NUMBER NOT HAVING 966
        else if (substr($phone, 0, 3) != '966' && substr($phone, 0, 5) != '00966' && substr($phone, 0, 4) != '+966' ){
            $phone = ltrim($phone, '0');
            $phone = '966'.$phone;
        }
        else if(substr($phone, 0, 4) == '+966' && substr($phone, 0, 5) != '+9660'){
            $phone = str_replace("+966", "966", $phone);
        }
        else if( substr($phone, 0, 5) == '+9660'){
            $phone = str_replace("+966", "966", $phone);
            $phone = ltrim($phone, '966');
            $phone = ltrim($phone, '0');
            $phone = '966'.$phone;
        }

        return $phone;
    }

    public static function SendMsgatSMS($phone,$message){
       $url=config('app.oursms_url');
       $thetoken=config('app.oursms_Token');
       $sender=config('app.oursms_sender');

	   $apiUrl =  $url;
        $token = $thetoken;
        $src = $sender;
        $dests = $phone;
        $body = $message;
        $response = Http::asForm()->post($apiUrl, [
            'token' => $token,
            'src' => $src,
            'dests' => $dests,
            'body' => $body,
        ]);

        if ($response->successful()) {
        
        return true;
        } else {
            // Request failed
            				        return false;


        }
    }

}