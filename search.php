<?php

    // requirements
    require("functions.php");
    require("constants.php");
    
    // if rated
    if (isset($_GET["word"]))
    {
        // query database
        $searchrow = query("SELECT * FROM course WHERE code LIKE ?", $GET["word"]);

        //render("search_form.php", ["urlroot" => $urlroot, "results" => $searchrow]);
        print_r($searchrow);
    }
    else
    {
        render("search_form.php", ["urlroot" => $urlroot]);
    }

?>
