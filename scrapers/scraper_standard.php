<?php
    // ==> This scraper is intended for scraping standard courses page static info from 課程地圖大綱.

    // requirements
    require("functions.php");
    
    // iterate from AEU(11) to VDU(42)
    for ($dpmcode = 42; $dpmcode <= 42; $dpmcode++)
    {
        // query for department abbreviation
        $dpms = query("SELECT * FROM department WHERE id = ?", $dpmcode);
        $dpm = $dpms[0];
        
        // iterate from 0000 to 9999
        for ($i = 1; $i <= 1000; $i++)
        {
            // preping url
            $n = sprintf('%04d', $i);
            $course_code = $dpm['abbr'] . $n;
            $dept_code = $dpm['code'];
            print("Trying $course_code of $dept_code...\n");
            
            // html to xml
            if (!($tidy = tidy_parse_file("http://courseap.itc.ntnu.edu.tw/acadmOpenCourse/SyllabusTopCtrl?course_code=$course_code&dept_code=$dept_code",
                                          array("numeric-entities" => true, "output-xhtml" => true), "utf8")))
            {
                die("error\n");
            }
            else
            {
                // preping dom
                $tidy->cleanRepair();
                $xhtml = (string) $tidy;
                $dom = simplexml_load_string($xhtml);
                $dom->registerXPathNamespace("xhtml", "http://www.w3.org/1999/xhtml");
                
                // check if course exists
                $titleh = $dom->xpath("//xhtml:head/xhtml:title");
                $title = trim((string) $titleh[0]);
                if (strpos($title, "Error") !== false)
                {
                    print("*** Course doesn't exist, continuing\n");
                    continue;
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
                
                // retrieve Chinese name
                $chnametd = $dom->xpath("//xhtml:body/xhtml:center/xhtml:table/xhtml:tr/xhtml:td[@width='330']");
                $chname = trim((string) $chnametd[0]);
                print("Chinese name found: $chname\n");
           
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
                $dscrp = trim((string) $dscrptd[2]);
                print("Description found: $dscrp\n");
            
                // insert into database
                $result = query("INSERT INTO course (department, chdepartment, code, chname, description, credit) VALUES (?, ?, ?, ?, ?, ?)", $dpm['abbr'], $dpm['name'], $code, $chname, $dscrp, $credit);
                if ($result === false)
                {
                    print("*** Cannnot insert $code into database\n");
                }
            }
        }
    }
    
?>
