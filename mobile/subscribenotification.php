<?php
require_once 'gettoken.php';
require "common.php";

$fields = array(
    'customer_id' => $_POST['customerid'],
    'token' => $_POST['token'],
);
$url = "http://www.superfitbrake.com.ng/index.php?route=api/pushnotifications/subscribe&api_token=".$api;
$json = do_curl_post_request($url, $fields);
echo $json;
?>