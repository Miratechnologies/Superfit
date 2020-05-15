<?php
require_once '../gettoken.php';
require "../common.php";

$customer_id = $_GET['customer_id'];

$url = "http://www.superfitbrake.com.ng/index.php?route=api/artisans/get&customer_id=".$customer_id."&api_token=".$api;
$json = do_curl_get_request($url);
echo $json;