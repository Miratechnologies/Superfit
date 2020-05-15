<?php
require_once '../gettoken.php';
require "../common.php";

$fields = array(
    'customer_id' => $_POST['customer_id'],
    'business_name' => $_POST['business_name'],
    'email' => $_POST['email'],
    'telephone' => $_POST['telephone'],
    'address' => $_POST['address'],
    'city' => $_POST['city'],
    'state' => $_POST['state'],
    'country' => $_POST['country']
    );
$url = "http://www.superfitbrake.com.ng/index.php?route=api/wholesellers/add&api_token=".$api;
$json = do_curl_post_request($url, $fields);
echo $json;