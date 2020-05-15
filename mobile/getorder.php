<?php
require_once 'gettoken.php';
require "common.php";

$fields = array(
    'customer_id' => $_POST['customerid'],
    'order_id' => $_POST['orderid'],
    'option' => $_POST['option']
    );
$url = "http://www.superfitbrake.com.ng/index.php?route=api/orderhistory/getorder&api_token=".$api;
$json = do_curl_post_request($url, $fields);
echo $json;