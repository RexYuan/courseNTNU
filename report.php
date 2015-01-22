<?php

    // requirements
    require("functions.php");
    require("constants.php");
    
    // if rated
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // insert report into report
        $result = query("INSERT INTO report (report, fbID, fbMail, fbName, fbLink, fbGender) VALUES (?, ?, ?, ?, ?, ?)", $_POST["report"], $_POST["fbid"], $_POST["fbmail"], $_POST["fbname"], $_POST["fblink"], $_POST["fbgender"]);
    }
    else
    {
        // render report form
        render("report_form.php", ["urlroot" => $urlroot]);
    }

?>
