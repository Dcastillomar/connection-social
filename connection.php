<?php
$dbhost = "wb39lt71kvkgdmw0.cbetxkdyhwsb.us-east-1.rds.amazonaws.com";
$dbuser = "g5rw9okqdy8cyfac";
$dbpass = "hlkbe5whuwap778k";
$dbname = "kcy1de553ln3xoyt"; 

$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die("database connection error");

// // Check connection
// if (!$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname)) {
//     die("failed to connect");
// }