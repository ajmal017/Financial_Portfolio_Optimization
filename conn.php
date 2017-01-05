<?php
/*
$servername = "sql305.byethost14.com";
$username = "b14_19047019";
$password = "CS673cs";
$dbname = "b14_19047019_bx34";*/
/*
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "CS673";
$port = 8889;*/


$servername = "sql.njit.edu";
$username = "bx34";
$password = "Xx0SnUuM";
$dbname = "bx34";


/*
$servername = "127.0.0.1";
$username = "root";
$password = "rollandx";
$dbname = "bx34";
*/
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>