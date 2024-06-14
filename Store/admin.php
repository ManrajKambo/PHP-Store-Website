<?php
include("config.php");

$authlogin = array($adminusername => $adminpassword);
$valid_passwords = $authlogin;
$valid_users = array_keys($valid_passwords);
$user = $_SERVER['PHP_AUTH_USER'];
$pass = $_SERVER['PHP_AUTH_PW'];
$validated = (in_array($user, $valid_users)) && ($pass == $valid_passwords[$user]);
if (!$validated) {
  header('WWW-Authenticate: Basic realm="Admin Panel"');
  header('HTTP/1.0 401 Unauthorized');
  header("Content-Type: text/plain");
  die('Not authorized');
}

echo '<title>Admin Panel</title>
<script src="script.js' . $epoch . '"></script>
<link rel="stylesheet" type="text/css" href="style.css' . $epoch . '">
<link rel="stylesheet" type="text/css" href="admin.css' . $epoch . '">
<meta name="viewport" content="width=device-width,initial-scale=0.80,maximum-scale=0.80,user-scalable=no">';

$sql="SELECT * FROM `items` ORDER BY id DESC";
$res=$con->query($sql);
while($row=$res->fetch_assoc()){
  $array[] = array(
    "Image" => str_ireplace('src=""', 'src="' . $imagesdir . "/" . $noimage . '"', '<img src="' . $row["image"] . '" class="image" style="width:75px;height:75px;">'),
    "Name" => $row["name"],
    "Price" => $currency . " $" . $row["price"],
    "Weight" => $row["weight"] . " lbs",
    "Stock" => $row["stock"],
    "Category" => '<a class="button" href="' . $row["category"] . '.php" target="_blank">' . ucfirst($row["category"]) . '</a>',
    "Edit" => '<a class="button" href="?edit=' . $row["id"] . '">Edit</a>',
    "Delete" => '<a class="button" href="?delete=' . $row["id"] . '" onclick="if(!confirm(\'Are you sure you want to delete this item?\')) return false;">Delete</a>'
  );
}

if (isset($_POST['uploadimage'])) {
  $currentDirectory = getcwd();
  $uploadDirectory = "/" . $imagesdir . "/";

  $errors = [];

  $fileExtensionsAllowed = ['jpeg','jpg','png','gif'];

  $fileName = $_FILES['the_file']['name'];
  $fileSize = $_FILES['the_file']['size'];
  $fileTmpName  = $_FILES['the_file']['tmp_name'];
  $fileType = $_FILES['the_file']['type'];
  $fileExtension = strtolower(end(explode('.',$fileName)));

  $uploadPath = $currentDirectory . $uploadDirectory . strtolower(basename($fileName));

  if (! in_array($fileExtension,$fileExtensionsAllowed)) {
    $errors[] = "This file extension is not allowed.";
  }

  if ($fileSize > 10000000) {
    $errors[] = "File exceeds maximum size (10MB)";
  }

  if (empty($errors)) {
    $didUpload = move_uploaded_file($fileTmpName, $uploadPath);

    if ($didUpload) {
      header('Location: ' . $_SERVER['PHP_SELF']);
      exit;
    }
    else {
      echo "An error occurred. Please contact the administrator.";
    }
  }
  else {
    foreach ($errors as $error) {
      echo $error . "\n";
    }
  }
}

else

if(isset($_POST["tabid"])){
  $sql = "SELECT * FROM `tabs` WHERE id = " . $_POST["tabid"];
  $sql = $con->query($sql);
  while($row = mysqli_fetch_array($sql)) {
    foreach (array($row["tabs"]) as $tab) {
      rename($tab . ".php", strtolower($_POST["tabname"]) . ".php");
    }
  }

  $sql = "UPDATE `tabs` SET `tabs` = '" . strtolower($_POST["tabname"]) . "' WHERE `tabs`.`id` = " . $_POST["tabid"];
  if ($con->query($sql) === TRUE) {
    echo "Record updated successfully";
  } else {
    echo "Error updating record: " . $con->error;
  }
  $con->close();

  header('Location: ' . $_SERVER['PHP_SELF']);
  exit;
}

