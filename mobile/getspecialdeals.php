<?php
require_once 'gettoken.php';
require "common.php";

$fields = array();
$url = "http://www.superfitbrake.com.ng/index.php?route=api/deals&api_token=".$api;
$json = do_curl_post_request($url, $fields);
echo $json;
