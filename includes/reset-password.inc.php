<?php

if (isset($_POST['reset-pwd-submit'])) {
  
  $selector = $_POST['selector'];
  $validator = $_POST['validator'];
  $password = $_POST['pwd'];
  $passwordRepeat = $_POST['pwdrepeat'];
  
  if(empty($password) || empty($passwordRepeat)){
    header("Location: ../create-new-password.php?newpwd=empty" . "&selector=".$selector."&validator=".$validator);
    exit();
  }else if($password != $passwordRepeat){
    header("Location: ../create-new-password.php?newpwd=pwdnotmatch" . "&selector=".$selector."&validator=".$validator);
    exit();
  }
  
  $curentDate = date("U");
  
  require 'dbh.inc.php';

  $sql = "SELECT * FROM pwdreset WHERE pwdResetSelector=? AND pwdResetExpires >= ?";
  // preparet statements
  $stmt =mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt,$sql)) {
    echo "There was an error!";
    exit();
  }else{
    mysqli_stmt_bind_param($stmt, "ss", $selector, $curentDate);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if (!$row = mysqli_fetch_assoc($result)) {
      echo "You need to re-submit your reset request.";
      exit();
    }else{
      
      $tokenBin = hex2bin($validator);
      $tokenCheck = password_verify($tokenBin, $row['pwdResetToken']);

      if($tokenCheck === false){
        echo "You need to re-submit your reset request.";
        exit();
      }else if($tokenCheck === true){
        $tokenEmail = $row['pwdResetEmail'];
        // preparet statements
        $sql = "SELECT * FROM users WHERE usersEmail = ?;";
        $stmt =mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt,$sql)) {
          echo "There was an error!";
          exit();
        }else{
          mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
          mysqli_stmt_execute($stmt);

          $result = mysqli_stmt_get_result($stmt);
          if (!$row = mysqli_fetch_assoc($result)) {
            echo "There was an error!";
            exit();
          }else{
            
            $sql = "UPDATE users SET usersPwd=? WHERE usersEmail=?";
            $stmt =mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt,$sql)) {
            echo "There was an error!";
            exit();
            }else{

              $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
              mysqli_stmt_bind_param($stmt, "ss", $hashedPwd, $tokenEmail);
              mysqli_stmt_execute($stmt);

              // delete
              $sql = "DELETE FROM pwdReset WHERE pwdResetEmail = ?";
              $stmt =mysqli_stmt_init($conn);
              
              if (!mysqli_stmt_prepare($stmt,$sql)) {
                echo "There was an error!";
                exit();
              }else{
                mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
                mysqli_stmt_execute($stmt);
                header("Location: ../signup.php?newpwd=passwordupdated");
              }
            
            }
          }
      }
    }
  }
}
  
}else{
  header('Location: ../index.php');
}