else

if(isset($_POST["name"])){
  $id = $_POST["id"];
  $image = $_POST["image"];
  $name = $_POST["name"];
  $price = $_POST["price"];
  $weight = $_POST["weight"];
  $stock = $_POST["stock"];
  $category = $_POST["category"];

  $sql = "UPDATE `items` SET `image` = '" . $image . "', `name` = '" . $name . "', `price` = '" . $price . "', `weight` = '" . $weight . "', `stock` = '" . $stock . "', `category` = '" . $category . "' WHERE `items`.`id` = " . $id;
  if ($con->query($sql) === TRUE) {
    echo "Record updated successfully";
  } else {
    echo "Error updating record: " . $con->error;
  }
  $con->close();

  header('Location: ' . $_SERVER['PHP_SELF']);
  exit;
}

else

if(isset($_POST["addname"])){
  $image = $_POST["addimage"];
  $name = $_POST["addname"];
  $price = $_POST["addprice"];
  $weight = $_POST["addweight"];
  $stock = $_POST["addstock"];
  $category = $_POST["addcategory"];

  $sql = "INSERT INTO `items` (`image`, `name`, `price`, `weight`, `stock`, `category`) VALUES ('" . $image . "', '" . $name . "', '" . $price . "', '" . $weight . "', '" . $stock . "', '" . $category . "')";
  if ($con->query($sql) === TRUE) {
    echo "New record created successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $con->error;
  }
  $con->close();

  header('Location: ' . $_SERVER['PHP_SELF']);
  exit;
}

else

if(isset($_POST["renameimage"])){
  rename($imagesdir . "/" . $_POST["originalname"], $imagesdir . "/" . $_POST["renameimage"]);

  header('Location: ' . $_SERVER['PHP_SELF']);
  exit;
}

else

if(isset($_POST["currency"])){
  $configarray["cache"] = $_POST["cache"];
  $configarray["sandbox"] = $_POST["sandbox"];
  $configarray["link"] = $_POST["link"];

  $configarray["currency"] = $_POST["currency"];

  $configarray["imagesdir"] = $_POST["imagesdir"];
  $configarray["noimage"] = $_POST["noimage"];

  $configarray["adminusername"] = $_POST["adminusername"];
  $configarray["adminpassword"] = $_POST["adminpassword"];

  $configarray["paypalemail"] = $_POST["paypalemail"];
  $configarray["paypalsandboxemail"] = $_POST["paypalsandboxemail"];

  $configarray["gmailemail"] = $_POST["gmailemail"];
  $configarray["gmailpassword"] = $_POST["gmailpassword"];

  $configarray["mysqlhost"] = $_POST["mysqlhost"];
  $configarray["mysqlusername"] = $_POST["mysqlusername"];
  $configarray["mysqlpassword"] = $_POST["mysqlpassword"];
  $configarray["mysqldatabase"] = $_POST["mysqldatabase"];

  $configarray["contactemail"] = $_POST["contactemail"];

  $enc = json_encode($configarray);
  $fix = str_ireplace('{"', '$configarray = array(' . "\n  " . '"', $enc);
  $fix = str_ireplace('":"', '" => "', $fix);
  $fix = str_ireplace('","', '",' . "\n  " . '"', $fix);
  $fix = str_ireplace('"}', '"' . "\n" . ');', $fix);

  $code = "<?php" . "\n" . 'defined("INCLUDED") || include("error.php");' . "\n\n" . $fix;

  file_put_contents("configarray.php", $code);

  header('Location: ' . $_SERVER['PHP_SELF']);
  exit;
}

else

