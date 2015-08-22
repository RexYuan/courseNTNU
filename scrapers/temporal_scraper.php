<?php
// requirements
require("temporal_scraper_helper.php");

foreach (array_slice($DEPARTMENT_CODE_LIST,0,1) as $dept_code)
{
  // 從選課系統拿資料
  foreach (json_decode(get_data($dept_code), $assoc = True)['List'] as $course)
  {
    $CourseCode = $course['courseCode']; // 開課序號
    $SerialNo = $course['serialNo']; // 課程代碼
    $course['limitCountH'] // 限修人數
    $course['authorizeP'] // 授權碼人數
    $course['v_reserve_count'] // 保留新生人數
    $course['v_stfseld'] // 選課人數
    $course['v_stfseld_deal'] // 已分發人數
    $course['v_stfseld_undeal'] // 未分發人數
    $course['v_stfseld_auth'] // 授權碼選課人數
    $course['v_stfseld_exchange'] // 交換生選課人數
    $course['v_stfseld_unfull'] // 不佔名額生人數
  }
}

?>
