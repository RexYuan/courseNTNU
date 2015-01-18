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

        // if not yet voted
        if (empty($voterow))
        {
            $result = 'no';
        }
        // voted
        else
        {
            // liked it
            if ($vote["vote"] == 1)
            {
                $result = 'likeit';
            }
            // disliked it
            else if ($vote["vote"] == 0)
            {
                $result = "dislikeit";
            }
        }

        // echo JSON
        echo json_encode(["vote" => $vote]);
    }
    else
    {
        redirect($urlroot . "index.php");
    }

?>