if(isset($_POST["createtab"])){
  $tabname = strtolower($_POST["createtab"]);

  $sql = "INSERT INTO `tabs` (`tabs`) VALUES ('" . $tabname . "')";
  if ($con->query($sql) === TRUE) {
    echo "New record created successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $con->error;
  }
  $con->close();

  $code = '<?php' . "\n" . '  include("config.php");' . "\n\n" . '  $title = ucfirst($filename);' . "\n" . '  $category = strtolower($title);' . "\n\n" . '  include("html.php");' . "\n" . '?>' . "\n" . '<div class="fade-in">' . "\n" . '  <h1 class="customh1"><?php echo $title; ?></h1>' . "\n" . '  <hr class="customhr"><br>' . "\n\n" . '  <?php' . "\n" . '    include("sort.php");' . "\n" . '    include("items.php");' . "\n" . '    include("footer.php");' . "\n" . '  ?>';

  file_put_contents($tabname . ".php", $code);

  header('Location: ' . $_SERVER['PHP_SELF']);
  exit;
}

else

if(isset($_GET["config"])){
  echo '<center><div id="div"><button class="block" onclick="goBack()">Go Back</button><h1>Configuration</h1><hr class="customhr"><br><form action="' . $_SERVER['PHP_SELF'] . '" method="post">';
  ?>
    <label for="cache">Enable css & javascript caching</label><br>
    <select id="cache" name="cache">
      <option value="on"<?php if ($configarray["cache"] === "on"){echo " " . "selected";}?>>Yes</option>
      <option value="off"<?php if ($configarray["cache"] === "off"){echo " " . "selected";}?>>No</option>
    </select><br>
    <label for="sandbox">Enable PayPal Sandbox</label><br>
    <select id="sandbox" name="sandbox">
      <option value="on"<?php if ($configarray["sandbox"] === "on"){echo " " . "selected";}?>>Yes</option>
      <option value="off"<?php if ($configarray["sandbox"] === "off"){echo " " . "selected";}?>>No</option>
    </select><br>
    <label for="link">URL protocol</label><br>
    <select id="link" name="link">
      <option value="auto"<?php if ($configarray["link"] === "auto"){echo " " . "selected";}?>>Automatic</option>
      <option value="http"<?php if ($configarray["link"] === "http"){echo " " . "selected";}?>>Http</option>
      <option value="https"<?php if ($configarray["link"] === "https"){echo " " . "selected";}?>>Https</option>
    </select><br><hr><br>
  <?php
  echo '<label for="currency">Currency</label><br>
    <input type="text" id="currency" name="currency" value="' . $configarray["currency"] . '" required><br><hr><br>

    <label for="imagesdir">Images Directory</label><br>
    <input type="text" id="imagesdir" name="imagesdir" value="' . $configarray["imagesdir"] . '" required><br><hr><br>
    <input type="hidden" id="noimage" name="noimage" value="' . $configarray["noimage"] . '" required>

    <label for="adminusername">Admin Panel Username</label><br>
    <input type="text" id="adminusername" name="adminusername" value="' . $configarray["adminusername"] . '" required><br>
    <label for="adminpassword">Admin Panel Password</label><br>
    <input type="text" id="adminpassword" name="adminpassword" value="' . $configarray["adminpassword"] . '" required><br><hr><br>

    <label for="paypalemail">PayPal Email</label><br>
    <input type="text" id="paypalemail" name="paypalemail" value="' . $configarray["paypalemail"] . '" required><br>
    <label for="paypalsandboxemail">PayPal Sandbox Email</label><br>
    <input type="text" id="paypalsandboxemail" name="paypalsandboxemail" value="' . $configarray["paypalsandboxemail"] . '" required><br><hr><br>

    <label for="gmailemail">Gmail Email Address</label><br>
    <input type="text" id="gmailemail" name="gmailemail" value="' . $configarray["gmailemail"] . '" required><br>
    <label for="gmailpassword">Gmail Password</label><br>
    <input type="text" id="gmailpassword" name="gmailpassword" value="' . $configarray["gmailpassword"] . '" required><br><hr><br>

    <label for="mysqlhost">MySQL Hostname</label><br>
    <input type="text" id="mysqlhost" name="mysqlhost" value="' . $configarray["mysqlhost"] . '" required><br>
    <label for="mysqlusername">MySQL Username</label><br>
    <input type="text" id="mysqlusername" name="mysqlusername" value="' . $configarray["mysqlusername"] . '" required><br>
    <label for="mysqlpassword">MySQL Password</label><br>
    <input type="text" id="mysqlpassword" name="mysqlpassword" value="' . $configarray["mysqlpassword"] . '" required><br>
    <label for="mysqldatabase">MySQL Database</label><br>
    <input type="text" id="mysqldatabase" name="mysqldatabase" value="' . $configarray["mysqldatabase"] . '" required><br><hr><br>

    <label for="contactemail">Contact Email</label><br>
    <input type="text" id="contactemail" name="contactemail" value="' . $configarray["contactemail"] . '" required><br><hr><br>

    <input class="button" type="submit" value="Submit" onclick="if(!confirm(' . "'" . 'Are you sure you want to submit these changes?' . "'" . ')) return false;">
  </form></div></center>';
}

