<?php

    // requirements
    require("functions.php");
    require("constants.php");
    require("magic.php");
    require_once 'vendor/autoload.php';

    session_start();

    // if a course selected
    if (isset($_GET["dpm"]) && isset($_GET["cod"]))
    {
        // query courses for corresponding course
        $course = query("SELECT * FROM course WHERE code = ?", $_GET["cod"]);

        // if query some random shit
        if (empty($course))
        {
            // back to front page
            redirect("index.php");
        }
        else
        {
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

            // prepare course page url for Facebook comment
            $page_url = $urlroot . "index.php?dpm=" . $course[0]["department"] . "&cod=" . $course[0]["code"];
        
            // render course page
            render("course_page.php", ["title" => $course[0]["chname"], "urlroot" => $urlroot, "course" => $course[0], "likes" => $like_bar, "dislikes" => $dislike_bar, "message" => $message, "ratings" => $ratings, "purl" => $page_url]);
        }
    }
    
    // if a department selected
    else if (isset($_GET["dpm"]))
    {
        // if checking 一般通識
        if ($_GET["dpm"] === "0GU")
        {
            // query courses for all corresponding courses of 一般通識
            $departs = query("SELECT * FROM department WHERE abbr IN (?, ?, ?, ?)", '0AU', '0HU', '0NU', '0SU');
            $courses = query("SELECT * FROM course WHERE department = ? OR department = ? OR department = ? OR department = ?", $departs[0]["abbr"], $departs[1]["abbr"], $departs[2]["abbr"], $departs[3]["abbr"]);
            // render courses list
            render("course.php", ["title" => "一般通識", "urlroot" => $urlroot, "courses" => $courses]);
        }
        // checking other department
        else
        {
            // query courses for corresponding courses
            $courses = query("SELECT * FROM course WHERE department = ?", $_GET["dpm"]);

            // if query some random shit
            if (empty($courses))
            {
                // back to front page
                redirect("index.php");
            }
            // query good
            else
            {
                // render courses list
                render("course.php", ["title" => $courses[0]["chdepartment"], "urlroot" => $urlroot, "courses" => $courses]);
            }
        }
    }
    
    // if nothing selected
    else
    {
        // render department list
        render("department.php", ["urlroot" => $urlroot]);
    }
?>
