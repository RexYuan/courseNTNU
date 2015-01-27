<?php

    // requirements
    require("functions.php");
    require("constants.php");
    
    // if rated
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // insert report into report
        $profile = lookup($_POST["token"]);
        $result = query("INSERT INTO report (report, fbID, fbMail, fbName, fbGender) VALUES (?, ?, ?, ?, ?)", $_POST["report"], $profile["id"], $profile["email"], $profile["name"], $profile["gender"]);
    }
    else
    {
        // render report form
        render("report_form.php", ["urlroot" => $urlroot]);
    }

?>