else

if(isset($_GET["deleteallitems"])){
  $sql = "DELETE FROM `items`;";
  $sql.= "ALTER TABLE `items` AUTO_INCREMENT=1;";
  $result = mysqli_multi_query($con, $sql);

  header('Location: ' . $_SERVER['PHP_SELF']);
  exit;
}

else

if(isset($_GET["deletealltabs"])){
  $sql = "SELECT * FROM `tabs` ORDER BY id ASC";
  $sql = $con->query($sql);
  while($row = mysqli_fetch_array($sql)) {
    $tabs[] = $row["tabs"];
  }

  foreach ($tabs as $tabs) {
    unlink($tabs . '.php');
  }

  $sql = "DELETE FROM `tabs`;";
  $sql.= "ALTER TABLE `tabs` AUTO_INCREMENT=1;";
  $result = mysqli_multi_query($con, $sql);

  header('Location: ' . $_SERVER['PHP_SELF']);
  exit;
}

else

if(isset($_GET["deleteallimages"])){
  $images = array_diff(scandir($imagesdir, 1), array('.', '..', $noimage));

  foreach ($images as $images) {
    unlink($imagesdir . '/' . $images);
  }

  header('Location: ' . $_SERVER['PHP_SELF']);
  exit;
}

else

if(isset($_GET["renameimage"])){
  $imagename = base64_decode($_GET["renameimage"]);

  echo '<center><div id="div"><button class="block" onclick="goBack()">Go Back</button><h1>You are currently editing: ' . $imagename . '</h1><hr class="customhr"><br><form action="' . $_SERVER['PHP_SELF'] . '" method="post">
      <input type="hidden" id="originalname" name="originalname" value="' . $imagename . '">

      <label for="renameimage">Name</label><br>
      <input type="text" id="renameimage" name="renameimage" value="' . $imagename . '"><br>

      <input class="button" type="submit" value="Submit">
    </form></div></center>';
}

else

if(@$_GET["deletetab"]!=""){
  $sql = "SELECT * FROM `tabs` WHERE id = " . $_GET["deletetab"];
  $sql = $con->query($sql);
  while($row = mysqli_fetch_array($sql)) {
    foreach (array($row["tabs"]) as $tab) {
      unlink($tab . ".php");
    }
  }

  $sql = "DELETE FROM `tabs` WHERE id = " . $_GET["deletetab"];
  if ($con->query($sql) === TRUE) {
    echo "Record deleted successfully";
  } else {
    echo "Error deleting record: " . $con->error;
  }
  $con->close();

  header('Location: ' . $_SERVER['PHP_SELF']);
  exit;
}


else

if(@$_GET["deleteimage"]!=""){
  unlink($imagesdir . "/" . base64_decode($_GET["deleteimage"]));

  header('Location: ' . $_SERVER['PHP_SELF']);
  exit;
}

else

if(@$_GET["delete"]!=""){
  $id = $_GET["delete"];

  $sql = "DELETE FROM `items` WHERE id = " . $id;
  if ($con->query($sql) === TRUE) {
    echo "Record deleted successfully";
  } else {
    echo "Error deleting record: " . $con->error;
  }
  $con->close();

  header('Location: ' . $_SERVER['PHP_SELF']);
  exit;
}

