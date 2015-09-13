<?php

    // requirements
    require_once("functions.php");
    require_once("constants.php");
    require_once("magic.php");

    // session
    if (session_status() == PHP_SESSION_NONE)
    {
      session_start();
    }

    // 課程資訊頁
    if (count($_GET) === 2 AND isset($_GET["dpm"]) AND isset($_GET["cod"]))
    {
      // 以 CourseCode 到 CourseRecords 搜尋 CourseIdRecord
      $ids = explode("/",query("SELECT CourseIdRecord FROM CourseRecords WHERE CourseCode = ?", $_GET["cod"])[0]["CourseIdRecord"]);
      // 搜尋不成功
      if (empty($ids))
      {
        // 回首頁
        redirect("index.php");
      }
      // 搜尋成功
      else
      {
        // 每期的課
        $crecords = [];
        // 以 CourseId 到 Courses 搜尋每個版本的課
        foreach ($ids as $id)
        {
          $crecords[] = query("SELECT Courses.*, Departments.*, Teachers.* FROM Courses INNER JOIN Departments, Teachers WHERE Courses.CourseId = ? AND Departments.DeptId = Courses.DeptId AND Courses.TeacherId = Teachers.TeacherId", $id)[0];
        }
        // 合併相同老師，目前只將投票數合併，時段尚未。
        for($idx = 0; $idx < count($crecords); $idx++)
        {
          if(isset($te_name_lst[$crecords[$idx]["TeChName"]]))
          {
            $crecords[$te_name_lst[$crecords[$idx]["TeChName"]]]["LikeIt"] += $crecords[$idx]["LikeIt"];
            $crecords[$te_name_lst[$crecords[$idx]["TeChName"]]]["DislikeIt"] += $crecords[$idx]["DislikeIt"];
            $remove_lst[] = $idx;
          }
          else
          {
            $te_name_lst[$crecords[$idx]["TeChName"]] = $idx;
          }
        }
        foreach ($remove_lst as $remove_idx)
        {
          unset($crecords[$remove_idx]);
        }
        // 輸出課程資訊頁
        render("crs_info.php", ["title" => $crecords[0]["ChName"], "urlroot" => $urlroot, "crecords" => $crecords]);
      }
    }

    // 系所課程列表
    else if (count($_GET) === 1 AND isset($_GET["dpm"]))
    {
      // 以 DeptId 去 DepartmentRecords 搜尋 DeptCourseNameRecord 和 DeptCourseCodeRecord
      $record = query("SELECT DeptCourseNameRecord, DeptCourseCodeRecord FROM DepartmentRecords WHERE DeptCode = ?", $_GET["dpm"])[0];
      // 搜尋不成功
      if (empty($record))
      {
        // 回首頁
        redirect("index.php");
      }
      // 搜尋成功
      else
      {
        // 搜尋系所名稱
        $dpm_name = query("SELECT DeptChName FROM Departments WHERE DeptCode = ?", $_GET["dpm"])[0]["DeptChName"];
        // 解析 DeptCourseNameRecord 和 DeptCourseCodeRecord
        $drecords = array_map(function($n,$c){return ["name"=>$n,"code"=>$c];}, explode("/", $record["DeptCourseNameRecord"]), explode("/", $record["DeptCourseCodeRecord"]));
        // 輸出課程列表
        render("crs_lst.php", ["title" => $dpm_name, "urlroot" => $urlroot, "drecords" => $drecords]);
      }
    }

    // 首頁
    else if (count($_GET) === 0)
    {
      // 前面是組名 後面是該組有幾個系
      $group_name_count = [["通用", 6], ["校際", 6], ["教育學院", 38], ["文學院", 23], ["理學院", 32],
                           ["藝術學院", 8], ["科技學院", 15], ["運休學院", 8], ["國社學院", 14],
                           ["音樂學院", 8], ["管理學院", 4], ["學程", 37], ["其他",1]];
      // 輸出系所列表
      render("dpm_lst.php", ["urlroot" => $urlroot, "dpms" => query("SELECT * FROM Departments"), "gnc"=>$group_name_count]);
    }

    // 亂來
    else
    {
      // 回首頁
      redirect("index.php");
    }
?>
