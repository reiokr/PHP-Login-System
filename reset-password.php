<?php
  include_once "header.php";
  if(isset($_SESSION['useruid'])){
    header("Location: index.php");
    exit();
  }
  ?>
<section class="index-intro">
  <h2>Reset your password</h2>
  <p>An e-mail will be sent to you with instructions on how to reset your password.</p>
  <form action="includes/reset-request.inc.php" method="post">
    <input type="text" name="email" placeholder="Enter your email address...">
    <button type="submit" name="reset-request-submit">Reset password</button>
  </form>
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