<?php

    // requirements
    require("functions.php");
    require("constants.php");
    
    // if rated
    if (isset($_GET["word"]))
    {
        // query database
        $searchrow = query("SELECT * FROM course WHERE chname LIKE ?", $_GET["word"]."%");

        render("search_form.php", ["urlroot" => $urlroot, "results" => $searchrow]);
    }
    else
    {
        render("search_form.php", ["urlroot" => $urlroot]);
    }

?>
