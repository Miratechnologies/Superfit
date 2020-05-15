<?php
require_once '../gettoken.php';
require "../common.php";

$url = "http://www.superfitbrake.com.ng/index.php?route=api/artisans&api_token=".$api;
$json = do_curl_get_request($url);
echo $json;