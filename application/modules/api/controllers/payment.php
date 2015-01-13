<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Payment extends API_Controller{
    const URL_ONEPAY = "https://api.1pay.vn/card-charging/v2/topup";
    public function __construct() {
        parent::__construct();
        
    }
    public function requestCoin(){
        $data = $this->getData('data');
        
        $serial  = $data['seri'];
        $pin  = $data['code'];
        $type = $data['type']; // zing mobifone vinafone viettel
        
        $result = $this->requestCardCharging($serial, $pin, $type);
        
        switch($result['status']){
            case "00":
                // Success
                break;
            default :
                // Error message
                break;
        }
    }
    
    protected function requestCardCharging($serial, $pin, $type){
        $access_key = '';        
        $secret = '';
        
        $data = "access_key=" . $access_key . "&pin=" . $pin . "&serial=" . $serial . "&type=" . $type;
        $signature = hash_hmac("sha256", $data, $secret);
        $data.= "&signature=" . $signature;

        // open connection
	$ch = curl_init();

	// set the url, number of POST vars, POST data
	curl_setopt($ch, CURLOPT_URL, URL_ONEPAY);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	// execute post
	$result = curl_exec($ch);

	// close connection
	curl_close($ch);
	return $result;
    }
}