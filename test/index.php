<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$id=15555;
$first_name="Kai";
$url="http://localhost/SimpleRESTAPI/read?api_key=123344&id=$id";
$payload = file_get_contents($url);
echo "<br>".$url."<br>";
print_r($payload);

$url="http://localhost/SimpleRESTAPI/read?api_key=1&sort=first_name&limit=3";
$payload = file_get_contents($url);
echo "<br><BR>".$url."<br>";
print_r($payload);

$url="http://localhost/SimpleRESTAPI/read?api_key=1&limit=21";
$payload = file_get_contents($url);
echo "<br><BR>".$url."<br>";
print_r($payload);

$url="http://localhost/SimpleRESTAPI/read?api_key=1&sort=first_name,last_name";
$payload = file_get_contents($url);
echo "<br><BR>".$url."<br>";
print_r($payload);

$url="http://localhost/SimpleRESTAPI/create?first_name=$first_name&last_name=hiwatari&api_key=1";
$payload = file_get_contents($url);
echo "<br>".$url."<br>";
print_r($payload);

$url="http://localhost/SimpleRESTAPI/delete&api_key=1&id=$id";
$payload = file_get_contents($url);
echo "<br>".$url."<br><b>";
print_r($payload);
echo "</b>";

$first_name="Maria";
$url="http://localhost/SimpleRESTAPI/update?first_name=$first_name&last_name=hiwatari&api_key=1&id=$id";
$payload = file_get_contents($url);
echo "<br>".$url."<br>";
print_r($payload);


?>