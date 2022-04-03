<?php
include 'route.php';
$request_uri=$_SERVER['REQUEST_URI'];
$request=$_REQUEST;
getApiData($request_uri,$request);

?>