<?php
// If database is not exist create one
if (!mysqli_select_db($conn, $dbName)) {
  $sql = "CREATE DATABASE $dbName";
  if ($conn->query($sql) === TRUE) {

        // create table users
        $conn = mysqli_connect($serverName, $dbUsername, $dbPassword, $dbName);
        $sql = "CREATE TABLE users (
          usersId INT(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
          usersName VARCHAR(150) NOT NULL,
          usersEmail VARCHAR(150) NOT NULL,
          usersUid VARCHAR(150) NOT NULL,
          usersPwd VARCHAR(250) NOT NULL,
          reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP);";
        if ($conn->query($sql) === TRUE) {
          $conn = mysqli_connect($serverName, $dbUsername, $dbPassword, $dbName);
          $sql = "CREATE TABLE pwdReset (
            pwdResetId int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
            pwdResetEmail TEXT NOT NULL,
            pwdResetSelector TEXT NOT NULL,
            pwdResetToken LONGTEXT NOT NULL,
            pwdResetExpires TEXT NOT NULL
          );";
          if ($conn->query($sql) === TRUE) {
            return;
          } else {
            echo "Error creating table: " . $conn->error;
          }
          
        } else {
          echo "Error creating table: " . $conn->error;
        }
        
  } else {
    echo "Error creating database: " . $conn->error;
  }
}