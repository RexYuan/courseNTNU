<?php

    // requirements
    require("functions.php");
    
    // query courses for corresponding course
    $a="AEU0001";
    $course = query("SELECT * FROM course WHERE code = ?", $a);
    
    //print_r($course);

    $like_percentage = 1 / (1 + 1);
    //print($like_percentage);
            $like_ratings = ((string)($like_percentage*100)) . "%";
            $dislike_ratings = ((string)((1-$like_percentage)*100)) . "%";
    print($like_ratings);
    print($dislike_ratings);
    
?>
