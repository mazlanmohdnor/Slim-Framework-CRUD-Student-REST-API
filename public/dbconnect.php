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
$dbhost="localhost:3306";
$dbuser="techouzc_mazlan";
$dbpass="123456789";
$dbname="techouzc_wp11";
$dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
return $dbh;
