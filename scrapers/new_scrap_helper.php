<?php
 require("../magic.php");
 /* For more info on this, read functions.php
  * The return value of this function is
  * an array containg all the retrieved rows
  * as associative arrays with column => value
  * structure.
  */
 function query()
 {
  $sql = func_get_arg(0);
  $parameters = array_slice(func_get_args(), 1);
  static $handle;
  if (!isset($handle))
  {
    try
    {
      $handle = new PDO("mysql:dbname=testing;unix_socket=/Applications/MAMP/tmp/mysql/mysql.sock;port=3306", USERNAME, PASSWORD);
      //$handle = new PDO("mysql:dbname=coursentnu;host=localhost;port=3306", USERNAME, PASSWORD);
      $handle->setAttribute(PDO::ATTR_EMULATE_PREPARES, False);
    }
    catch (Exception $e)
    {
      trigger_error($e->getMessage(), E_USER_ERROR);
      exit;
    }
  }
  $statement = $handle->prepare($sql);
  if ($statement === False)
  {
    trigger_error($handle->errorInfo()[2], E_USER_ERROR);
    exit;
  }
  $results = $statement->execute($parameters);
  if ($results !== False)
  {
    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }
  else
  {
     return False;
  }
 }

// get departments inf
$DEPT_LANGUAGE = "chn";
$YEAR = 104;
$TERM = 1;
$DEPT_URL_GET_BASE = "http://courseap.itc.ntnu.edu.tw/acadmOpenCourse/CofnameCtrl?";
$DEPARTMENT_CODE_LIST = parse_dept_code(file_get_contents($DEPT_URL_GET_BASE . "type=" . $DEPT_LANGUAGE . "&year=" . $YEAR ."&term=" . $TERM));

$URL_GET_BASE = 'http://courseap.itc.ntnu.edu.tw/acadmOpenCourse/CofopdlCtrl?';
$URL_GET_LIST = [
    '_dc'          => '',
    'acadmYear'    => $YEAR,
    'acadmTerm'    => $TERM,
    'chn'          => '',
    'engTeach'     => 'N',
    'moocs'        => 'N',
    'remoteCourse' => 'N',
    'deptCode'     => '',
    'classCode'    => '',
    'generalCore'  => '',
    'teacher'      => '',
    'language'     => 'chinese',
    'action'       => 'showGrid',
    'start'        => '0',
    'limit'        => '99999',
    'page'         => '1'
];

  /**
   * Parse the given time_inf value and return an array of arrays,
   * which contains four arguments, representing the day, time, campus, and location
   * of the course. Returns NULL if time_inf is an empty string.
   * For time_inf "三 8-9 公館 理圖807,五 7 公館 理圖807,", it returns
   * Array
   * (
   *     [0] => Array
   *         (
   *             [0] => 三
   *             [1] => 8-9
   *             [2] => 公館
   *             [3] => 理圖807
   *         )
   *     [1] => Array
   *         (
   *             [0] => 五
   *             [1] => 7
   *             [2] => 公館
   *             [3] => 理圖807
   *         )
   * )
   */
function parse_time_inf($str)
{
    // check if there's time_inf
    if (!empty($str))
    {
        // to be returned
        //$result = [];
        //temporarily changing this output format because course simulation is not yet ready
        $result = ["TimeInfo"=>"", "ChLocation"=>""];
        // check if there's more than one time
        $sub_strs = array_slice(explode(",", $str), 0, $length = -1);
        // parse every time
        foreach ($sub_strs as $sub_str)
        {
            list($day, $time, $campus, $location) = explode(" ", $sub_str);
            //$result[] = [$day, $time, $campus, $location];
            //temporarily changing this output format because course simulation is not yet ready
            $result["TimeInfo"] = $result["TimeInfo"].$day.$time;
            $result["ChLocation"] = $result["ChLocation"].$campus.$location;
        }
        // return an array of arrays of info
        return $result;
    }
    else
    {
        return ["TimeInfo"=>"", "ChLocation"=>""];
    }
}

