<?php

    // requirements
    require_once("functions.php");
    require_once("constants.php");

    // session
    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }

    if (isset($_GET["word"]))
    {
        if ($_GET["word"] === "" || $_GET["word"] === "（" || $_GET["word"] === "）" || $_GET["word"] == " " || $_GET["word"] == "  " || $_GET["word"] == "／")
        {
            render("search_form.php", ["urlroot" => $urlroot]);
        }
        else
        {
            $searchrow = query("SELECT * FROM course WHERE chname LIKE ? OR teacher LIKE ?", "%".$_GET["word"]."%", "%".$_GET["word"]."%");

            render("search_form.php", ["urlroot" => $urlroot, "results" => $searchrow, "word" => $_GET["word"]]);
        }
    }
    else
    {
        render("search_form.php", ["urlroot" => $urlroot, "home" => true]);
    }

?>
