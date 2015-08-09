<?php
  // requirements
  require("scraper_helper_functions.php");

  // iterate from 01U(1) to 0SU(42)
  for ($department_db_index = 19; $department_db_index <= 19; $department_db_index++)
  {
    // query department information
    $department_info = query("SELECT * FROM department WHERE id = ?", $department_db_index)[0];
    // component sets and indices
    $courseGroup_set_index = 0;
    $courseGroup_set = ["", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P"];
    $formS_set_index = 0;
    $formS_set = ["", "1", "2", "3", "4"];
    $formS_grade_set = ["一年級", "二年級", "沒有限制", "三年級", "四年級"];
    $classes1_set_index = 0;
    $classes1_set = ["", "1", "2", "3"];
    $deptGroup_set_index = 0;
    $deptGroup_set = ["", "1", "2", "3"];
    // iterate from 0000 to 9999
    for ($courseCode_number = 16; $courseCode_number <= 16; $courseCode_number++)
    {
      // COMPONENT - year
      //           : the year in Taiwanese year
      $component_year = "year=104";
      // COMPONENT - term
      //           : the semester
      $component_term = "term=1";
      // COMPONENT - courseCode
      //           : the course's code
      $component_courseCode = "courseCode=" . $department_info['abbr'] . sprintf('%04d', $courseCode_number);
      // COMPONENT - courseGroup
      //           : the specific offer
      $component_courseGroup = "courseGroup=" . $courseGroup_set[$courseGroup_set_index];
      // COMPONENT - deptCode
      //           : the department's code
      $component_deptCode = "deptCode=" . $department_info['code'];
      // COMPONENT - formS
      //           : the intended grade
      $component_formS = "formS=" . $formS_set[$formS_set_index];
      // COMPONENT - classes1
      //           : the intened class
      $component_classes1 = "classes1=" . $classes1_set[$classes1_set_index];
      // COMPONENT - deptGroup
      //           : the intened department division
      $component_deptGroup = "deptGroup=" . "";
      // build url
      $component_set_array = [$component_year,
                              $component_term,
                              $component_courseCode,
                              $component_courseGroup,
                              $component_deptCode,
                              $component_formS,
                              $component_classes1,
                              $component_deptGroup];
      $component_set = implode("&",$component_set_array);
      $base_url = "http://courseap.itc.ntnu.edu.tw/acadmOpenCourse/SyllabusCtrl?";
      $target_url = $base_url . $component_set;
      echo "      Trying $component_courseCode / $target_url\n";
      // fetching
      $stick = retrieve($target_url);
      // checking if course exist
      if ($stick == False)
      {
        // re-trying
        if ($formS_set_index < 4)
        {
          if ($courseGroup_set_index < 16)
          {
            if ($classes1_set_index < 3)
            {
              $classes1_set_index++;
              $courseCode_number--;
              continue;
            }
            else
            {
              $classes1_set_index = 0;
              $courseGroup_set_index++;
              $courseCode_number--;
              continue;
            }
          }
          else
          {
            $courseGroup_set_index = 0;
            $formS_set_index++;
            $courseCode_number--;
            continue;
          }
        }
        else
        {
          echo "[not found]: $component_courseCode / $target_url\n";
          $formS_set_index = 0;
          continue;
        }
      }
      // course found
      else
      {
        // if course has multiple offers
        if ($courseGroup_set_index > 0 and $courseGroup_set_index < 16)
        {
          $courseGroup_set_index++;
          $courseCode_number--;
        }
        // checking duplicate
        $duplicate_result = query("SELECT * FROM course WHERE code = ?", $stick["code"]);
        if (!empty($duplicate_result))
        {
          // update availability
          //query("UPDATE course SET availability = ? WHERE code = ?", '1', $stick["code"]);
          // if no instructor recorded yet
          if ($duplicate_result[0]["teacher"] == "")
          {
            //query("UPDATE course SET teacher = ? WHERE code = ?", $stick["instructor"], $stick["code"]);
            echo "[updated]: $component_courseCode / $target_url\n";
            $courseGroup_set_index++;
            $courseCode_number--;
            continue;
          }
          // already exist at least one instructor
          else
          {
            // if this instructor not yet recorded
            if (strpos($duplicate_result[0]["teacher"], $stick["instructor"]) === false)
            {
              //query("UPDATE course SET teacher = ? WHERE code =?", $duplicate_result[0]["teacher"].'／'.$stick["instructor"], $stick["code"]);
              echo "[updated]: $component_courseCode / $target_url\n";
            }
            // this instructor is duplicate
            else
            {
              continue;
            }
          }
        }
        // course not yet recorded
        else
        {
          // store it up
          /*query("INSERT INTO course (department,
                                     chdepartment,
                                     code,
                                     chname,
                                     teacher,
                                     description,
                                     credit,
                                     grade,
                                     availability)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)",
                                     $department_info['abbr'],
                                     $department_info['name'],
                                     $stick['code'],
                                     $stick['chinese_name'],
                                     $stick['instructor'],
                                     $stick['description'],
                                     $stick['credit'],
                                     $formS_grade_set[$formS_set_index],
                                     '1');*/
          echo "[inserted]: $component_courseCode / $target_url\n";
        }
      }
    }
  }
?>
