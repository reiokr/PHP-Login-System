<?php
  include_once "header.php";
  if(isset($_SESSION['useruid'])){
    header("Location: index.php");
    exit();
  }
  ?>
<section class="index-intro">
  <?php
$selector = $_GET['selector'];
$validator = $_GET['validator'];
if(empty($selector) || empty($validator)){
  echo "Could not validate your request!";
}else{
  if(ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false){
  ?>
  <h2>Create new password</h2>
  <form action="includes/reset-password.inc.php" method="post">
    <input type="hidden" name="selector" value="<?php echo $selector ?>">
    <input type="hidden" name="validator" value="<?php echo $validator ?>">
    <input type="password" name="pwd" placeholder="Enter a new password...">
    <input type="password" name="pwdrepeat" placeholder="Repeat password...">
    <button type="submit" name="reset-pwd-submit">Reset password</button>
  </form>

  <?php  
  }
  }
  ?>
  <?php
  if(isset($_GET['reset'])){
  if($_GET['reset']==="success") {
  echo '<p class="success-msg">Check your e-mail!</p>';
  }
  if($_GET['reset']==="error") {
  echo '<p class="error-msg">Message could not be sent!</p>';
  }
  
  }
  ?>
</section>

<?php
  include_once "footer.php";
  ?>