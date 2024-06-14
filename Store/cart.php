<?php
  $title = "Cart";

  include("config.php");
  include("html.php");
?>
<div class="fade-in">
  <h1 class="customh1"><?php echo $title; ?></h1>
  <hr class="customhr"><br>

<?php
  $invoice = base64_encode(str_rot13(time() . "|" . str_ireplace("-", ", ", $_COOKIE["cartid"])));

  $notify = $loc . "/paypal.php?cartid=" . $_COOKIE["cartid"];
  $response = $loc . "/success.php?cartid=" . $_COOKIE["cartid"];
  $cancel = $loc . "/cart.php?error";

  if ($sandbox === "off"){
    $paypalwebscr = "https://www.paypal.com/cgi-bin/webscr";
  }
  else {
    $paypalwebscr = "https://www.sandbox.paypal.com/cgi-bin/webscr";
  }

  $id = str_ireplace("-", ",", $_COOKIE["cartid"]);

  $sql = "SELECT * FROM `items` WHERE NOT stock = '0' AND id in (" . $id . ")";
  $sql = $con->query($sql);
  while($row = mysqli_fetch_array($sql)) {
    $arr[] = $row;
  }

  $i = 1;

  if (empty($arr)) {
    echo "<h3>Cart is empty.</h3>";
  }
  else {

    if(isset($_GET["error"])){
      echo '<body onload="alert(' . "'There was an error processing your order.'" . ')">';
    }
?>

<div class="product">
  <button onclick="deleteAllCookies(); window.location.reload();">Empty cart</button>
</div>

<br><br>

<form action="<?php echo $paypalwebscr; ?>" method="POST">
  <input type="hidden" name="cmd" value="_cart">
  <input type="hidden" name="upload" value="1">
  <input type="hidden" name="business" value="<?php echo $paypalemail; ?>">
  <input type="hidden" name="currency_code" value="<?php echo $currency; ?>">

  <input type="hidden" name="invoice" value='<?php echo $invoice; ?>'>
  <input type="hidden" name="weight_unit" value='lbs'>

  <input type="hidden" name="tax_rate_1" value="5">

  <table>
    <thead>
      <tr>
        <th>Image</th>
        <th>Name</th>
        <th>Quantity</th>
        <th>Cost</th>
        <th>Remove</th>
      </tr>
    </thead><tbody>
    <?php
    foreach ($arr as $arr) {
      echo '<tr>
        <td>' . str_ireplace('src=""', 'src="' . $imagesdir . "/" . $noimage . '"', '<img src="' . $arr["image"] . '" class="image" style="width:75px;height:75px;">') . '</td>
        <td>' . $arr["name"] . '</td>
        <td><input type="hidden" name="item_name_' . $i . '" value="' . $arr["name"] . '">
            <input type="hidden" name="amount_' . $i . '" value="' . $arr["price"] . '">
            <input type="hidden" name="item_number_' . $i . '" value="' . $arr["id"] . '">
            <input type="hidden" name="weight_' . $i . '" value="' . $arr["weight"] . '">
            <select name="quantity_' . $i . '">';
              foreach (range(1, $arr["stock"]) as $number) {
                echo '<option value='.$number.'>'.$number.'</option>';
              }
            echo '</select>
        </td>
        <td>' . $currency . " $" . $arr["price"] . '</td>
        <td><a href="cookie.php?removeid=' . $arr["id"] . '" target=”_blank” onclick="setTimeout(location.reload.bind(location), 190);" class="removeitem">Remove</a></td>
      </tr>';
    $i++;
    }
    ?>
    </tbody>
  </table><br>

  <input type="hidden" name="notify_url" value='<?php echo $notify; ?>'>
  <input type="hidden" name="return" value='<?php echo $response; ?>'>
  <input type="hidden" name="rm" value='2'>
  <input type="hidden" name="cancel_return" value='<?php echo $cancel; ?>'>

  <input type="submit" name="submit" value='Checkout'>
</form>
<?php
}
include("footer.php");
?>