else

if(@$_GET["edit"]!=""){
  $id = $_GET["edit"];

  $sql = "SELECT * FROM `items` WHERE id = '" . $id . "'";
  $sql = $con->query($sql);
  while($row = mysqli_fetch_array($sql)) {
    echo '<center><div id="div"><button class="block" onclick="goBack()">Go Back</button><h1>You are currently editing ID: ' . $row["id"] . '</h1><hr class="customhr"><br><form action="' . $_SERVER['PHP_SELF'] . '" method="post">
      <input type="hidden" id="id" name="id" value="' . $row["id"] . '">

      <label for="image">Image</label><br>
      <input type="text" id="image" name="image" value="' . $row["image"] . '"><br>

      <label for="name">Name *</label><br>
      <input type="text" id="name" name="name" value="' . $row["name"] . '" required><br>

      <label for="price">Price *</label><br>
      <input type="text" id="price" name="price" value="' . $row["price"] . '" oninput="this.value = this.value.replace(/[^0-9.]/g, ' . "''" . ').replace(/(\..*)\./g, ' . "'$1'" . ');" required><br>

      <label for="weight">Weight (lbs)</label><br>
      <input type="text" id="weight" name="weight" value="' . $row["weight"] . '"><br>

      <label for="stock">Stock *</label><br>
      <input type="text" id="stock" name="stock" value="' . $row["stock"] . '" oninput="this.value = this.value.replace(/[^0-9.]/g, ' . "''" . ').replace(/(\..*)\./g, ' . "'$1'" . ');" required><br>

      <label for="category">Category *</label><br>
      <input type="text" id="category" name="category" value="' . $row["category"] . '" required><br>

      <input class="button" type="submit" value="Submit">
    </form></div></center>';
  }
}

else

if(@$_GET["edittab"]!=""){
  $sql = "SELECT * FROM `tabs` WHERE id = " . $_GET["edittab"];
  $sql = $con->query($sql);
  while($row = mysqli_fetch_array($sql)) {
    foreach (array($row["tabs"]) as $tab) {
      echo '<center><div id="div"><button class="block" onclick="goBack()">Go Back</button><h1>You are currently editing tab: ' . $tab . '</h1><hr class="customhr"><br><form action="' . $_SERVER['PHP_SELF'] . '" method="post">
        <input type="hidden" id="tabid" name="tabid" value="' . $_GET["edittab"] . '">

        <label for="tabname">Name *</label><br>
        <input type="text" id="tabname" name="tabname" value="' . $tab . '" required><br>

        <input class="button" type="submit" value="Submit">
      </form></div></center>';
    }
  }
}

