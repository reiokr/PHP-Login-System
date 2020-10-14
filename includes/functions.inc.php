<?php
$result = true;
function emptyInputSignup($name, $email, $username, $pwd, $pwdrepeat)
{

  if (empty($name) || empty($email) || empty($username) || empty($pwd) || empty($pwdrepeat)) {
    $result = true;
  } else {
    $result = false;
  }
  return $result;
}

function invalidUid($username)
{
  if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
    $result = true;
  } else {
    $result = false;
  }
  return $result;
}

function invalidEmail($email)
{
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $result = true;
  } else {
    $result = false;
  }
  return $result;
}

function invalidPassword($pwd)
{
  if (strlen($pwd) < 6) {
    $result = true;
  } else {
    $result = false;
  }
  return $result;
}

function passwordMatch($pwd, $pwdrepeat)
{
  if ($pwd !== $pwdrepeat) {
    $result = true;
  } else {
    $result = false;
  }
  return $result;
}

function userExists($conn, $username, $email)
{

  $sql = "SELECT * FROM users WHERE usersUid = ? OR usersEmail = ?;";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    echo "Error creating table: " . $conn->error;
    header('location: ../signup.php?error=stmtuserfail');
    exit();
  }
  mysqli_stmt_bind_param($stmt, "ss", $username, $email);
  mysqli_stmt_execute($stmt);

  $resultData = mysqli_stmt_get_result($stmt);
  if ($row = mysqli_fetch_assoc($resultData)) {
    return $row;
  } else {
    $result = false;
    return $result;
  }
  mysqli_stmt_close($stmt);
  mysqli_close($conn);
}

// function emailExists($conn, $email){
//   $sql ="SELECT* FROM users WHERE usersEmail = ?;";
//   $stmt = mysqli_stmt_init($conn);
//   if(!mysqli_stmt_prepare($stmt, $sql)){
//     header('location: ../signup.php?error=stmtfail');
//     exit();
//   }
//   mysqli_stmt_bind_param($stmt, "s", $email);
//   mysqli_stmt_execute($stmt);

//   $resultData = mysqli_stmt_get_result($stmt);
//   if($row = mysqli_fetch_assoc($resultData)){
//     return $row;
//   }
//   else{
//     $result = false;
//     return $result;
//   }
//   mysqli_stmt_close($stmt);
// }

function createUser($conn, $name, $email, $username, $pwd)
{
  $sql = "INSERT INTO users (usersName, usersEmail, usersUid, usersPwd) VALUES (?, ?, ?, ?);";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header('location: ../signup.php?error=stmtfail');
    exit();
  }
  $options = [
    'cost' => 12,
  ];

  $hashedPwd = password_hash($pwd, PASSWORD_BCRYPT, $options);
  // $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

  mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $username, $hashedPwd);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);
  mysqli_close($conn);

  header("location: ../signup.php?error=none");
  exit();
}

function emptyInputLogin($username, $pwd)
{
  if (empty($username) || empty($pwd)) {
    $result = true;
  } else {
    $result = false;
  }
  return $result;
}

function loginUser($conn, $username, $pwd)
{
  $uidExists = userExists($conn, $username, $username);

  if ($uidExists === false) {
    header('location: ../login.php?error=wronglogin');
    exit();
  }
  // create variable and assign password from database 
  $pwdHashed = $uidExists['usersPwd'];

  // verify hashed password with user provaided password
  $checkPwd = password_verify($pwd, $pwdHashed);
  //if password not match 
  if ($checkPwd === false) {
    header('location: ../login.php?error=wronglogin&uid=' . $username);
    exit();
  }
  else if ($checkPwd === true) {
    // start session
    session_start();
    $_SESSION["userid"] = $uidExists["usersId"];
    $_SESSION["useruid"] = $uidExists["usersUid"];
    $_SESSION["username"] = $uidExists["usersName"];
    $_SESSION["useremail"] = $uidExists["usersEmail"];
    $_SESSION["reg_date"] = $uidExists["reg_date"];
    header('location: ../index.php');
    exit();
  }
}