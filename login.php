  <?php
  include_once "header.php";
  if(isset($_SESSION['useruid'])){
    header("Location: index.php");
    exit();
  }
  ?>
  <section class="index-intro">
    <h2>Log in</h2>
    <form action="includes/login.inc.php" method="post">
      <input type="text" name="uid" placeholder="Username/Email"
        value="<?php if (isset($_GET['uid'])) {echo $_GET['uid'];} else {echo "";} ?>">
      <input type="password" name="pwd" placeholder="Password...">
      <button type="submit" name="submit">Log In</button>
      <a href="reset-password.php">Forgot your password?</a>
      <?php
        if(isset($_GET['error'])){
          if ($_GET['error'] === "emptyinput") {
            echo "<p class='error-msg'>You need to fill all fields!</p>";
          }
  
          if ($_GET['error'] === "stmtuserfail") {
            echo "<p class='error-msg'>Database error!</p>";
          }
          if ($_GET['error'] === "wronglogin") {
            echo "<p class='error-msg'>Login failed. Wrong username or password!</p>";
          }
          if ($_GET['error'] === "none") {
            echo "<p class='error-msg'><span style='color: green;'>You have signed up and can now log in!</span></p>";
          }
        }
        if(isset($_GET['newpwd'])){
          if($_GET['newpwd']==="passwordupdated"){
            echo "<p class='success-msg'>Password updated! You can log in now!</p>";
          }
        }
        ?>
    </form>
  </section>

  <?php
  include_once "footer.php";
  ?>