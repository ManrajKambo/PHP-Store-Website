<?php
  $title = "Home";

  include("config.php");
  include("html.php");
?>
<div class="fade-in">
  <h1 class="customh1"><?php echo $title; ?></h1>
  <hr class="customhr"><br>
  <h2>Welcome to <?php echo $_SERVER['SERVER_NAME']; ?></h2>
  <h3>To view all of our products click <a href="search.php">here</a>.</h3>

  <?php include("footer.php"); ?>
