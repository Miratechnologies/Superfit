<?php
require_once '../gettoken.php';
require "../common.php";

$query = $_GET['query'];

$url = "http://www.superfitbrake.com.ng/index.php?route=api/artisans/search&query=".$query."&api_token=".$api;
$json = do_curl_get_request($url);
echo $json;