<?php
defined("INCLUDED") || include("error.php");

if(isset($_GET["az"])) {
  $enc = json_encode($arraytwo);
  $fix = str_ireplace("\/", "/", $enc);
  $fix = str_ireplace('[{"', '', $fix);
  $fix = str_ireplace('image":"', $code1, $fix);
  $fix = str_ireplace('","name":"', $code2, $fix);
  $fix = str_ireplace('","price":"', $code3, $fix);
  $fix = str_ireplace('","stock":"', $code4, $fix);
  $fix = str_ireplace('","weight":"', $code5, $fix);
  $fix = str_ireplace('"},{"', $code6, $fix);
  $fix = str_ireplace('"}]', $code6, $fix);
}

else

if(isset($_GET["za"])) {
  $enc = json_encode(array_reverse($arraytwo));
  $fix = str_ireplace("\/", "/", $enc);
  $fix = str_ireplace('[{"', '', $fix);
  $fix = str_ireplace('image":"', $code1, $fix);
  $fix = str_ireplace('","name":"', $code2, $fix);
  $fix = str_ireplace('","price":"', $code3, $fix);
  $fix = str_ireplace('","stock":"', $code4, $fix);
  $fix = str_ireplace('","weight":"', $code5, $fix);
  $fix = str_ireplace('"},{"', $code6, $fix);
  $fix = str_ireplace('"}]', $code6, $fix);
}

else

if(isset($_GET["lowest"])) {
  $enc = json_encode($arrayone);
  $fix = str_ireplace("\/", "/", $enc);
  $fix = str_ireplace('[{"', '', $fix);
  $fix = str_ireplace('image":"', $code1, $fix);
  $fix = str_ireplace('","name":"', $code2, $fix);
  $fix = str_ireplace('","price":"', $code3, $fix);
  $fix = str_ireplace('","stock":"', $code4, $fix);
  $fix = str_ireplace('","weight":"', $code5, $fix);
  $fix = str_ireplace('"},{"', $code6, $fix);
  $fix = str_ireplace('"}]', $code6, $fix);
}

else

if(isset($_GET["highest"])) {
  $enc = json_encode(array_reverse($arrayone));
  $fix = str_ireplace("\/", "/", $enc);
  $fix = str_ireplace('[{"', '', $fix);
  $fix = str_ireplace('image":"', $code1, $fix);
  $fix = str_ireplace('","name":"', $code2, $fix);
  $fix = str_ireplace('","price":"', $code3, $fix);
  $fix = str_ireplace('","stock":"', $code4, $fix);
  $fix = str_ireplace('","weight":"', $code5, $fix);
  $fix = str_ireplace('"},{"', $code6, $fix);
  $fix = str_ireplace('"}]', $code6, $fix);
}

else

if(isset($_GET["oldest"])) {
  $enc = json_encode($code);
  $fix = str_ireplace("\/", "/", $enc);
  $fix = str_ireplace('=\"', '="', $fix);
  $fix = str_ireplace('\"', '"', $fix);
  $fix = str_ireplace('["', '', $fix);
  $fix = str_ireplace('","', '', $fix);
  $fix = str_ireplace('"]', '', $fix);
}

else

if(isset($_GET["newest"])) {
  $enc = json_encode(array_reverse($code));
  $fix = str_ireplace("\/", "/", $enc);
  $fix = str_ireplace('=\"', '="', $fix);
  $fix = str_ireplace('\"', '"', $fix);
  $fix = str_ireplace('["', '', $fix);
  $fix = str_ireplace('","', '', $fix);
  $fix = str_ireplace('"]', '', $fix);
}

else {
  $enc = json_encode(array_reverse($code));
  $fix = str_ireplace("\/", "/", $enc);
  $fix = str_ireplace('=\"', '="', $fix);
  $fix = str_ireplace('\"', '"', $fix);
  $fix = str_ireplace('["', '', $fix);
  $fix = str_ireplace('","', '', $fix);
  $fix = str_ireplace('"]', '', $fix);
}

$fix = str_ireplace("<h1></h1>", "<h1>null</h1>", $fix);
$fix = str_ireplace('<p class="price">'.$configarray["currency"].' $</p>', '<p class="price">'.$configarray["currency"].' $null</p>', $fix);
$fix = str_ireplace('<img src="" class="image">', '<img src="' . $imagesdir . "/" . $noimage . '" class="image">', $fix);
$fix = str_ireplace("window.open('', '_blank'); return false;", "window.open('null', '_blank'); return false;", $fix);

$count = strlen($fix);
if ($count == '4'){
  $fix = str_ireplace("null", "<br>No items found", $fix);
}

$fix = preg_replace('/-[0-9]+/', '0', $fix);
$fix = str_ireplace("Stock: 0 ", "Out of stock ", $fix);
$fix = str_ireplace(" </p>", "</p>", $fix);
$fix = str_ireplace('<p font="small">Out of stock</p><button', '<p font="small">Out of stock</p><button disabled', $fix);
