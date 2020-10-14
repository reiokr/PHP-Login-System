<?php
  include_once "header.php";
  if(!isset($_SESSION['useruid'])){
    header("Location: index.php");
  }
  ?>
<section class="index-intro">
  <p>Name: <?php echo $_SESSION['username']?></p>
  <p>Username: <?php echo $_SESSION['useruid']?></p>
  <p>Email: <?php echo $_SESSION['useremail']?></p>
  <p>Profile created: <?php echo $_SESSION['reg_date']?></p>
</section>
< <?php
  include_once "footer.php";
  ?>