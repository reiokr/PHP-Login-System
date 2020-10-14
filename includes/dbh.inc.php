<?php
$serverName = "localhost";
$dbUsername = "testuser";
$dbPassword = "test123";
$dbName = "phploginsystem";

// Create connection
$conn = mysqli_connect($serverName, $dbUsername, $dbPassword);
// Check connection
if ($conn->connect_error) {
  die("Error connecting: " . mysqli_connect_error());
}
include_once "createDb.inc.php";