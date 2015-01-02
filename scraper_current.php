<?php
    /*
     *  TODO:
     *  1. url->formS and class1
     *  2. check teacher and avalability
     */
    
    // requirements
    require("functions.php");
    
    // iterate from AEU(11) to VDU(42)
    for ($dpmcode = 1; $dpmcode <= 42; $dpmcode++)
    {
        // query for department abbreviation
        $dpms = query("SELECT * FROM department WHERE id = ?", $dpmcode);
        $dpm = $dpms[0];
        
        //groupset index
        $j = 0;
        
        // iterate from 000 to 999
        for ($i = 1; $i <= 500; $i++)
        {
            // preping url
            $n = sprintf('%03d', $i);
            $course_code = $dpm['abbr'] . "G" . $n;
            $groupset = ["", "A", "B"];
            $course_group = $groupset[$j];
            print("Trying $course_code...\n");
            
            // html to xml
            if (!($tidy = tidy_parse_file("http://courseap.itc.ntnu.edu.tw/acadmOpenCourse/SyllabusCtrl?year=103&term=1&courseCode=$course_code&courseGroup=$course_group&deptCode=GU&formS=&classes1=&deptGroup=",
                                          array("numeric-entities" => true, "output-xhtml" => true), "utf8")))
            {
                print("error\n");
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
                    if ($j < 2)
                    {
                        $j++;
                    }
                    else
                    {
                        $j = 0;
                        print("Course not available, continuing\n");
                        continue;
                    }
                    $i--;
                    continue;
                }
                else
                {
                    $j = 0;
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
