<?php



if(isset($_POST['reset-request-submit'])){
  
  // create selector token and convert to hex format
  $selector = bin2hex(random_bytes(8));

  // create token 
  $token = random_bytes(32);

  // link that will be sent to client email
  $url = "http://localhost/phploginsystem/create-new-password.php?selector=".$selector."&validator=".bin2hex($token);

  // set token expire time to 1 hour
  $expires = date("U") + 1800;

  require "dbh.inc.php";

  $userEmail = $_POST['email'];

  $sql = "DELETE FROM pwdReset WHERE pwdResetEmail = ?";
  $stmt =mysqli_stmt_init($conn);
  
  if (!mysqli_stmt_prepare($stmt,$sql)) {
    echo "There was an error!";
    exit();
  }else{
    mysqli_stmt_bind_param($stmt, "s", $userEmail);
    mysqli_stmt_execute($stmt);
  }

  $sql = "INSERT INTO pwdReset (pwdResetEmail, pwdResetSelector, pwdResetToken, pwdResetExpires) VALUES (?,?,?,?);";

  $stmt =mysqli_stmt_init($conn);
  
  if (!mysqli_stmt_prepare($stmt,$sql)) {
    echo "There was an error!";
    exit();
  }else{
    $hashedToken = password_hash($token, PASSWORD_DEFAULT);
    mysqli_stmt_bind_param($stmt, "ssss", $userEmail, $selector, $hashedToken, $expires);
    mysqli_stmt_execute($stmt);
  }

  mysqli_stmt_close($stmt);
  // mysqli_close();

  // create email message
  // $to = $userEmail;
  // $subject = 'Reset your password';
  // $message = '<p>We received a password reset request. The link to reset your password is below. If you did not make this request, you can ignore this email</p>';
  // $message .= '<p>Here is your password reset link: <br>';
  // $message .= '<a href="' .$url . '">' .$url . '</a></p>';

  //Headers for email
  // $headers = "From: YourSite <yourmail@gmail.com>\r\n";
  // $headers .= "Reply-To: someemail@mail.com\r\n";
  // $headers .= "Content-type: text/html\r\n";

  // mail($to, $subject, $message, $headers);
  // header('location: ../reset-password.php?reset=success');
  // exit();
  

  // PHPMailer //

  require 'mail.inc.php';
























  
  
}else{
  header("Location: ../signup.php"); 
  exit();
} 