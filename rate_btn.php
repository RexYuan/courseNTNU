<?php
// 投票按鈕的初始化
// $_SESSION["u"] 存 UserId, $_POST["i"] 存該課程 CourseId, $_POST["t"] 存 FB token
// requirements
require_once("functions.php");
require_once("constants.php");
session_start();
// 初始化按鈕
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
  if (!isset($_SESSION["u"]))
  {
    $d = lookup($_POST["t"]);
    query("INSERT INTO Users (FBId, UserName, Gender, Locale) VALUES (?, ?, ?, ?)",
          $d["id"], $d["name"], $d["locale"], $d["gender"]);
    $_SESSION["u"] = query("SELECT UserId FROM Users WHERE FBId = ?", $d["id"])[0]["UserId"];
  }
  $vt = query("SELECT * FROM Votes WHERE UserId = ? AND CourseId = ?", $_SESSION["u"], $_POST["i"])[0];
  // 推
  if ($vt["Decision"])
  {
    echo json_encode(["rate" => True]);
  }
  // 不推
  else
  {
    echo json_encode(["rate" => False]);
  }
}
?>
