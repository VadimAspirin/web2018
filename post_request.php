<?php

$url = 'http://localhost/basic/web/index.php?r=api/ticket/create';
//$url = 'http://localhost/post_request_test.php';
$params = array(
    //'param1' => '123',
    //'param2' => 'abc',
);
$result = file_get_contents($url, false, stream_context_create(array(
    'http' => array(
        'method'  => 'GET',
        //'header'  => 'Content-type: application/x-www-form-urlencoded',
        'header'  => 'Authorization: Bearer 111',
        'content' => http_build_query($params)
    )
)));

echo $result;
