<?php
defined("INCLUDED") || include("error.php");
include("config.php");

$sql = "SELECT * FROM `items` WHERE category LIKE '" . $category . "'";
$sql = $con->query($sql);
while($row = mysqli_fetch_array($sql)) {
  $code[] = $code1 . $row["image"] . $code2 . $row["name"] . $code3 . $row["price"] . $code4 . $row["stock"] . $code5 . $row["id"] . $code6;

  $arrayone[] = array(
    "image" => $row["image"],
    "name" => $row["name"],
    "price" => $row["price"],
    "stock" => $row["stock"],
    "weight" => $row["weight"]
  );
  foreach ($arrayone as $key => $node) {
    $price[$key] = $node["price"];
  }
  array_multisort($price, SORT_ASC, $arrayone);

  $arraytwo[] = array(
    "image" => $row["image"],
    "name" => $row["name"],
    "price" => $row["price"],
    "stock" => $row["stock"],
    "weight" => $row["weight"]
  );
  foreach ($arraytwo as $key => $node) {
    $name[$key] = $node["name"];
  }
  array_multisort($name, SORT_NATURAL, $arraytwo);
}
include("get.php");
echo $fix;
