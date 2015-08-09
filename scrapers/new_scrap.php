<?php
  // requirements
  require("new_scrap_helper.php");

  foreach (array_keys($DEPARTMENT_CODE_LIST) as $dept_code)
  {
    // build URL
    $URL_GET_LIST['deptCode'] = $dept_code;
    $target = $URL_GET_BASE . implode("&", array_map(function($key,$value){return $key."=".$value;}, array_keys($URL_GET_LIST), $URL_GET_LIST));
    // build JSON
    $raw_json = file_get_contents($target);
    $json = json_decode($raw_json, $assoc = True);
    // retrieve information (note that every value in JSON is string)
    $number_of_course                = $json['Count'];          // 課程數目
    foreach ($json['List'] as $course)
    {
      $course_chinese_name           = $course['chn_name'];        // 課程中文名稱
      $course_english_name           = $course['eng_name'];        // 課程英文名稱
      $course_teacher                = $course['teacher'];         // 教師
      $course_code                   = $course['course_code'];     // 課程代碼
      $course_serial                 = $course['serial_no'];       // 開課序號
      $course_time_location          = $course['time_inf'];        // 時間與開課地點
      $course_group                  = $course['course_group'];    // 課程組
      $course_length                 = $course['course_kind'];     // 全／半年
      $course_credit                 = $course['credit'];          // 學分數
      $course_elective               = $course['option_code'];     // 必／選修
      $course_grade                  = $course['form_s'];          // 開課年級
      $course_grade_chinese_name     = $course['form_s_name'];     // 開課年級中文名稱
      $course_is_master              = $course['class_name'];      // 大碩合開
      $course_is_in_english          = $course['eng_teach'];       // 全英語授課
      $course_restrict               = $course['restrict'];        // 限制
      $course_gender                 = $course['gender_restrict']; // 性別限制
      $course_comment                = $course['comment'];         // 註解
      $department_chinese_name       = $course['dept_chiabbr'];    // 系所中文名稱
      $department_code               = $course['dept_code'];       // 系所代碼
      $department_group              = $course['dept_group'];      // 系所組別
      $department_group_chinese_name = $course['dept_group_name']; // 系所組別中文名稱
      // store data
      // FILL ME UP!
      print_r([$number_of_course,$course_english_name,$course_grade,$course_serial]);;
    }
  }
 ?>
