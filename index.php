<?php

    // requirements
    require("functions.php");
    require("constants.php");

    // if a course selected
    /*if (isset($_GET["dpm"]) && isset($_GET["cod"]))
    {
        query("SET NAMES utf8");
        // query courses for corresponding course
        $course = query("SELECT * FROM course WHERE code = ?", $_GET["cod"]);
        
        // calculates ratings
        if ($course[0]["likeit"] == 0 && $course[0]["dislikeit"] == 0)
        {
            $like_bar = "0%";
            $dislike_bar = "0%";
            $message = "沒有資料";
            $ratings = "N/A";
        }
        else
        {
            $total = $course[0]["likeit"] + $course[0]["dislikeit"];
            $like_percentage = $course[0]["likeit"] / ($total);
            $like_bar = ((string) ($like_percentage * 100)) . "%";
            $dislike_bar = ((string) ((1 - $like_percentage) * 100)) . "%";
            $message = "根據 $total 個投票";
            $ratings = sprintf('%2d', ($like_percentage * 100));
        }
        
        // render course page
        render("course_page.php", ["urlroot" => $urlroot, "course" => $course[0], "likes" => $like_bar, "dislikes" => $dislike_bar, "message" => $message, "ratings" => $ratings]);
    }
    
    // if a department selected
    else if (isset($_GET["dpm"]))
    {
        query("SET NAMES utf8");
        // query courses for corresponding courses
        $courses = query("SELECT * FROM course WHERE department = ?", $_GET["dpm"]);
        
        // render courses list
        render("course.php", ["urlroot" => $urlroot, "courses" => $courses]);
    }
    
    // if nothing selected
    else
    {
        // render department list
        render("department.php", ["urlroot" => $urlroot]);
    }*/
    
    $_POST["code"] = 'ITU0004';
    $_POST["fbid"] = '10203739867764562';
    $voterow = query("SELECT * FROM vote WHERE code = ? AND fbid = ?", $_POST["code"], $_POST["fbid"]);
    $vote = $voterow[0];
    print_r(query("SELECT * FROM vote WHERE code = ? AND fbid = ?", $_POST["code"], $_POST["fbid"]));
    print("\n\n");
    print_r($voterow);
    print("\n\n");
    print_r($vote);
?>
