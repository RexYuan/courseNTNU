<?php
// requirements
require("temporal_scraper_helper.php");

// debugging mode
$DEBUG = False;

// 從選課系統拿資料
foreach(get_data(98,1) as $courses)
{
  foreach ($courses as $course)
  {
    $CourseId = query("SELECT CourseId FROM Courses WHERE AcadmYear = ?
                       AND AcadmTerm = ? AND SerialNo = ?", $YEAR,
                       $TERM, $course['serialNo'])[0]['CourseId'];
    $FmReserve = $course['v_reserve_count']; // 保留新生人數
  	$Enrolled = $course['v_stfseld']; // 選課人數
  	$Assigned = $course['v_stfseld_deal']; // 已分發人數
  	$Unassigned = $course['v_stfseld_undeal']; // 未分發人數
  	$AuthAssigned = $course['v_stfseld_auth']; // 授權碼選課人數
  	$ExAssigned = $course['v_stfseld_exchange']; // 交換生選課人數
  	$PtAssigned = $course['v_stfseld_unfull']; // 不佔名額生人數
    if ($DEBUG)
    {
      require("temporal_scraper_tester.php");
    }
    $a = query("UPDATE Courses SET FmReserve = ?, Enrolled = ?, Assigned = ?, Unassigned = ?,
                               AuthAssigned = ?, ExAssigned = ?, PtAssigned = ?
                               WHERE CourseId = ?",$FmReserve,$Enrolled,$Assigned,
                               $Unassigned,$AuthAssigned,$ExAssigned,$PtAssigned,$CourseId);
    echo $course['chnName']."\n";
  }
}


?>
