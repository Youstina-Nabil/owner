<?php
error_reporting(E_ALL ^ E_DEPRECATED &~E_NOTICE);

error_reporting (E_ALL ^ E_DEPRECATED) ;

$server = "localhost";
$dbname = "serviceprovider_db"; 
$dbuser = "root";
$dbpassword = "";

$connect = mysql_connect($server,$dbuser,$dbpassword) or die("error");
$select = mysql_select_db($dbname);


?>