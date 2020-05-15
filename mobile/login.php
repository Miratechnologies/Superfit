<?php
require "common.php";
 
// set up params
$url = 'http://www.superfitbrake.com.ng/index.php?route=api/login';
 
$fields = array(
  'username' => 'superfit_mobile',
  'key' => 'lfztiq6WGPMgqbuddAvY1XPfVjBH0WGyhAiGB8GauWCSpA5rd4O33dpIWr7BDE1Eay71gHJ8FpCdHFOZwbgv2CtDy4mkq4kQmhDpmjBwPVzRuVSVXVZfMXP4MTZAeHRO3LuIOKjzqG4hi5huBq1HkPJAEZLi5KZUO2eygiojm1MKz111gSELmNfp0hY1OQsAAzP8Bs1Ri4rNjUXtoHwhBxdYbKUbQRdHvTtymso1e4T72tdWo8jWnevFMEUi2Gsj',
);
 
$json = do_curl_request($url, $fields);
$data = json_decode($json);
var_dump($data);
