<?php
$title = "Search";

include("config.php");
include("html.php");

$search_value = $_POST["search"];

$sql = "SELECT * FROM `items` WHERE name LIKE '%" . $search_value . "%'";
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
?>

<div class="fade-in">
  <h1 class="customh1"><?php echo $title; ?></h1>
  <hr class="customhr"><br>

  <?php
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
      include("sort.php");
    }
    include("get.php");
    echo $fix;
    include("footer.php");
  ?>
