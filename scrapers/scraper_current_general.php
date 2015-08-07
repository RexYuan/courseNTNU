<?php
    // ==> This scraper is intended for scraping general ed courses page current info from 選課系統大綱.

    // requirements
    require("functions.php");

    $iii = 0;

    // iterate from 01U(1) to 0SU(10) *see p.s. 1 in guide
    for ($dpmcode = 1; $dpmcode <= 10; $dpmcode++)
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

        // iterate from 000 to 999 *see p.s. 1 in guide
        for ($i = 0; $i <= 999; $i++)
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
