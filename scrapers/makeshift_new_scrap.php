<?php
  // requirements
  require("makeshift_new_scrap_helper.php");

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
      $course_teacher                = $course['teacher'];         // 教師
      $course_code                   = $course['course_code'];     // 課程代碼
      $eng_name = $course['eng_name'];

      $counter_exceptAuth = (int)$course['counter_exceptAuth'];
      $limit_count_h = (int)$course['limit_count_h'];
      $moocs_teach = ($course['moocs_teach'] == "是" ? TRUE : FALSE);
      $eng_teach = ($course['eng_teach'] == "是" ? TRUE : FALSE);
      $serial_no = (int)$course['serial_no'];

      // store data
      echo "storing $course_code\n";
      query("UPDATE course SET teacher = ?, availability = ?,
                               eng_name = ?,
                               counter_exceptAuth = ?,
                               limit_count_h = ?,
                               moocs_teach = ?,
                               eng_teach = ?,
                               serial_no = ? WHERE code = ?", $course_teacher, '1',
                              $eng_name,$counter_exceptAuth,$limit_count_h,$moocs_teach,$eng_teach,$serial_no,  $course_code);
    }
  }
 ?>
