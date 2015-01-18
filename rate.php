<?php

    // requirements
    require("functions.php");
    require("constants.php");
    
    // if rated
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // check if voted
        $voterow = query("SELECT * FROM vote WHERE fbid = ? AND code = ?", $_POST["fbid"], $_POST["code"]);

        // if liked
        if ($_POST["rate"] == "推")
        {
            // update database
            if (empty($voterow))
            {
                //query("INSERT INTO vote WHERE fbid = ? AND code = ? AND vote = ?", $_POST["fbid"], $_POST["code"], '1');
                $result = query("UPDATE course SET likeit = likeit + 1 WHERE code = ?", $_POST["code"]);
            //}
            /*else
            {
                if (voted[0]["vote"] == '1')
                {
                    query("DELETE FROM vote WHERE fbid = ? AND code = ? AND vote = ?", $_POST["fbid"], $_POST["code"], '1');
                    $result = query("UPDATE course SET likeit = likeit - 1 WHERE code = ?", $_POST["code"]);
                }
                else
                {
                    query("UPDATE vote SET vote = 0 WHERE fbid = ? AND code = ? AND vote = ?", $_POST["fbid"], $_POST["code"], '1');
                    $result = query("UPDATE course SET likeit = likeit - 1 WHERE code = ?", $_POST["code"]);
                    $result = query("UPDATE course SET dislikeit = dislikeit + 1 WHERE code = ?", $_POST["code"]);
                }
            }*/
        }

        // if disliked
        /*else if ($_POST["rate"] == "不推")
        {
            // update database
            if (isempty($voted))
            {
                query("INSERT INTO vote WHERE fbid = ? AND code = ? AND vote = ?", $_POST["fbid"], $_POST["code"], '0');
                $result = query("UPDATE course SET dislikeit = dislikeit + 1 WHERE code = ?", $_POST["code"]);
            }
            else
            {
                if (voted[0]["vote"] == '0')
                {
                    query("DELETE FROM vote WHERE fbid = ? AND code = ? AND vote = ?", $_POST["fbid"], $_POST["code"], '0');
                    $result = query("UPDATE course SET dislikeit = dislikeit - 1 WHERE code = ?", $_POST["code"]);
                }
                else
                {
                    query("UPDATE vote SET vote = 0 WHERE fbid = ? AND code = ? AND vote = ?", $_POST["fbid"], $_POST["code"], '0');
                    $result = query("UPDATE course SET dislikeit = dislikeit - 1 WHERE code = ?", $_POST["code"]);
                    $result = query("UPDATE course SET likeit = likeit + 1 WHERE code = ?", $_POST["code"]);
                }
            }
        }*/
        
        // query database
        $course = query("SELECT * FROM course WHERE code = ?", $_POST["code"]);
        // calculates JSON
        $total = $course[0]["likeit"] + $course[0]["dislikeit"];
        $like_percentage = $course[0]["likeit"] / ($total);
        $like_bar = ((string) ($like_percentage * 100)) . "%";
        $dislike_bar = ((string) ((1 - $like_percentage) * 100)) . "%";
        $message = "根據 $total 個投票";
        $ratings = sprintf('%2d', ($like_percentage * 100));

        // echo JSON
        echo json_encode(["ratings" => $ratings, "like_bar" => $like_bar, "dislike_bar" => $dislike_bar, "message" => $message, "voted" => $voterow[0]]);
    }
    else
    {
        redirect($urlroot . "index.php");
    }

?>
