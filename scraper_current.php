<?php
    /*
        *** url GET request components ***

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
        I have no idea what random fuck is this shit
        , appears that blank for general ed
        , random number(usually 0~2) for others
        , please contact me if you know what does this mean.
       
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
    
    // iterate from 01U(1) to VDU(42)
    for ($dpmcode = 1; $dpmcode <= 42; $dpmcode++)
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
        $formS_set = ["", "1", "2"];
        
        // iterate from 000 to 999
        for ($i = 1; $i <= 999; $i++)
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
            $dept_group_component = "&deptGroup" . $dept_group
            // preping url
            $course_url = "http://courseap.itc.ntnu.edu.tw/acadmOpenCourse/SyllabusCtrl?" . $year_component . $term_component . $course_code_component . $course_group_component . $dept_code_component . $formS_component . $classes1_component . $dept_group_component;

            print("Trying $course_code...\n");
            
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
                // check if course group correct
                if ($chname === "null")
                {
                    print("Course name null, changing group\n");
                    if ($course_group_index < 2)
                    {
                        $course_group_index++;
                    }
                    else
                    {
                        $course_group_index = 0;
                        print("Course not available, continuing\n");
                        continue;
                    }
                    $i--;
                    continue;
                }
                else
                {
                    $course_group_index = 0;
                    print("Chinese name found: $chname\n");
                }
                
                // retrieve code
                $codetd = $dom->xpath("//xhtml:body/xhtml:center/xhtml:table/xhtml:tr/xhtml:td[@width='290']");
                // check if code is found
                if (isset($codetd[0]))
                {
                    $code = trim((string) $codetd[0]);
                    print("Code found: $code\n");
                    // check if course already in database
                    $dup = query("SELECT * FROM course WHERE code = ?", $code);
                    if (!empty($dup))
                    {
                        print("*** Code $code is duplicate, continuing\n");
                        continue;
                    }
                }
                else
                {
                    print("*** Code $course_code not found, continuing\n");
                    continue;
                }
           
                // retrieve English name
                $egnametd = $dom->xpath("//xhtml:body/xhtml:center/xhtml:table/xhtml:tr/xhtml:td[@width='820']");
                $egname = trim((string) $egnametd[0]);
                print("English name found: $egname\n");
            
                // retrieve credit
                $credittd = $dom->xpath("//xhtml:body/xhtml:center/xhtml:table/xhtml:tr/xhtml:td[@width='370']");
                $credit = trim((string) $credittd[1]);
                print("Credit found: $credit\n");
            
                // retrieve description
                $dscrptd = $dom->xpath("//xhtml:body/xhtml:center/xhtml:table/xhtml:tr/xhtml:td[@width='820']");
                $dscrp = trim((string) $dscrptd[3]);
                print("Description found: $dscrp\n");
            
                // insert into database
                $result = query("INSERT INTO course (department, chdepartment, code, chname, description, credit) VALUES (?, ?, ?, ?, ?, ?)", $dpm['abbr'], $dpm['name'], $code, $chname, $dscrp, $credit);
                if ($result === false)
                {
                    print("*** Cannnot insert $code into database\n");
                }
                else
                {
                    print("$code inserted\n\n");
                }
            }
        }
    }
    
?>
