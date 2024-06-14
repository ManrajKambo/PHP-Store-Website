<?php
define("INCLUDED", true);
include("configarray.php");

$cache = $configarray["cache"];
$sandbox = $configarray["sandbox"];
$link = $configarray["link"];
$currency = $configarray["currency"];
$imagesdir = $configarray["imagesdir"];
$noimage = $configarray["noimage"];
$gmailemail = $configarray["gmailemail"];
$gmailpassword = $configarray["gmailpassword"];
$adminusername = $configarray["adminusername"];
$adminpassword = $configarray["adminpassword"];
$mysqlhost = $configarray["mysqlhost"];
$mysqlusername = $configarray["mysqlusername"];
$mysqlpassword = $configarray["mysqlpassword"];
$mysqldatabase = $configarray["mysqldatabase"];
$contactemail = $configarray["contactemail"];

$con = mysqli_connect($mysqlhost, $mysqlusername, $mysqlpassword, $mysqldatabase);
if (mysqli_connect_errno()){
  echo '<center><br><h1>Configuration error.</h1><hr class="customhr"><br>Connection failed: ' . mysqli_connect_error() . "<br><br>Modify 'configarray.php'.</center>";
}

if ($sandbox === "off"){
  $paypalemail = $configarray["paypalemail"];
}
else {
  $paypalemail = $configarray["paypalsandboxemail"];
}

if ($cache === "off"){
  $epoch = "?time=" . time();
}
else {
  $epoch = "";
}

if ($link === "http"){
  $loc = "http://" . $_SERVER['SERVER_NAME'] . ":80";
}
else
if ($link === "https"){
  $loc = "https://" . $_SERVER['SERVER_NAME'] . ":443";
}
else
if ($link === "auto"){
  $loc = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['SERVER_NAME'] . ":" . $_SERVER['SERVER_PORT'];
}

$filename = basename($_SERVER["SCRIPT_FILENAME"], '.php');

$code1 = '<div class="product"><p></p><img src="';
$code2 = '" class="image"><h1>';
$code3 = '</h1><p class="price">' . $currency . ' $';
$code4 = '</p><p font="small">Stock: ';
$code5 = ' </p><button onclick="alert(' . "'Successfully added item.'" . '); window.open(' . "'cookie.php?id=";
$code6 = "'" . ');">Add to Cart</button><p></p></div>';
