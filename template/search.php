<?php

    // requirements
    require("functions.php");
    require("constants.php");
    
    // if rated
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // query database
        $searchrow = query("SELECT * FROM course WHERE chname LIKE %?%", $GET["word"]);
        $search = $searchrow[0];

        // echo JSON
        echo json_encode(["vote" => $vote["vote"]]);
    }
    else
    {
        redirect($urlroot . "index.php");
    }

?>
