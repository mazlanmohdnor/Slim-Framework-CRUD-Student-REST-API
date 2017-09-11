<?php
//mysqli
//variable untuk db
// $host = 'localhost';
// $user = 'root';
// $pass = '';
// $dbname = 'slimdb';

// //connection
// $con = mysqli_connect($host, $user, $pass, $dbname);


//pdo
$dbhost="";
$dbuser="";
$dbpass="";
$dbname="";
$dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
return $dbh;
