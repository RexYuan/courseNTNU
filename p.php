<?php

    // requirements
    require("functions.php");
    
    $course_code = "01UG005";
    $course_group = "A";

    $tidy = tidy_parse_file("http://courseap.itc.ntnu.edu.tw/acadmOpenCourse/SyllabusCtrl?year=103&term=1&courseCode=$course_code&courseGroup=$course_group&deptCode=GU&formS=&classes1=&deptGroup=",
                                          array("numeric-entities" => true, "output-xhtml" => true), "utf8");
    $tidy->cleanRepair();
                $xhtml = (string) $tidy;
                $dom = simplexml_load_string($xhtml);
                $dom->registerXPathNamespace("xhtml", "http://www.w3.org/1999/xhtml");
                //print($xhtml);
                $groupset = ["", "A", "B"];
?>
