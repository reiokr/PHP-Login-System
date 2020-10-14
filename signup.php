  <?php
  include_once "header.php";
  if(isset($_SESSION['useruid'])){
    header("Location: index.php");
    exit();
  }
  ?>
  <section class="index-intro">
    <h2>Sing UP </h2>
    <form action="includes/signup.inc.php" method="post">
      <input type="text" name="name" placeholder="Full name..." value="<?php if (isset($_GET['name'])) echo $_GET['name'];
        else echo ""; ?>">
      <input type="text" name="email" placeholder="Email..." value="<?php if (isset($_GET['email'])) echo $_GET['email'];
      else echo ""; ?>">
      <input type="text" name="uid" placeholder="Username. .." value="<?php if (isset($_GET['uid'])) echo $_GET['uid'];
      else echo ""; ?>">
      <input type="password" name="pwd" placeholder="Password...">
      <input type="password" name="pwdrepeat" placeholder="Repeat password...">
      <button type="submit" name="submit">Submit</button>

      <?php
        if(isset($_GET['error'])){
          if ($_GET['error'] === "emptyinput") {
            echo "<p class='error-msg'>Please fill all fields!</p>";
          }
          if ($_GET['error'] === "invaliduid") {
            echo "<p class='error-msg'>Invalid username!</p>";
          }
          if ($_GET['error'] === "invalidemail") {
            echo "<p class='error-msg'>Invalid email!</p>";
          }
          if ($_GET['error'] === "invalidpwd") {
            echo "<p class='error-msg'>Invalid password!</p>";
          }
          if ($_GET['error'] === "pwdnotmatch") {
            echo "<p class='error-msg'>Password do not match!</p>";
          }
          if ($_GET['error'] === "userexist") {
            echo "<p class='error-msg'>Username already taken!</p>";
          }
          if ($_GET['error'] === "emailexist") {
            echo "<p class='error-msg'>Email already registered!</p>";
          }
          if ($_GET['error'] === "stmtuserfail") {
            echo "<p class='error-msg'>Database error!</p>";
          }
          if ($_GET['error'] === "stmtfail") {
            echo "<p class='error-msg'>Database error!</p>";
          }
          if ($_GET['error'] === "none") {
            echo "<p class='error-msg'><span style='color: green;'>You have signed up and can now log in!</span></p>";
          }
        }

        ?>
    </form>
  </section>

  <?php
  include_once "footer.php";
  ?>