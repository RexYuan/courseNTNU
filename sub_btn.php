<?php
// 追蹤按鈕的初始化
// $_SESSION["u"] 存 UserId, $_POST["n"] 存該課程 SerialNo
// requirements
require_once("functions.php");
require_once("constants.php");
// 初始化按鈕
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
  if (!isset($_SESSION["u"]))
  {
    $d = lookup($tok);
    query("INSERT INTO Users (FBId, UserName, Gender, Locale) VALUES (?, ?, ?, ?)",
          $d["id"], $d["name"], $d["locale"], $d["gender"]);
    $_SESSION["u"] = query("SELECT UserId FROM Users WHERE FBId = ?", $d["id"])[0]["UserId"];
  }
  $nlst = explode("/",$sublst = query("SELECT * FROM Subs WHERE UserId = ?", $_SESSION["u"])[0]["Sublst"]);
  if (in_array($_POST["n"], $nlst))
  {
    echo json_encode(["subed" => True]);
  }
  else
  {
    echo json_encode(["subed" => False]);
  }


}
?>