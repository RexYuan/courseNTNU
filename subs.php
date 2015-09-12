<?php
// 處理要求列出所有追蹤的頁面
// requirements
require_once("functions.php");
require_once("constants.php");
// session
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

if (isset($_GET["i"]))
{
  $subs = query("SELECT * FROM sub WHERE fbid = ?", $_GET["i"]);
  $crs = [];
  foreach ($subs as $sub)
  {
    $crs[] = query("SELECT * FROM course WHERE code=?", $sub["code"])[0];
  }
  render("subs_lst.php", ["urlroot" => $urlroot, "crs"=>$crs]);
}
else
{
  redirect($urlroot . "index.php");
}

?>
