<?php
include("config.php");

$i = 1;

$raw_post_data = file_get_contents('php://input');
$raw_post_array = explode('&', $raw_post_data);
$myPost = array();
foreach ($raw_post_array as $keyval) {
  $keyval = explode ('=', $keyval);
  if (count($keyval) == 2)
     $myPost[$keyval[0]] = urldecode($keyval[1]);
}
$req = 'cmd=_notify-validate';
if(function_exists('get_magic_quotes_gpc')) {
   $get_magic_quotes_exists = true;
}
foreach ($myPost as $key => $value) {
   if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
        $value = urlencode(stripslashes($value));
   } else {
        $value = urlencode($value);
   }
   $req .= "&$key=$value";
}

if ($sandbox === "off"){
  $paypalwebscr = "https://ipnpb.paypal.com/cgi-bin/webscr";
}
else {
  $paypalwebscr = "https://ipnpb.sandbox.paypal.com/cgi-bin/webscr";
}

$ch = curl_init($paypalwebscr);
curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));

if( !($res = curl_exec($ch)) ) {
    error_log("Got " . curl_error($ch) . " when processing IPN data");
    curl_close($ch);
    exit;
}
curl_close($ch);

if (strcmp ($res, "VERIFIED") == 0) {
    $id = str_ireplace("-", ",", $_GET["cartid"]);

    $sql = "SELECT * FROM `items` WHERE id in (" . $id . ")";
    $sql = $con->query($sql);
    while($row = mysqli_fetch_array($sql)) {
      $arr[] = $row;
    }

    if ($_POST["payment_status"] === "Completed"){
      $response = '<center><h1>' . $_POST["payment_status"] . '</h1>Invoice number: ' . $_POST["invoice"] . '<br><table>
        <thead>
          <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Address</th>
          </tr>
        </thead><tbody>
          <tr>
            <td>' . $_POST["first_name"] . " " . $_POST["last_name"] . '</td>
            <td>' . $_POST["payer_email"] . '</td>
            <td>' . $_POST["address_street"] . ", " . $_POST["address_city"] . ", " . $_POST["address_state"] . ", " . $_POST["address_zip"] . '</td>
          </tr>
        </tbody>
      </table><br>

      <table>
        <thead>
          <tr>
            <th>Name</th>
            <th>Quantity</th>
            <th>Total</th>
          </tr>
        </thead><tbody>';
        foreach ($arr as $arr) {
          $response.=  '<tr>
            <td>' . $_POST["item_name" . $i] . '</td>
            <td>' . $_POST["quantity" . $i] . '</td>
            <td>' . $_POST["mc_currency"] . " $" . $_POST["mc_gross_" . $i] . '</td>
          </tr>';
          $array[] = array("item_name" => $_POST["item_name" . $i], "quantity" =>  $_POST["quantity" . $i], "stock" => $arr["stock"]);
        $i++;
        }
      $response.= '</tbody>
      </table><br>

      Tax: ' . $_POST["mc_currency"] . " $" . $_POST["tax"] . '<p></p>
      Total: ' . $_POST["mc_currency"] . " $" . $_POST["mc_gross"] . '<p></p>
      Paid: ' . $_POST["mc_currency"] . " $" . $_POST["mc_gross"];

      foreach ($array as $array) {
        $sum = $array["stock"] - $array["quantity"];
        $sql = "UPDATE `items` SET stock=" . $sum . "  WHERE name='" . $array["item_name"] . "'; ";
        if ($con->query($sql) === TRUE) {
          echo "Record updated successfully";
        } else {
          echo "Error updating record: " . $con->error;
        }
      }
    }
    else
    if ($_POST["payment_status"] === "Pending"){
      $response = '<center><h1>' . $_POST["payment_status"] . '</h1>Invoice number: ' . $_POST["invoice"] . '<br><table>
        <thead>
          <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Address</th>
          </tr>
        </thead><tbody>
          <tr>
            <td>' . $_POST["first_name"] . " " . $_POST["last_name"] . '</td>
            <td>' . $_POST["payer_email"] . '</td>
            <td>' . $_POST["address_street"] . ", " . $_POST["address_city"] . ", " . $_POST["address_state"] . ", " . $_POST["address_zip"] . '</td>
          </tr>
        </tbody>
      </table><br>

      <table>
        <thead>
          <tr>
            <th>Name</th>
            <th>Quantity</th>
            <th>Total</th>
          </tr>
        </thead><tbody>';
        foreach ($arr as $arr) {
          $response.=  '<tr>
            <td>' . $_POST["item_name" . $i] . '</td>
            <td>' . $_POST["quantity" . $i] . '</td>
            <td>' . $_POST["mc_currency"] . " $" . $_POST["mc_gross_" . $i] . '</td>
          </tr>';
          $array[] = array("item_name" => $_POST["item_name" . $i], "quantity" =>  $_POST["quantity" . $i], "stock" => $arr["stock"]);
        $i++;
        }
      $response.= '</tbody>
      </table><br>

      Tax: ' . $_POST["mc_currency"] . " $" . $_POST["tax"] . '<p></p>
      Total: ' . $_POST["mc_currency"] . " $" . $_POST["mc_gross"] . '<p></p>
      Paid: ' . $_POST["mc_currency"] . " $" . $_POST["mc_gross"];

      foreach ($array as $array) {
        $sum = $array["stock"] - $array["quantity"];
        $sql = "UPDATE `items` SET stock=" . $sum . "  WHERE name='" . $array["item_name"] . "'; ";
        if ($con->query($sql) === TRUE) {
          echo "Record updated successfully";
        } else {
          echo "Error updating record: " . $con->error;
        }
      }
    }
    else
    if ($_POST["payment_status"] === "Refunded"){
      $response = '<center><h1>' . $_POST["payment_status"] . '</h1>Invoice number: ' . $_POST["invoice"] . '<br><table>
        <thead>
          <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Address</th>
          </tr>
        </thead><tbody>
          <tr>
            <td>' . $_POST["first_name"] . " " . $_POST["last_name"] . '</td>
            <td>' . $_POST["payer_email"] . '</td>
            <td>' . $_POST["address_street"] . ", " . $_POST["address_city"] . ", " . $_POST["address_state"] . ", " . $_POST["address_zip"] . '</td>
          </tr>
        </tbody>
      </table><br>

      <table>
        <thead>
          <tr>
            <th>Name</th>
            <th>Quantity</th>
            <th>Total</th>
          </tr>
        </thead><tbody>';
        foreach ($arr as $arr) {
          $response.=  '<tr>
            <td>' . $_POST["item_name" . $i] . '</td>
            <td>' . $_POST["quantity" . $i] . '</td>
            <td>' . $_POST["mc_currency"] . " $" . $_POST["mc_gross_" . $i] . '</td>
          </tr>';
          $array[] = array("item_name" => $_POST["item_name" . $i], "quantity" =>  $_POST["quantity" . $i], "stock" => $arr["stock"]);
        $i++;
        }
      $response.= '</tbody>
      </table><br>

      Total: ' . $_POST["mc_currency"] . " $" . str_ireplace("-", "", $_POST["mc_gross"]) . '<p></p>
      Refunded: ' . $_POST["mc_currency"] . " $" . str_ireplace("-", "", $_POST["mc_gross"]);

      foreach ($array as $array) {
        $sum = $array["stock"] + $array["quantity"];
        $sql = "UPDATE `items` SET stock=" . $sum . "  WHERE name='" . $array["item_name"] . "'; ";
        if ($con->query($sql) === TRUE) {
          echo "Record updated successfully";
        } else {
          echo "Error updating record: " . $con->error;
        }
      }
    }
    else {
      $response = "<h1>" . $_POST["payment_status"] . "</h1><br>IPN response invalid<br>";

      $response.= $_POST['item_name'] . $_POST['item_number'] . $_POST['payment_status'] .
      $_POST['mc_gross'] . $_POST['mc_currency'] . $_POST['txn_id'] .
      $_POST['receiver_email'] . $_POST['payer_email'];
    }

    // https://github.com/swiftmailer/swiftmailer.git
      require_once '/var/www/api/vendor/autoload.php';
try {
    $transport = (new Swift_SmtpTransport('smtp.googlemail.com', 465, 'ssl'))
      ->setUsername($gmailemail)
      ->setPassword($gmailpassword)
    ;
    $mailer = new Swift_Mailer($transport);
    $message = (new Swift_Message('PayPal IPN - ' . $_POST["payment_status"]))
      ->setFrom(['donotreply@' . $_SERVER['SERVER_NAME'] => 'Server'])
      ->setTo([$gmailemail])
      ->setBody($response)
      ->setContentType('text/html')
    ;
    $mailer->send($message);
} catch(Exception $e) {
    echo $e->getMessage();
}






} else if (strcmp ($res, "INVALID") == 0) {
}
?>