//Use to parse the department code and name mapping
function parse_dept_code($dept_str) {
    $dept_str = substr($dept_str, 1, strlen($dept_str) - 2);
    $tok = strtok($dept_str , "]");

    while($tok !== False) {
      $tok = substr($tok, strpos($tok, "[") + 1);
      sscanf($tok, "'%*[^']','%[^ ]%[^'']'", $code, $name);
      $dept_list[$code] = $name;
      $tok = strtok("]");
    }

    return $dept_list;
}

 /**
  * This function takes a teacher's Chinese name(string)
  * and the teacher's department. Then, try to look up teacher's id.
  * If the name is not yet recorded in Teacheres table,
  * insert its info and returns the id.
  * If the name is already recorded, returns id right away.
  */
function lookup_teacher_id_by_name($dept_id, $name)
{
  $result = query("SELECT TeacherId FROM Teachers WHERE ChName = ? AND DeptId = ?", $name, $dept_id);
  //TODO: solve the problem of multiple teachers with identical name in the same department
  if ($result)
  {
    return $result[0]['TeacherId'];
  }
  else
  {
    query("INSERT INTO Teachers (DeptId, ChName) VALUES (?, ?)", $dept_id, $name);
    return query("SELECT TeacherId FROM Teachers WHERE ChName = ? AND DeptId = ?", $name, $dept_id)[0]['TeacherId'];
  }
}

/**
 * This function takes a DeptCode and returns its DeptId.
 */
function lookup_dept_id_by_code($dept_code)
{
  return query("SELECT DeptId FROM Departments WHERE DeptCode = ?", $dept_code)[0]['DeptId'];
}

/**
 * This function is used to parse the hour string
 * in course page and returns the hour value as an int.
 * Example: $str      = "正課時數 : 2 小時"
 *          $match[0] = 2
 */
function parse_hour($str)
{
  preg_match("/\d/",$str,$match);
  return (int)$match[0];
}

/**
 * This function takes required get request variable to
 * retrieve infomation from course page.
 * This function returns [$hour, $description].
 * For more details, see scraper_helper_functions.php.
 */
function lookup_course_page($courseCode, $courseGroup, $deptCode, $formS, $classes1, $deptGroup)
{
  global $YEAR, $TERM;
  $tidy =  new tidy;
  $tidy -> parseFile("http://courseap.itc.ntnu.edu.tw/acadmOpenCourse/SyllabusCtrl?year=$YEAR&term=$TERM&courseCode=$courseCode&courseGroup=$courseGroup&deptCode=$deptCode&formS=$formS&classes1=$classes1&deptGroup=$deptGroup", ["output-xhtml"=>true,"indent"=>true,"indent-attributes"=>true,"numeric-entities"=>true,"bare"=>true,"clean"=>true,"word-2000"=>true,"wrap"=>0], "utf8");
  $tidy -> cleanRepair();
  $xhtml = preg_replace('/\n\s*<tr>\n\s*<td\swidth="900"\n\s*align="left"\n\s*bgcolor="#DFEFFF"\n\s*colspan="3"\n\s*height="20">\n\s*<b>教學進度與主題<\/b>\n\s*<\/td>\n\s*<\/tr>.*\n\s*<\/td>\n\s*<\/tr>/s', '', (string)$tidy);
  $dom = new SimpleXMLElement($xhtml);
  $dom->registerXPathNamespace("xhtml", "http://www.w3.org/1999/xhtml");
  return [parse_hour(trim((string)$dom->xpath("/xhtml:html/xhtml:body/xhtml:div/xhtml:table[4]/xhtml:tr[4]/xhtml:td[4]")[0])), trim((string)$dom->xpath("/xhtml:html/xhtml:body/xhtml:div/xhtml:table[4]/xhtml:tr[7]/xhtml:td[2]")[0])];
}
?>
