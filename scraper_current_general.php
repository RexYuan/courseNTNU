<?php

    /*
       ==> This scraper is intended for scraping general ed courses page current info from 選課系統大綱.

       *** NTNU Course Page(選課系統) URL GET Request Components Guide ***

        A URL for a course page info from 選課系統大綱 will look something like this:
        http://courseap.itc.ntnu.edu.tw/acadmOpenCourse/SyllabusCtrl?year=103&term=2&courseCode=01UG025&courseGroup=&deptCode=GU&formS=&classes1=&deptGroup
        The first part(http://courseap.itc.ntnu.edu.tw/acadmOpenCourse/SyllabusCtrl) is the controller of course page info GET request
        , the second part seperated by the question mark is the actual GET request sent to that controller.
        You will find below the detailed description for each and every part of the GET request.

       year:
        學年.

       term:
        semester, '1' for the first and '2' for the second.

       courseCode:
        course code, same for the same course
        , 7 chars total, with first 3 chars being the department code(consult abbr column in department.sql)
        , the forth char being 'G' for general ed or a number(0~9) for others
        , last 3 chars are all numbers(000~999).

       courseGroup:
        indicator for different offers of a single course
        , blank if course has only one offer
        , 1 char if course is offered differently depending on time or instructor
        , 1 char being a letter(A~Z).

       deptCode:
        department code, same for courses under same department
        , 2 chars for general ed and 4 chars for others total
        , 2 chars for general ed being 'GU'
        , 4 chars for others is random shits(consult code column department.sql db).
       
       *formS:
        The grade is course is intended for
        , blank for general ed or not restricted
        , a number(1~4) for every grade(大一 => 1, 大二 => 2, 大三 => 3, 大四 => 4).
       
       classes1:
        indicator for different offers for different classes of a single department of a single course
        , blank if course has only offer or for general ed
        , 1 char if course is offered to more that one class(班別)
        , 1 char being a number(0~9) whichs corresponds to 天干地支(甲乙丙...).

       deptGroup:
        department group for which course is intended
        , blank if department has only one group
        , a char if department is divided into more than one group
        , a char being a letter(A~Z)
        , currently only 美術系 is divided into 2 groups(A/B).  
    */
    
    // requirements
    require("functions.php");

    $iii = 0;
    
    // iterate from 01U(1) to 0SU(10)
    for ($dpmcode = 10; $dpmcode <= 10; $dpmcode++)
    {
        // query for department abbreviation
        $dpmrow = query("SELECT * FROM department WHERE id = ?", $dpmcode);
        $dpm = $dpmrow[0];

        // constants
        $year_component = "year=103";
        $term_component = "&term=2";

        // course group set and index
        $course_group_index = 0;
        $course_group_set = ["", "A", "B", "C", "D", "E", "F"];

        // formS set and index
        $formS_set_index = 0;
        $formS_set = ["", "1", "2", "3", "4"];
        
        // iterate from 000 to 999
        for ($i = 500; $i <= 550; $i++)
        {
            // preping url components
            // preping courseCode
            $n = sprintf('%03d', $i);
            $course_code = $dpm['abbr'] . "G" . $n;
            $course_code_component = "&courseCode=" . $course_code;

            // preping courseGroup
            $course_group = $course_group_set[$course_group_index];
            $course_group_component = "&courseGroup=" . $course_group;

            // preping deptCode
            $dept_code = "GU";
            $dept_code_component = "&deptCode=" . $dept_code;

            // preping formS
            $formS = "";
            $formS_component = "&formS=" . $formS;

            // preping classes1
            $classes1 = "";
            $classes1_component = "&classes1=" . $classes1;

            // preping deptGroup
            $dept_group = "";
            $dept_group_component = "&deptGroup" . $dept_group;

            // preping url
            $course_url = "http://courseap.itc.ntnu.edu.tw/acadmOpenCourse/SyllabusCtrl?" . $year_component . $term_component . $course_code_component . $course_group_component . $dept_code_component . $formS_component . $classes1_component . $dept_group_component;

            print("=> Trying: $course_url\n");
            
            // html to xml
            if (!($tidy = tidy_parse_file($course_url, array("numeric-entities" => true, "output-xhtml" => true), "utf8")))
            {
                print("*** Error: cannot parse page\n");
            }
            else
            {
                // preping dom
                $tidy->cleanRepair();
                $xhtml = (string) $tidy;
                $dom = simplexml_load_string($xhtml);
                $dom->registerXPathNamespace("xhtml", "http://www.w3.org/1999/xhtml");
                
                // retrieve Chinese name
                $chnametd = $dom->xpath("//xhtml:body/xhtml:center/xhtml:table/xhtml:tr/xhtml:td[@width='330']");
                $chname = trim((string) $chnametd[0]);

                // check if course exist
                if ($chname === "null")
                {
                    // course does not exist, checking other course group
                    print("* Course $course_code chname null, changing course group from $course_group\n");
                    if ($course_group_index < 7)
                    {
                        // check next course group
                        $course_group_index++;
                    }
                    // all possible group checked, still not found
                    else
                    {
                        // reset course group index
                        $course_group_index = 0;
                        print("*** Course $course_code does not exist, continuing\n");
                        // check next course
                        continue;
                    }
                    // make the course code stay the same
                    $i--;
                    // recheck this course in another group
                    continue;
                }
                // course found
                else
                {
                    // if course only has one offer
                    if ($course_group_index == 0)
                    {
                        // reset course group index
                        $course_group_index = 0;    
                    }
                    // if other group possibly exist
                    else if ($course_group_index < 7)
                    {
                        // check next course group
                        $course_group_index++;
                        // make the course code stay the same
                        $i--;
                    }
                    print("# Chinese name found: $chname\n");
                }
                
                // retrieve code
                $codetd = $dom->xpath("//xhtml:body/xhtml:center/xhtml:table/xhtml:tr/xhtml:td[@width='290']");
                // double checking if course exist
                if (isset($codetd[0]))
                {
                    $code = trim((string) $codetd[0]);
                    print("# Code found: $code\n");
                    // check if course already in database
                    $dup = query("SELECT * FROM course WHERE code = ?", $code);
                    // course already exist
                    if (!empty($dup))
                    {
                        print("=> Code $code is duplicate, checking current info\n");

                        // retrieve instructor
                        $instd = $dom->xpath("//xhtml:body/xhtml:center/xhtml:table[@id='table11']/xhtml:tr/xhtml:td[@width='750']");
                        $ins = trim((string) $instd[0]);
                        print("# Instructor found: $ins\n");

                        // check if already has more than or equal to one instructor
                        if ($dup[0]["teacher"] != "")
                        {
                            // check if instrctor is not duplicate
                            if (strpos($dup[0]["teacher"],$ins) === false)
                            {
                                $ins = $dup[0]["teacher"] . '、' . $ins;
                                print("* Instructor more than one updating to $ins\n");
                            }
                            // already inserted this instructor
                            else
                            {
                                print("* Already inserted $ins, continuing\n");
                                // check next course
                                continue;
                            }
                        }

                        // storing data
                        $result = query("UPDATE course SET availability = ?, grade = ?, teacher = ? WHERE code = ?", '1', '沒有限制', $ins, $code);
                        if ($result === false)
                        {
                            print("*** Cannnot insert $code into database\n");
                        }
                        else
                        {
                            print("### $code inserted\n\n");
                            $jjj++;
                            print("==> Course $course_code updated, total inserted = $iii, total updated = $jjj\n");
                    }
                        // check next course
                        continue;
                    }
                }
                // course does not exist
                else
                {
                    print("*** Code $course_code not found, continuing\n");
                    continue;
                }
            
                // retrieve credit
                $credittd = $dom->xpath("//xhtml:body/xhtml:center/xhtml:table/xhtml:tr/xhtml:td[@width='370']");
                $credit = trim((string) $credittd[1]);
                print("# Credit found: $credit\n");
            
                // retrieve description
                $dscrptd = $dom->xpath("//xhtml:body/xhtml:center/xhtml:table/xhtml:tr/xhtml:td[@width='820']");
                $dscrp = trim((string) $dscrptd[3]);
                print("# Description found: $dscrp\n");

                // retrieve instructor
                $instd = $dom->xpath("//xhtml:body/xhtml:center/xhtml:table[@id='table11']/xhtml:tr/xhtml:td[@width='750']");
                $ins = trim((string) $instd[0]);
                print("# Instructor found: $ins\n");

                // storing regular data
                $result = query("INSERT INTO course (department, chdepartment, code, chname, description, credit, availability, grade, teacher) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)", $dpm['abbr'], $dpm['name'], $code, $chname, $dscrp, $credit, '1', '沒有限制', $ins);
                if ($result === false)
                {
                    print("*** Cannnot insert $code into database\n");
                }
                else
                {
                    print("### $code inserted\n\n");
                    $iii++;
                    print("New courses $course_code inserted, total inserted = $iii, total updated = $jjj\n");
                }
            }
        }
    }

?>