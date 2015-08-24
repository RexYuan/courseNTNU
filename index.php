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
          $crecords[] = query("SELECT * FROM Courses WHERE CourseId = ?", $id)[0];
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
        $dpm_name = query("SELECT ChName FROM Departments WHERE DeptCode = ?", $_GET["dpm"])[0]["ChName"];
        // 解析 DeptCourseNameRecord 和 DeptCourseCodeRecord
        $drecords = array_map(function($n,$c){return ["name"=>$n,"code"=>$c];}, explode("/", $record["DeptCourseNameRecord"]), explode("/", $record["DeptCourseCodeRecord"]));
        // 輸出課程列表
        render("crs_lst.php", ["title" => $dpm_name, "urlroot" => $urlroot, "drecords" => $drecords]);
      }
    }

    // 首頁
    else if (count($_GET) === 0)
    {
      // 輸出系所列表
      render("dpm_lst.php", ["urlroot" => $urlroot, "dpms" => query("SELECT * FROM Departments")]);
    }

    // 亂來
    else
    {
      // 回首頁
      redirect("index.php");
    }
?>
