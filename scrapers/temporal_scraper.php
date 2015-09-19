<?php
// requirements
require("/home/rex/courseNTNU/scrapers/temporal_scraper_helper.php");

// log stats
date_default_timezone_set('Asia/Taipei');
function time_elapsed($secs){
  $bit = array(
      ' year'        => $secs / 31556926 % 12,
      ' week'        => $secs / 604800 % 52,
      ' day'        => $secs / 86400 % 7,
      ' hour'        => $secs / 3600 % 24,
      ' minute'    => $secs / 60 % 60,
      ' second'    => $secs % 60);
  foreach($bit as $k => $v){
      if($v > 1)$ret[] = $v . $k . 's';
      if($v == 1)$ret[] = $v . $k;
      }
  array_splice($ret, count($ret)-1, 0, 'and');
  $ret[] = 'passed.';
  return join(' ', $ret);
}
$counter = 0;
$t1 = time();
$path = "/home/rex/courseNTNU/scrapers/scraper_log.log";

// debugging mode
$DEBUG = False;

// 從選課系統拿資料
foreach(get_data() as $courses)
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
      require("/home/rex/courseNTNU/scrapers/temporal_scraper_tester.php");
    }
    $a = query("UPDATE Courses SET FmReserve = ?, Enrolled = ?, Assigned = ?, Unassigned = ?,
                               AuthAssigned = ?, ExAssigned = ?, PtAssigned = ?
                               WHERE CourseId = ?",$FmReserve,$Enrolled,$Assigned,
                               $Unassigned,$AuthAssigned,$ExAssigned,$PtAssigned,$CourseId);
    echo $course['chnName']."\n";
    $counter++;
  }
}

// log stats
$t2 = time();
$time_passed = time_elapsed($t2-$t1);
$time_stamp = date('Y-m-d H:i:s');
$message = "\n[ $time_stamp ]: updated $counter courses, with $time_passed";
file_put_contents($path, $message, $flag=FILE_APPEND);
?>
