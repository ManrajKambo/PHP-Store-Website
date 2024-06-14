<?php
include("config.php");

if(@$_POST["invoice"]!=""){
  $decode = str_rot13(base64_decode($_POST["invoice"]));

  $split = explode("|", $decode);

  $sql = "SELECT * FROM `items` WHERE id in (" . $split["1"] . ")";
  $sql = $con->query($sql);
  while($row = mysqli_fetch_array($sql)) {
    $arr[] = $row;
  }

  if (empty($arr)) {
    echo '<body onload="alert(' . "'Not found.'" . '); window.location = ' . "'" . $_SERVER['PHP_SELF'] . "'" . ';">';
  }
  else {
    foreach ($arr as $arr) {
      $name.=  " - " . $arr[name] . "\n";
    }

    header("Content-Type: text/plain");
    echo "Date & Time:\n  " . date("F d Y\n  h:i:s a", $split["0"]) . "\n\nItem name(s):\n" . $name;
  }
}
else {
  echo '<link rel="stylesheet" type="text/css" href="style.css' . $epoch . '">
  <link rel="stylesheet" type="text/css" href="admin.css' . $epoch . '">
  <center><div id="div"><h1>Invoice lookup</h1><hr class="customhr"><br><br>
  <form action="' . $_SERVER['PHP_SELF'] . '" method="post">
    <label for="invoice">Invoice Number</label>
    <input type="text" id="invoice" name="invoice"><br>
    <input type="submit" value="Submit">
  </form></div></center>';
}