else {
?>
<button class="tablink" onclick="openPage('Home', this, 'blue')" id="defaultOpen">Home</button>
<button class="tablink" onclick="openPage('Add', this, 'blue')">Add</button>
<button class="tablink" onclick="openPage('Manage', this, 'blue')">Manage</button>
<button class="tablink" onclick="logout();">Logout</button>

<br>

<div id="Home" class="tabcontent">
  <center>
    <h1>Home</h1>
    <hr class="customhr"><br>

    <iframe src="index.php" title="Visit Website" frameborder="1" style="overflow:hidden;height:100%;width:100%" height="100%" width="100%"><a class="button" href="index.php" target="_blank">Visit Website</a></iframe>
    <br><br>
  </center>
</div>

<div id="Add" class="tabcontent">
  <center>
    <h1>Add</h1>
    <hr class="customhr">

    <h2>Add new item</h2>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
      <label for="addimage">Image</label><br>
      <input type="text" id="addimage" name="addimage"><br>

      <label for="addname">Name *</label><br>
      <input type="text" id="addname" name="addname" required><br>

      <label for="addprice">Price *</label><br>
      <input type="text" id="addprice" name="addprice" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required><br>

      <label for="addweight">Weight (lbs)</label><br>
      <input type="text" id="addweight" name="addweight"><br>

      <label for="addstock">Stock *</label><br>
      <input type="text" id="addstock" name="addstock" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required><br>

      <label for="addcategory">Category *</label><br>
      <input type="text" id="addcategory" name="addcategory" required><br>

      <input class="button" type="submit" value="Submit">
    </form><br>

    <hr class="customhr">

    <h2>Upload a Image</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
      <input type="hidden" name="uploadimage" value="uploadimage" id="uploadimage">

      <input type="file" name="the_file"><br><br>
      <input class="button" type="submit" name="submit" value="Upload">
    </form><br>

    <hr class="customhr">

    <h2>Create new tab</h2>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
      <label for="createtab">Name</label><br>
      <input type="text" id="createtab" name="createtab" required><br>

      <input class="button" type="submit" value="Submit">
    </form>
  </center>
</div>

<div id="Manage" class="tabcontent">
  <center>
    <h1>Manage</h1>
    <hr class="customhr">

    <h2>Manage items</h2>

    <a class="block" href="?deleteallitems" onclick="if(!confirm('Are you sure you want to delete all items?')) return false;">Delete all items</a>
    <br>

    <?php if (count($array) > 0): ?>
    <table>
      <thead>
        <tr>
          <th><?php echo implode('</th><th>', array_keys(current($array))); ?></th>
        </tr>
      </thead><tbody>
        <?php foreach ($array as $row): array_map('htmlentities', $row); ?>
        <tr>
          <td><?php echo implode('</td><td>', $row); ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <br>
    <hr class="customhr">

    <h2>Uploaded Images</h2>

    <a class="block" href="?deleteallimages" onclick="if(!confirm('Are you sure you want to delete all images?')) return false;">Delete all images</a>
    <br>

    <?php
      $dir = array_diff(scandir($imagesdir, 1), array('.', '..', $noimage));
    ?>
    <table>
      <thead>
        <tr>
          <th>Image</th>
          <th>Name</th>
          <th>Rename</th>
          <th>Delete</th>
        </tr>
      </thead><tbody>
      <?php
      foreach ($dir as $dir) {
        echo '<tr><td><img src="' . $imagesdir . "/" . $dir . '" class="image" style="width:110px;height:110px;"></td><td>' . $dir . '</td><td><a class="button" href="?renameimage=' . base64_encode($dir) . '">Rename</a></td><td><a class="button" href="?deleteimage=' . base64_encode($dir) . '" onclick="if(!confirm(\'Are you sure you want to delete this image?\')) return false;">Delete</a></td></tr>';
      }
      ?>
      </tbody>
    </table>
    <br><hr class="customhr">

    <h2>Manage tabs</h2>

    <a class="block" href="?deletealltabs" onclick="if(!confirm('Are you sure you want to delete all tabs?')) return false;">Delete all tabs</a>
    <br>

    <?php
      $sql = "SELECT * FROM `tabs` ORDER BY id ASC";
      $sql = $con->query($sql);
      while($row = mysqli_fetch_array($sql)) {
        $tabs[] = array("id" => $row["id"], "tabs" => $row["tabs"]);
      }
    ?>
    <table>
      <thead>
        <tr>
          <th>Name</th>
          <th>Edit</th>
          <th>Delete</th>
        </tr>
      </thead><tbody>
      <?php
      foreach ($tabs as $tabs) {
        echo '<tr><td>' . ucfirst($tabs["tabs"]) . '</td><td><a class="button" href="?edittab=' . $tabs["id"] . '">Edit</a></td><td><a class="button" href="?deletetab=' . $tabs["id"] . '" onclick="if(!confirm(\'Are you sure you want to delete this item?\')) return false;">Delete</a></ts></tr>';
      }
      ?>
      </tbody>
    </table>
    <br><hr class="customhr">

    <h2>Website configuration</h2>

    <a class="block" href="?config">Configure</a>
    <br>
  </center>
</div>
    <?php
      endif;
      }
    ?>
<script>
  document.getElementById("defaultOpen").click();
</script>
