<?php

    // requirements
    require("functions.php");
    require("constants.php");
    
    // if rated
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // query database
        $voterow = query("SELECT * FROM vote WHERE code = ? AND fbid = ?", $_POST["code"], $_POST["fbid"]);
        $vote = $voterow[0];

        // echo JSON
        echo json_encode(["vote" => $vote["vote"]]);
    }
    else
    {
        redirect($urlroot . "index.php");
    }

?>
