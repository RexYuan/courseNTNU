<?php
// 處理當按下追蹤按鈕
// $_SESSION["u"] 存 UserId, $_POST["n"] 存該課程 SerialNo, $_POST["t"] 存 FB token
// requirements
require_once("functions.php");
require_once("constants.php");
session_start();
// 按下追蹤
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
  if (!isset($_SESSION["u"]))
  {
    $d = lookup($_POST["t"]);
    query("INSERT INTO Users (FBId, UserName, Gender, Locale) VALUES (?, ?, ?, ?)",
          $d["id"], $d["name"], $d["locale"], $d["gender"]);
    $_SESSION["u"] = query("SELECT UserId FROM Users WHERE FBId = ?", $d["id"])[0]["UserId"];
  }
  $sublst = query("SELECT * FROM Subs WHERE UserId = ?", $_SESSION["u"]);
  // 有追蹤過課
  if ($sublst)
  {
    $sublst = $sublst[0]["SubLst"];
    $sublst = explode("/", $sublst);
    // 已經追蹤此課
    if (in_array((string)$_POST["n"], $sublst))
    {
      unset($sublst[array_keys($sublst, (string)$_POST["n"])[0]]);
      query("UPDATE Subs SET SubLst = ? WHERE UserId = ?", implode("/", $sublst), $_SESSION["u"]);
    }
    // 還沒追蹤此課
    else
    {
      if (empty($sublst[0]))
      {
        query("UPDATE Subs SET SubLst = ? WHERE UserId = ?", $_POST["n"], $_SESSION["u"]);
      }
      else
      {
        query("UPDATE Subs SET SubLst = ? WHERE UserId = ?", implode("/", $sublst)."/".$_POST["n"], $_SESSION["u"]);
      }
    }
  }
  // 還沒追蹤任一堂課
  else
  {
    query("INSERT INTO Subs (UserId, SubLst) VALUES (?, ?)", $_SESSION["u"], $_POST["n"]);
  }
}
?>
