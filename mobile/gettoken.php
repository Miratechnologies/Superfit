<?php
session_start();
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type,x-prototype-version,x-requested-with');



if(isset($_SESSION['response'])) {
  $response_arr = json_decode($_SESSION['response'], true);
  $api = $response_arr['api_token'];

} else {
    $curl = curl_init();
    $username = 'superfit_mobile';
    $key = 'lfztiq6WGPMgqbuddAvY1XPfVjBH0WGyhAiGB8GauWCSpA5rd4O33dpIWr7BDE1Eay71gHJ8FpCdHFOZwbgv2CtDy4mkq4kQmhDpmjBwPVzRuVSVXVZfMXP4MTZAeHRO3LuIOKjzqG4hi5huBq1HkPJAEZLi5KZUO2eygiojm1MKz111gSELmNfp0hY1OQsAAzP8Bs1Ri4rNjUXtoHwhBxdYbKUbQRdHvTtymso1e4T72tdWo8jWnevFMEUi2Gsj';
    
    $post = array("username"=> $username, "key"=> $key);

    curl_setopt_array($curl, array(
        CURLOPT_URL => "http://www.superfitbrake.com.ng/index.php?route=api%2Flogin",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $post,
    ));

    $_SESSION['response'] = curl_exec($curl);

    $err = curl_error($curl);
    
    $response_arr = json_decode($_SESSION['response'], true);
    $api = $response_arr['api_token'];
    
}

die($api);