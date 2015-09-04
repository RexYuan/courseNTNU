<?php
// 處理要求列出所有追蹤的頁面
// requirements
require_once("functions.php");
require_once("constants.php");
// session
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

if (!isset($_SESSION["profile"]))
{
    $_SESSION["profile"] = lookup($_POST["token"]);
}
$uid = query("SELECT UserId FROM Users WHERE FBId = ?", $_SESSION["profile"]["id"])[0]["UserId"];
$subs = query("SELECT * FROM Subs WHERE UserId = ?", $uid);

// 處理去拿各個「當期」開課的資料 參閱 index.php 裡輸出處理 crs_info.php 的部分

// 輸出 sub_lst.php

?>
