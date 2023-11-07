<?php
// $dbhost = "localhost";
// $dbuser = "root";
// $dbpass = "";
// $dbname = "signupdb"; 

// if (!$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname)) {
//     die("failed to connect");
// }

$url = getenv('JAWSDB_URL');
$dbparts = parse_url($url);

$hostname = $dbparts['wb39lt71kvkgdmw0.cbetxkdyhwsb.us-east-1.rds.amazonaws.com	'];
$username = $dbparts['g5rw9okqdy8cyfac	'];
$password = $dbparts['hlkbe5whuwap778k'];
$database = ltrim($dbparts['kcy1de553ln3xoyt'],'/');

$conn = new mysqli($hostname, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connection was successfully established!";