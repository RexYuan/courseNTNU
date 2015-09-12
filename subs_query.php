<?php
// 處理當按下追蹤按鈕
// requirements
require_once("functions.php");
require_once("constants.php");

// if rated
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    if (!isset($_SESSION["profile"]))
    {
        $_SESSION["profile"] = lookup($_POST["token"]);
    }

    $subed = query("SELECT * FROM sub WHERE fbid=? AND code=?", $_SESSION["profile"]["id"], $_POST["code"]);
    if ($subed)
    {
      query("DELETE FROM sub WHERE fbid=? AND code=?", $_SESSION["profile"]["id"], $_POST["code"]);
    }
    else
    {
      query("INSERT INTO sub (fbid, code) VALUES (?,?)", $_SESSION["profile"]["id"], $_POST["code"]);
    }
    echo json_encode(["subed" => $subed]);
}
else
{
    redirect($urlroot . "index.php");
}

?>
