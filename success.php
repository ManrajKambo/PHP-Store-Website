<?php
  if($_POST["payment_status"]!=""){
    $title = $_POST["payment_status"];
  }
  else {
    $title = "Error";
  }

  include("config.php");
  include("html.php");

  if (isset($_SERVER['HTTP_COOKIE'])) {
    $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
    foreach($cookies as $cookie) {
      $parts = explode('=', $cookie);
      $name = trim($parts[0]);
      setcookie($name, '', time()-1000);
      setcookie($name, '', time()-1000, '/');
    }
  }

  $id = str_ireplace("-", ",", $_GET["cartid"]);

  $sql = "SELECT * FROM `items` WHERE id in (" . $id . ")";
  $sql = $con->query($sql);
  while($row = mysqli_fetch_array($sql)) {
    $arr[] = $row;
  }

  $i = 1;
?>
<div class="fade-in">

<?php
if ($_POST["payment_status"] === "Completed"){
?>
  <h1 class="customh1"><?php echo $title; ?></h1>
  <hr class="customhr"><br>

  <h2>Your order has successfully been processed.</h2>

  Invoice number: <?php echo $_POST["invoice"]; ?>
  <button onclick="copyText('<?php echo $_POST["invoice"]; ?>');" class="removeitem">Copy</button>

  <br>
  <br>

  <table>
    <thead>
      <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Address</th>
      </tr>
    </thead><tbody>
    <?php
      echo '<tr>
        <td>' . $_POST["first_name"] . " " . $_POST["last_name"] . '</td>
        <td>' . $_POST["payer_email"] . '</td>
        <td>' . $_POST["address_street"] . ", " . $_POST["address_city"] . ", " . $_POST["address_state"] . ", " . $_POST["address_zip"] . '</td>
      </tr>';
    ?>
    </tbody>
  </table><br>

  <table>
    <thead>
      <tr>
        <th>Name</th>
        <th>Quantity</th>
        <th>Total</th>
      </tr>
    </thead><tbody>
    <?php
    foreach ($arr as $arr) {
      echo '<tr>
        <td>' . $_POST["item_name" . $i] . '</td>
        <td>' . $_POST["quantity" . $i] . '</td>
        <td>' . $_POST["mc_currency"] . " $" . $_POST["mc_gross_" . $i] . '</td>
      </tr>';
    $i++;
    }
    ?>
    </tbody>
  </table><br>

  <?php
    echo 'Tax: ' . $_POST["mc_currency"] . " $" . $_POST["tax"] . '<p></p>
    Shipping: ' . $_POST["mc_currency"] . " $" . $_POST["shipping"] . '<p></p>
    Total: ' . $_POST["mc_currency"] . " $" . $_POST["mc_gross"] . '<p></p><br>';
  ?>

  <form>
    <input class="removeitem" type="button" name="print" value="Print this page" onClick="window.print()">
  </form>

<?php
}
else
if ($_POST["payment_status"] === "Pending"){
?>
  <h1 class="customh1"><?php echo $title; ?></h1>
  <hr class="customhr"><br>

  <h2>Your order is pending.</h2>

  Invoice number: <?php echo $_POST["invoice"]; ?>
  <button onclick="copyText('<?php echo $_POST["invoice"]; ?>');" class="removeitem">Copy</button>

  <br>
  <br>

  <table>
    <thead>
      <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Address</th>
      </tr>
    </thead><tbody>
    <?php
      echo '<tr>
        <td>' . $_POST["first_name"] . " " . $_POST["last_name"] . '</td>
        <td>' . $_POST["payer_email"] . '</td>
        <td>' . $_POST["address_street"] . ", " . $_POST["address_city"] . ", " . $_POST["address_state"] . ", " . $_POST["address_zip"] . '</td>
      </tr>';
    ?>
    </tbody>
  </table><br>

  <table>
    <thead>
      <tr>
        <th>Name</th>
        <th>Quantity</th>
        <th>Total</th>
      </tr>
    </thead><tbody>
    <?php
    foreach ($arr as $arr) {
      echo '<tr>
        <td>' . $_POST["item_name" . $i] . '</td>
        <td>' . $_POST["quantity" . $i] . '</td>
        <td>' . $_POST["mc_currency"] . " $" . $_POST["mc_gross_" . $i] . '</td>
      </tr>';
    $i++;
    }
    ?>
    </tbody>
  </table><br>

  <?php
    echo 'Tax: ' . $_POST["mc_currency"] . " $" . $_POST["tax"] . '<p></p>
    Shipping: ' . $_POST["mc_currency"] . " $" . $_POST["shipping"] . '<p></p>
    Total: ' . $_POST["mc_currency"] . " $" . $_POST["mc_gross"] . '<p></p><br>';
  ?>

  <form>
    <input class="removeitem" type="button" name="print" value="Print this page" onClick="window.print()">
  </form>
<?php
}
else
if ($_POST["payment_status"] === "Refunded"){
?>

  <h1 class="customh1"><?php echo $title; ?></h1>
  <hr class="customhr"><br>

  <h2>Your order has successfully been refunded.</h2>

  Invoice number: <?php echo $_POST["invoice"]; ?>
  <button onclick="copyText('<?php echo $_POST["invoice"]; ?>');" class="removeitem">Copy</button>

  <br>
  <br>

  <table>
    <thead>
      <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Address</th>
      </tr>
    </thead><tbody>
    <?php
      echo '<tr>
        <td>' . $_POST["first_name"] . " " . $_POST["last_name"] . '</td>
        <td>' . $_POST["payer_email"] . '</td>
        <td>' . $_POST["address_street"] . ", " . $_POST["address_city"] . ", " . $_POST["address_state"] . ", " . $_POST["address_zip"] . '</td>
      </tr>';
    ?>
    </tbody>
  </table><br>

  <table>
    <thead>
      <tr>
        <th>Name</th>
        <th>Quantity</th>
        <th>Total</th>
      </tr>
    </thead><tbody>
    <?php
    foreach ($arr as $arr) {
      echo '<tr>
        <td>' . $_POST["item_name" . $i] . '</td>
        <td>' . $_POST["quantity" . $i] . '</td>
        <td>' . $_POST["mc_currency"] . " $" . $_POST["mc_gross_" . $i] . '</td>
      </tr>';
    $i++;
    }
    ?>
    </tbody>
  </table><br>

  <?php
    echo 'Tax: ' . $_POST["mc_currency"] . " $" . $_POST["tax"] . '<p></p>
    Shipping: ' . $_POST["mc_currency"] . " $" . $_POST["shipping"] . '<p></p>
    Total: ' . $_POST["mc_currency"] . " $" . $_POST["mc_gross"] . '<p></p><br>';
  ?>

  <form>
    <input class="removeitem" type="button" name="print" value="Print this page" onClick="window.print()">
  </form>

<?php
}
else {
?>
  <h1 class="customh1"><?php echo $title; ?></h1>
  <hr class="customhr"><br>

  <h2>Invalid request method.</h2>
  <?php
}
    include("footer.php");
  ?>
