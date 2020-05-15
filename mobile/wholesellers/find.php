<?php
require_once '../gettoken.php';
require "../common.php";

$city = $_GET['city'];

$url = "http://www.superfitbrake.com.ng/index.php?route=api/wholesellers/find&city=".$city."&api_token=".$api;
$json = do_curl_get_request($url);
echo $json;