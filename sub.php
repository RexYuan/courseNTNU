<?php
// 處理要求列出所有追蹤的頁面
// requirements
require_once("functions.php");
require_once("constants.php");
// session
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
if ($_SERVER["REQUEST_METHOD"] == "GET" AND isset($_GET["u"]))
{
  $sublst = query("SELECT * FROM Subs WHERE UserId = ?", $_GET["u"])[0]["SubLst"];
  if ($sublst)
  {
    $nlst = explode("/", $sublst);
    $clst = [];
    foreach ($nlst as $n)
    {
      $clst[] = query("SELECT * FROM Courses WHERE SerialNo = ?", $n)[0];
    }
    render("subs_lst.php", ["title" => "追蹤課程", "urlroot" => $urlroot, "clst" => $clst]);
  }
  else
  {
    redirect($urlroot."index.php");
  }
}
else
{
  redirect($urlroot."index.php");
}

?>
