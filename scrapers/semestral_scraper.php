<?php
  // requirements
  require("semestral_scraper_helper.php");

  // debugging mode
  $DEBUG = False;

  // get departments
  foreach ($DEPARTMENT_CODE_LIST as $dept_code => $dept_name)
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
  }

  // get courses
  foreach (array_keys(array_slice($DEPARTMENT_CODE_LIST,98,1)) as $dept_code)
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
      $SerialNo      = (int)$course['serial_no']; // 開課序號
      $CourseCode    = (string)$course['course_code']; // 課程代碼
      $AcadmYear     = (int)$YEAR; // 學年
      $AcadmTerm     = (int)$TERM; // 學期
      $ChName        = (string)$course['chn_name']; // 課程中文名稱
      $EnName        = (string)$course['eng_name']; // 課程英文名稱
      $CourseGroup   = (string)$course['course_group']; // 組別
      $ClassCode     = (string)$course['classes']; // 開課班級代碼
      $Credit        = (float)$course['credit']; // 學分數
      $DeptGroup     = (string)$course['dept_group']; // 開課組別
      $Grade         = (string)$course['form_s']; // 開課年級
      $RestrictInfo  = (string)$course['restrict']; // 限制
      $selfTeachName = (string)$course['selfTeachName']; // *正課/實驗親授
      $EnLocation    = Null; // 英文上課地點
      $StatusInfo    = False; // *是否停開
      $ChComment     = (string)$course['comment']; // 中文註解
      $EnComment     = Null; // 英文註解
      $AuthMaxSize   = (int)$course['authorize_p']; // 授權碼名額
      $AuthRate      = (float)$course['authorize_r']; // 授權碼比例
      $NTAMaxSize    = (int)$course['limit']; // 台大聯盟限修人數
      $TotalMaxSize  = (int)$course['limit_count_h']; // 限修人數
      // 簡單處理資訊
      $Duration       = $course['course_kind'] == "半" ? "H" : "F"; // 全/半學期
      $IsEngTeach     = $course['eng_teach'] == "是" ? True : False; // 全英語授課
      $GenderRestrict = $course['gender_restrict'] == "" ? "N" : $course['gender_restrict']; // 性別限制
      $IsMOOC         = $course['moocs_teach'] == "是" ? True : False; // MOOCs
      $IsElective     = $course['option_code'] == "選" ? True : False; // 必／選修
      $RemoteTeach    = $course['rt'] == "是" ? True : False; // 遠距授課
      // 判斷資訊
      $DeptId    = lookup_dept_id_by_code($course['dept_code']); // 開課系所識別碼
      $TeacherId = lookup_teacher_id_by_name($DeptId, $course['teacher']); // 教師
      list($TimeInfo, $ChLocation) = array_values(parse_time_inf($course['time_inf'])); // 中文上課地點, 上課時間
      // 課綱資訊
      list($Hour, $Description) = lookup_course_page($course['course_code'], $course['course_group'], $course['dept_code'], $course['form_s'], $course['classes'], $course['dept_group']); // 上課時數, 課程簡介
      // debugging mode
      if ($DEBUG)
      {
        // output retrieved data
        require("semestral_scraper_tester.php");
      }
      // 儲存至資料庫 Courses
      query("INSERT INTO Courses (SerialNo,CourseCode,AcadmYear,AcadmTerm,ChName,
             EnName,CourseGroup,ClassCode,Credit,DeptGroup,Grade,RestrictInfo,
             selfTeachName,EnLocation,StatusInfo,ChComment,EnComment,
             AuthMaxSize,AuthRate,NTAMaxSize,TotalMaxSize,Duration,IsEngTeach,
             GenderRestrict,IsMOOC,IsElective,RemoteTeach,DeptId,TeacherId,TimeInfo,
             ChLocation,Hour,Description)
             VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
             $SerialNo,$CourseCode,$AcadmYear,$AcadmTerm,$ChName,$EnName,$CourseGroup,
             $ClassCode,$Credit,$DeptGroup,$Grade,$RestrictInfo,$selfTeachName,
             $EnLocation,$StatusInfo,$ChComment,$EnComment,$AuthMaxSize,
             $AuthRate,$NTAMaxSize,$TotalMaxSize,$Duration,$IsEngTeach,
             $GenderRestrict,$IsMOOC,$IsElective,$RemoteTeach,$DeptId,$TeacherId,
             $TimeInfo,$ChLocation,$Hour,$Description);
      $CourseId = query("SELECT CourseId FROM Courses
                          WHERE SerialNo = ? AND CourseCode = ?
                          AND AcadmYear = ? AND AcadmTerm =?",
                          $SerialNo,$CourseCode,$AcadmYear,$AcadmTerm)[0]['CourseId'];
      // 儲存至資料庫 CourseRecords
      $c_record_result = query("SELECT * FROM CourseRecords WHERE CourseCode = ?", $CourseCode);
      if($c_record_result)
      {
        query("UPDATE CourseRecords SET CourseIdRecord = ? WHERE CourseCode = ?", $c_record_result[0]['CourseIdRecord'].'/'.$CourseId, $CourseCode);
      }
      else
      {
        query("INSERT INTO CourseRecords (CourseCode, CourseIdRecord) VALUES (?, ?)", $CourseCode, $CourseId);
      }
      // 儲存至資料庫 DepartmentRecords
      $d_record_result = query("SELECT * FROM DepartmentRecords WHERE DeptId = ?", $DeptId);
      if($d_record_result)
      {
        query("UPDATE DepartmentRecords SET DeptCourseNameRecord = ?, DeptCourseCodeRecord = ? WHERE DeptId = ?", $d_record_result[0]['DeptCourseNameRecord'].'/'.$ChName, $d_record_result[0]['DeptCourseCodeRecord'].'/'.$CourseCode, $DeptId);
      }
      else
      {
        query("INSERT INTO DepartmentRecords (DeptId, DeptCode, DeptCourseNameRecord, DeptCourseCodeRecord) VALUES (?, ?, ?, ?)", $DeptId, $course['dept_code'], $ChName, $CourseCode);
      }
      echo "$EnName\n";
    }
  }
 ?>
