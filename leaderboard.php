<?php

    // requirements
    require("functions.php");
    require("constants.php");
    
    // query for 10 class with highest ratings
    $geleaderrows = query("SELECT *, (likeit/(likeit+dislikeit)) AS ratings FROM course WHERE (likeit+dislikeit) >= 10 AND (likeit/(likeit+dislikeit)) IS NOT NULL AND department IN ('01U', '02U', '03U', '04U', '05U', '06U', '0AU', '0HU', '0NU', '0SU') ORDER BY ratings DESC LIMIT 10");
    $otherleaderrows = query("SELECT *, (likeit/(likeit+dislikeit)) AS ratings FROM course WHERE (likeit+dislikeit) >= 5 AND (likeit/(likeit+dislikeit)) IS NOT NULL AND department NOT IN ('01U', '02U', '03U', '04U', '05U', '06U', '0AU', '0HU', '0NU', '0SU') ORDER BY ratings DESC LIMIT 10");

    // render leaderboard
    render("leaderboard_plate.php", ["title" => "課程排行榜", "urlroot" => $urlroot, "geleaders" => $geleaderrows, "otherleaders" => $otherleaderrows])

?>
