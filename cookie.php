<?php
if(@$_GET["id"]!=""){
  $cookie_name = "cartid";
  $cookie_value = $_GET["id"];

  if ($_COOKIE[$cookie_name] === $_GET["id"]) {
  }
  else
  if (strpos($_COOKIE[$cookie_name], $_GET["id"] . "-") !== false) {
  }
  else
  if (strpos($_COOKIE[$cookie_name], "-" . $_GET["id"]) !== false) {
  }
  else {
    if(!isset($_COOKIE[$cookie_name])) {
      setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");
    }
    else {
      setcookie($cookie_name, $cookie_value . "-" . $_COOKIE[$cookie_name], time() + (86400 * 30), "/");
    }
  }
}

else

if(@$_GET["removeid"]!=""){
  $cookie_name = "cartid";

  if (strpos($_COOKIE[$cookie_name], $_GET["removeid"] . "-") !== false) {
    setcookie($cookie_name, str_ireplace($_GET["removeid"] . "-", "", $_COOKIE[$cookie_name]), time() + (86400 * 30), "/");
  }
  else
  if (strpos($_COOKIE[$cookie_name], "-" . $_GET["removeid"]) !== false) {
    setcookie($cookie_name, str_ireplace("-" . $_GET["removeid"], "", $_COOKIE[$cookie_name]), time() + (86400 * 30), "/");
  }
  else {
    setcookie($cookie_name, str_ireplace($_GET["removeid"], "", $_COOKIE[$cookie_name]), time() + (86400 * 30), "/");
  }
}
?>
<body onload="window.close()">
