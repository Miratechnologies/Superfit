<?php
require_once 'gettoken.php';
require "common.php";

$fields = array(
    'customer_id' => $_POST['customerid'],
    'address_id' => $_POST['addressid'],
    'shippingoption' => $_POST['shippingoption'],
    'paymentoption' => $_POST['paymentoption'],
    'option' => $_POST['option'],
    );
$url = "http://www.superfitbrake.com.ng/index.php?route=api/checkout/addorder&api_token=".$api;
$json = do_curl_post_request($url, $fields);
echo $json;