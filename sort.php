<?php
  defined("INCLUDED") || include("error.php");
  include("config.php");
?>
<select id="selectBox" onchange="change();">
    <option value="" disabled<?php if(empty($_GET)){echo " " . "selected";}?>>Sort by</option>
    <option value="newest"<?php if(isset($_GET["newest"])){echo " " . "selected";}?>>Newest</option>
    <option value="oldest"<?php if(isset($_GET["oldest"])){echo " " . "selected";}?>>Oldest</option>
    <option value="lowest"<?php if(isset($_GET["lowest"])){echo " " . "selected";}?>>Price: Lowest</option>
    <option value="highest"<?php if(isset($_GET["highest"])){echo " " . "selected";}?>>Price: Highest</option>
    <option value="az"<?php if(isset($_GET["az"])){echo " " . "selected";}?>>Alphabetical: A-Z</option>
    <option value="za"<?php if(isset($_GET["za"])){echo " " . "selected";}?>>Alphabetical: Z-A</option>
  </select><br>
