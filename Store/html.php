<?php
defined("INCLUDED") || include("error.php");

echo '<!DOCTYPE html>
<html><head>
  <title>' . $title . '</title>

  <meta name="theme-color" content="#ffffff">
  <link rel="manifest" href="site.webmanifest">
  <link rel="icon" type="image/png" href="favicon.ico">
  <meta name="msapplication-TileColor" content="#da532c">
  <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">

  <script src="script.js' . $epoch . '"></script>
  <link rel="stylesheet" type="text/css" href="style.css' . $epoch . '">
  <meta name="viewport" content="width=device-width,initial-scale=0.80,maximum-scale=0.80,user-scalable=no">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head><body onselectstart="return false">
<center>';

$sql = "SELECT * FROM `tabs` ORDER BY id ASC";
$sql = $con->query($sql);
while($row = mysqli_fetch_array($sql)) {
  $tabs[] = $row["tabs"];
}

foreach ($tabs as $tabs) {
  $str.= '  <a href="' . $tabs . '.php"';
  if ($filename . ".php" === $tabs . '.php'){
    $str.= ' class="active"';
  }
  $str.= '>' .ucfirst($tabs) . '</a>' . "\n";
}
?>
<div class="topnav">
  <a href="home.php"<?php if ($filename . ".php" === 'home.php'){echo ' class="active"';}?>>Home</a>
<?php echo $str; ?>
  <a onclick="openSearch()"<?php if ($filename . ".php" === 'search.php'){echo ' class="active"';}?>>Search</a>
  <a style="float: right;" href="cart.php"<?php if ($filename . ".php" === 'cart.php'){echo ' class="active"';}?>>View Cart</a>
</div>
<div id="myOverlay" class="overlay">
  <span class="closebtn" onclick="closeSearch()" title="Close Overlay">×</span>
  <div class="overlay-content">
    <form action="search.php" method="post">
      <input type="text" placeholder="Search" name="search">
      <button type="submit"><i class="fa fa-search"></i></button>
    </form>
  </div>
</div>
