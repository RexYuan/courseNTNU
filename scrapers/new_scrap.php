<?php
  // requirements
  require("new_scrap_helper.php");

  // departments
  /*foreach ($DEPARTMENT_CODE_LIST as $dept_code => $dept_name)
  {
    // checking if already in database
    $result = query("SELECT ChName FROM Departments WHERE DeptCode = ?", $dept_code);
    if ($result)
    {
      // if name was changed
      if ($result[0]['ChName'] != $dept_name)
      {
        query("UPDATE Departments SET ChName = ? WHERE DeptCode = ?", $dept_name, $dept_code);
      }
    }
    // new dept
    else
    {
      query("INSERT INTO Departments (DeptCode, ChName) VALUES (?, ?)", $dept_code, $dept_name);
    }
  }*/

  // courses
  foreach (array_keys($DEPARTMENT_CODE_LIST) as $dept_code)
  {
    // build URL
    $URL_GET_LIST['deptCode'] = $dept_code;
    $target = $URL_GET_BASE . implode("&", array_map(function($key,$value){return $key."=".$value;}, array_keys($URL_GET_LIST), $URL_GET_LIST));
    // build JSON
    $raw_json = file_get_contents($target);
    $json = json_decode($raw_json, $assoc = True);
    // retrieve information (note that every value in JSON is string)
    $number_of_course = $json['Count']; // 課程數目
    foreach ($json['List'] as $course)
    {
      // 簡單資訊
      $SerialNo = (int)$course['serial_no']; // 開課序號
      $CourseCode = (string)$course['course_code']; // 課程代碼
      $AcadmYear = (int)$YEAR; // 學年
      $AcadmTerm = (int)$TERM; // 學期
      $ChName = (string)$course['chn_name']; // 課程中文名稱
      $EnName = (string)$course['eng_name']; // 課程英文名稱
      $CourseGroup = (string)$course['course_group']; // 組別
      $ClassCode = (string)$course['classes']; // 開課班級代碼
      $Credit = (float)$course['credit']; // 學分數
      $DeptGroup = (string)$course['dept_group']; // 開課組別
      $Grade = (string)$course['form_s']; // 開課年級
      $RestrictInfo = (string)$course['restrict']; // 限制
      $selfTeachName = (string)$course['selfTeachName']; // *正課/實驗親授
      $EnLocation = Null; // 英文上課地點
      $StatusInfo = False; // *是否停開
      $ChComment = (string)$course['comment']; // 中文註解
      $EnComment = Null; // 英文註解
      $CourseSize = (int)$course['counter_exceptAuth']; // 修課總人數
      $AuthMaxSize = (int)$course['authorize_p']; // 授權碼名額
      $AuthRate = (float)$course['authorize_r']; // 授權碼比例
      $AuthUsed = (int)$course['authorize_using']; // 授權碼使用人數
      $NTAMaxSize = (int)$course['limit']; // 台大聯盟限修人數
      $TotalMaxSize = (int)$course['limit_count_h']; // 限修人數
      // 簡單處理資訊
      $Duration = $course['course_kind'] == "半" ? "H" : "F"; // 全/半學期
      $IsEngTeach = $course['eng_teach'] == "是" ? True : False; // 全英語授課
      $GenderRestrict = $course['gender_restrict'] == "" ? "N" : $course['gender_restrict']; // 性別限制
      $IsMOOC = $course['moocs_teach'] == "是" ? True : False; // MOOCs
      $IsElective = $course['option_code'] == "選" ? True : False; // 必／選修
      $RemoteTeach = $course['rt'] == "是" ? True : False; // 遠距授課
      // 判斷資訊
      $DeptId = lookup_dept_id_by_code($course['dept_code']); // 開課系所識別碼
      $TeacherId = lookup_teacher_id_by_name($DeptId, $course['teacher']); // 教師
      list($TimeInfo, $ChLocation) = array_values(parse_time_inf($course['time_inf'])); // 中文上課地點, 上課時間
      // 課綱資訊
      list($Hour, $Description) = lookup_course_page($course['course_code'], $course['course_group'], $course['dept_code'], $course['form_s'], $course['classes'], $course['dept_group']); // 上課時數, 課程簡介
      // 選課系統資訊
      $FreshReserve = Null;
      $Distributed = Null;
      //TODO:1. test all values(done) 2. store them up 3. deal with records
      // store data
      echo '$SerialNo = ';var_dump($SerialNo);
      echo '$CourseGroup = ';var_dump($CourseGroup);
      echo '$EnLocation = ';var_dump($EnLocation);
      echo '$IsMOOC = ';var_dump($IsMOOC);
      echo <<<HEREDOC
開課序號       SerialNo       = $SerialNo
課程代碼       CourseCode     = $CourseCode
學年          AcadmYear      = $AcadmYear
學期          AcadmTerm      = $AcadmTerm
課程中文名稱    ChName         = $ChName
課程英文名稱    EnName         = $EnName
組別          CourseGroup    = $CourseGroup
開課班級代碼    ClassCode      = $ClassCode
學分數         Credit         = $Credit
開課組別       DeptGroup      = $DeptGroup
開課年級       Grade          = $Grade
限制           RestrictInfo   = $RestrictInfo
正課實驗親授    selfTeachName  = $selfTeachName
英文上課地點    EnLocation     = $EnLocation
是否停開       StatusInfo     = $StatusInfo
中文註解       ChComment      = $ChComment
英文註解       EnComment      = $EnComment
修課總人數      CourseSize     = $CourseSize
授權碼名額      AuthMaxSize    = $AuthMaxSize
授權碼比例      AuthRate       = $AuthRate
授權碼使用人數   AuthUsed       = $AuthUsed
台大聯盟限修人數 NTAMaxSize     = $NTAMaxSize
限修人數        TotalMaxSize   = $TotalMaxSize
全/半學期       Duration       = $Duration
全英語授課      IsEngTeach     = $IsEngTeach
性別限制        GenderRestrict = $GenderRestrict
MOOCs         IsMOOC         = $IsMOOC
必／選修       IsElective      = $IsElective
遠距授課        RemoteTeach    = $RemoteTeach
開課系所識別碼   DeptId         = $DeptId
教師           TeacherId      = $TeacherId
中文上課地點    ChLocation     = $ChLocation
上課時間        TimeInfo      = $TimeInfo
上課時數       Hour           = $Hour
課程簡介       Description    = $Description
====================================================

HEREDOC;
    }
  }
 ?>
