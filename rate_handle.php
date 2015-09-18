<?php
// 處理當按下推或不推按鈕
// $_SESSION["u"] 存 UserId, $_POST["i"] 存該課程 CourseId, $_POST["c"] 存 CourseCode, $_POST["r"] 存決定
// requirements
require_once("functions.php");
require_once("constants.php");
// 按下推或不推
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
  if (!isset($_SESSION["u"]))
  {
    $d = lookup($_POST["t"]);
    query("INSERT INTO Users (FBId, UserName, Gender, Locale) VALUES (?, ?, ?, ?)",
          $d["id"], $d["name"], $d["locale"], $d["gender"]);
    $_SESSION["u"] = query("SELECT UserId FROM Users WHERE FBId = ?", $d["id"])[0]["UserId"];
  }
  // 檢查是否已經有投票過
  $prevote = query("SELECT * FROM Votes WHERE UserId = ? AND CourseId = ?", $_SESSION["u"], $_POST["i"])[0];
  // 沒投票過
  if (empty($prevote))
  {
      query("INSERT INTO Votes (CourseId, CourseCode, Decision, UserId) VALUES (?, ?, ?, ?)", $_POST["i"], $_POST["c"], $_POST["r"], $_SESSION["u"]);
      // 推
      if ($_POST["r"])
      {
        query("UPDATE Courses SET LikeIt = LikeIt + 1 WHERE CourseId = ?", $_POST["i"]);
      }
      // 不推
      else
      {
        query("UPDATE Courses SET DislikeIt = DislikeIt + 1 WHERE CourseId = ?", $_POST["i"]);
      }
  }
  // 已經投票過
  else
  {
    // 之前是推
    if ($prevote["Decision"])
    {
      // 收回推
      if ($_POST["r"])
      {
        query("DELETE FROM Votes WHERE CourseId = ? AND UserId = ?", $_POST["i"], $_SESSION["u"]);
        query("UPDATE Courses SET LikeIt = LikeIt - 1 WHERE CourseId = ?", $_POST["i"]);
      }
      // 改不推
      else
      {
        query("UPDATE Votes SET Decision = ? WHERE CourseId = ? AND UserId = ?", '0', $_POST["i"], $_SESSION["u"]);
        query("UPDATE Courses SET LikeIt = LikeIt - 1, DislikeIt = DislikeIt + 1 WHERE CourseId = ?", $_POST["i"]);
      }
    }
    // 之前是不推
    else
    {
      // 改推
      if ($_POST["r"])
      {
        query("UPDATE Votes SET Decision = ? WHERE CourseId = ? AND UserId = ?", '1', $_POST["i"], $_SESSION["u"]);
        query("UPDATE Courses SET LikeIt = LikeIt + 1, DislikeIt = DislikeIt - 1 WHERE CourseId = ?", $_POST["i"]);
      }
      // 收回不推
      else
      {
        query("DELETE FROM Votes WHERE CourseId = ? AND UserId = ?", $_POST["i"], $_SESSION["u"]);
        query("UPDATE Courses SET DislikeIt = DislikeIt - 1 WHERE CourseId = ?", $_POST["i"]);
      }
    }
  }
  // 準備更新前端
  $crecords = query("SELECT * FROM Courses WHERE CourseCode = ?", $_POST["c"]);
  // 合併投票數
  $scores = [];
  foreach ($crecords as $crecord)
  {
    $scores[$crecord["TeacherId"]]["LikeIt"] += $crecord["LikeIt"];
    $scores[$crecord["TeacherId"]]["DislikeIt"] += $crecord["DislikeIt"];
  }
  // 回傳分數
  echo json_encode(["scores" => $scores]);
}
// 亂來
else
{
  redirect($urlroot . "index.php");
}
?>
