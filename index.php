<?php
$request=$_SERVER['REQUEST_URI'];
$router= str_replace('/REST','',$request);
echo "Hello".$request."<br>";
print_r($router);
echo "<br>";

if($router ==='/')
{
    echo "home";
}



?>