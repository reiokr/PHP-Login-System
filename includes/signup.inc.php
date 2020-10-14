<?php

if (isset($_POST['submit'])) {

  $name = $_POST['name'];
  $email = $_POST['email'];
  $username = $_POST['uid'];
  $pwd = $_POST['pwd'];
  $pwdrepeat = $_POST['pwdrepeat'];

  require_once "dbh.inc.php";
  require_once "functions.inc.php";

  if (emptyInputSignup($name, $email, $username, $pwd, $pwdrepeat) !== false) {
    header('Location:../signup.php?error=emptyinput&name='.$name."&email=".$email."&uid=".$username);
    exit();
  }
  if (invalidUid($username) !== false) {
    header('Location:../signup.php?error=invaliduid&name='.$name."&email=".$email."&uid=".$username);
    exit();
  }
  if (invalidEmail($email) !== false) {
    header('Location:../signup.php?error=invalidemail&name='.$name."&email=".$email."&uid=".$username);
    exit();
  }
  if (invalidPassword($pwd) !== false) {
    header('Location:../signup.php?error=invalidpwd&name='.$name."&email=".$email."&uid=".$username);
    exit();
  }
  if (passwordMatch($pwd, $pwdrepeat) !== false) {
    header('Location:../signup.php?error=pwdnotmatch&name='.$name."&email=".$email."&uid=".$username);
    exit();
  }
  if (userExists($conn, $username, $email) !== false) {
    header('Location:../signup.php?error=userexist&name='.$name."&email=".$email."&uid=".$username);
    exit();
  }
  // if (emailExists($conn, $email) !== false) {
  //   header('Location:../signup.php?error=emailexist');
  //   exit();
  // }

  createUser($conn, $name, $email, $username, $pwd);
  
} else {
  header('Location:../signup.php');
  exit();
}