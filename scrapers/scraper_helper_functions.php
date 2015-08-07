<?php
  require("../functions.php");

  // retriever function to scrape information
  $config   = ["output-xhtml"      => true,
               "indent"            => true,
               "indent-attributes" => true,
               "numeric-entities"  => true,
               "bare"              => true,
               "clean"             => true,
               "word-2000"         => true,
               "wrap"              => 0];
  $encoding =  "utf8";
  function retrieve($source_url)
  {
    // preping
    global $config, $encoding;
    $tidy     =  new tidy;
    $tidy     -> parseFile($source_url, $config, $encoding);
    $tidy     -> cleanRepair();
    $xhtml = preg_replace('/\n\s*<tr>\n\s*<td\swidth="900"\n\s*align="left"\n\s*bgcolor="#DFEFFF"\n\s*colspan="3"\n\s*height="20">\n\s*<b>教學進度與主題<\/b>\n\s*<\/td>\n\s*<\/tr>.*\n\s*<\/td>\n\s*<\/tr>/s', '', (string)$tidy);
    $dom = new SimpleXMLElement($xhtml);
    $dom->registerXPathNamespace("xhtml", "http://www.w3.org/1999/xhtml");
    // retrieving chinese course name
    $data_course_chinese_name = trim((string)$dom->xpath("/xhtml:html/xhtml:body/xhtml:div/xhtml:table[4]/xhtml:tr[1]/xhtml:td[4]")[0]);
    // checking if course exist
    if ($data_course_chinese_name == "null")
    {
      return False;
    }
    else
    {
      // grabbing other data
      $data_course_english_name = trim((string)$dom->xpath("/xhtml:html/xhtml:body/xhtml:div/xhtml:table[4]/xhtml:tr[2]/xhtml:td[2]")[0]);
      $data_course_code = trim((string)$dom->xpath("/xhtml:html/xhtml:body/xhtml:div/xhtml:table[4]/xhtml:tr[1]/xhtml:td[2]")[0]);
      $data_course_credit = trim((string)$dom->xpath("/xhtml:html/xhtml:body/xhtml:div/xhtml:table[4]/xhtml:tr[4]/xhtml:td[2]")[0]);
      $data_course_description = trim((string)$dom->xpath("/xhtml:html/xhtml:body/xhtml:div/xhtml:table[4]/xhtml:tr[7]/xhtml:td[2]")[0]);
      $data_course_instructor = trim((string)$dom->xpath("/xhtml:html/xhtml:body/xhtml:div/xhtml:table[6]/xhtml:tr[1]/xhtml:td[2]")[0]);

      return ['code'         => $data_course_code,
              'chinese_name' => $data_course_chinese_name,
              'english_name' => $data_course_english_name,
              'credit'       => $data_course_credit,
              'description'  => $data_course_description,
              'instructor'   => $data_course_instructor];
    }
  }

 ?>
