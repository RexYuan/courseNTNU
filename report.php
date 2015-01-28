<?php

    // requirements
    require("functions.php");
    require("constants.php");
    
    // if rated
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // insert report into report
        if (!isset($_SESSION["profile"]))
        {
            $_SESSION["profile"] = lookup($_POST["token"]);
        }
        $result = query("INSERT INTO report (report, fbID, fbMail, fbName, fbGender) VALUES (?, ?, ?, ?, ?)", $_POST["report"], $_SESSION["profile"]["id"], $_SESSION["profile"]["email"], $_SESSION["profile"]["name"], $_SESSION["profile"]["gender"]);
    }
    else
    {
        // render report form
        render("report_form.php", ["urlroot" => $urlroot]);
    }

?>
