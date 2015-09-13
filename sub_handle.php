<?php
// 處理當按下追蹤按鈕
// $_SESSION["u"] 存 UserId, $_POST["n"] 存該課程 SerialNo
// requirements
require_once("functions.php");
require_once("constants.php");
// 按下追蹤
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
  if (!isset($_SESSION["u"]))
  {
    $d = lookup($tok);
    query("INSERT INTO Users (FBId, UserName, Gender, Locale) VALUES (?, ?, ?, ?)",
          $d["id"], $d["name"], $d["locale"], $d["gender"]);
    $_SESSION["u"] = query("SELECT UserId FROM Users WHERE FBId = ?", $d["id"])[0]["UserId"];
  }
  $sublst = query("SELECT * FROM Subs WHERE UserId = ?", $_SESSION["u"])[0]["SubLst"];
  // 還沒追蹤任一堂課
  if ($sublst)
  {
    query("INSERT INTO Subs (UserId, SubLst) VALUES (?, ?)", $_SESSION["u"], $_POST["n"]);
  }
  // 有追蹤過課
  else
  {
    $sublst = explode("/", $sublst);
    // 已經追蹤此課
    if (in_array((string)$_POST["n"], $sublst))
    {
      unset($sublst[array_keys($sublst, (string)$_POST["n"])[0]]);
      query("UPDATE Subs SET SubLst = ?", implode("/", $sublst));
    }
    // 還沒追蹤此課
    else
    {
      query("UPDATE Subs SET SubLst = ?", implode("/", $sublst)."/".$_POST["n"]);
    }
  }
}
?>
