<?php
$serverName = "localhost";
$dbUsername = "root";
$dbPassword = "kuradiSitapead1885";
$dbName = "phploginsystem";

// Create connection
$conn = mysqli_connect($serverName, $dbUsername, $dbPassword);
// Check connection
if ($conn->connect_error) {
  die("Error connecting: " . mysqli_connect_error());
}
include_once "createDb.inc.php";