<?php
require_once '../gettoken.php';
require "../common.php";

$fields = array(
    'customer_id' => $_POST['customer_id']
    );
$url = "http://www.superfitbrake.com.ng/index.php?route=api/wholesellers/approve&api_token=".$api;
$json = do_curl_post_request($url, $fields);
echo $json;