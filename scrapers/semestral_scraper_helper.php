<?php
$YEAR = 104;
$TERM = 1;

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
  $result = query("SELECT TeacherId FROM Teachers WHERE TeChName = ? AND DeptId = ?", $name, $dept_id);
  //TODO: solve the problem of multiple teachers with identical name in the same department
  if ($result)
  {
    return $result[0]['TeacherId'];
  }
  else
  {
    query("INSERT INTO Teachers (DeptId, TeChName) VALUES (?, ?)", $dept_id, $name);
    return query("SELECT TeacherId FROM Teachers WHERE TeChName = ? AND DeptId = ?", $name, $dept_id)[0]['TeacherId'];
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

// 以下是抓選課系統用
// URL List
$URL = array(
    "GET_ID" => "http://cos1.ntnu.edu.tw/AasEnrollStudent/LoginCheckCtrl",
    "SET_CAPTCHA" => "http://cos1.ntnu.edu.tw/AasEnrollStudent/RandImage",
    "GET_CAPTCHA" => "http://cos1.ntnu.edu.tw/AasEnrollStudent/ImageBoxFromIndexCtrl",
    "LOGIN" => "http://cos1.ntnu.edu.tw/AasEnrollStudent/LoginCheckCtrl?action=login&id=",
    "LOGIN2" => "http://cos1.ntnu.edu.tw/AasEnrollStudent/LoginCtrl",
    "QUERY" => "http://cos1.ntnu.edu.tw/AasEnrollStudent/CourseQueryCtrl?action=query",
    "QUERY_BASE" => "http://cos1.ntnu.edu.tw/AasEnrollStudent/CourseQueryCtrl?action=showGrid&deptCode=",
);
// Cookies File Path
$COOKIES_PATH = "./cookies.txt";
// Debug features are not implemented yet
$DEBUG = False;
// 學號
$ACCOUNT = CUSERNAME;
// 密碼
$PASSWORD = CPASSWORD;
// 中文姓名
$NAME = "";
function get_data($dept_code)
{
    $ch = curl_init();
    $id = get_id($ch);
    set_captcha($ch);
    $captcha = get_captcha($ch);
    login($ch, $captcha, $id);
    login2($ch);

    query_request($ch);
    course_query($ch, "");

    //Course query starts here
    $result = course_query($ch, $dept_code);
    //end here
    curl_close($ch);

    return json_decode($result, $assoc = True)['List'];
}
function get_id($ch) {
    global $URL, $COOKIES_PATH, $DEBUG;
    curl_setopt_array($ch, array(
        CURLOPT_URL => $URL["GET_ID"],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_COOKIESESSION => false,
        CURLOPT_COOKIEJAR => $COOKIES_PATH
    ));
    $lines = explode(PHP_EOL, curl_exec($ch));
    sscanf($lines[264], "%*s %*s '%[^']", $id);
    return $id;
}
function set_captcha($ch) {
    global $URL, $COOKIES_PATH, $DEBUG;
    curl_setopt_array($ch, array(
        CURLOPT_URL => $URL["SET_CAPTCHA"],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_COOKIEFILE => $COOKIES_PATH
    ));
    curl_exec($ch);
}
function get_captcha($ch) {
    global $URL, $COOKIES_PATH, $DEBUG;
    curl_setopt_array($ch, array(
        CURLOPT_URL => $URL["GET_CAPTCHA"],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_COOKIEFILE => $COOKIES_PATH
    ));
    sscanf(curl_exec($ch), "{success:true,msg:\"%[^\"]", $captcha);
    return $captcha;
}
function login($ch, $captcha, $id) {
    global $URL, $COOKIES_PATH, $DEBUG, $ACCOUNT, $PASSWORD;
    curl_setopt_array($ch, array(
            CURLOPT_URL => $URL["LOGIN"] . $id,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query(array(
                "userid" => $ACCOUNT,
                "password" => $PASSWORD,
                "validateCode" => $captcha
            )),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_COOKIEFILE => $COOKIES_PATH,
    ));
    curl_exec($ch);
}
function login2($ch) {
    global $URL, $COOKIES_PATH, $DEBUG, $ACCOUNT, $NAME;
    curl_setopt_array($ch, array(
        CURLOPT_URL => $URL["LOGIN2"],
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => http_build_query(array(
            "userid" => $ACCOUNT,
            "stdName" => $NAME
        )),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_COOKIEFILE => $COOKIES_PATH
    ));
    curl_exec($ch);
}
function query_request($ch) {
    global $URL, $COOKIES_PATH, $DEBUG;
    curl_setopt_array($ch, array(
        CURLOPT_URL => $URL["QUERY"],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_COOKIEFILE => $COOKIES_PATH,
    ));
    $response = curl_exec($ch);
}
function course_query($ch, $deptCode) {
    global $URL, $COOKIES_PATH, $DEBUG;
    curl_setopt_array($ch, array(
        CURLOPT_URL => $URL["QUERY_BASE"] . $deptCode,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_COOKIEFILE => $COOKIES_PATH,
    ));
    $response = curl_exec($ch);
    return $response;
}
function dump_curl($ch) {
    echo "*****************CURL DUMP****************" . "</br>";
    echo "<pre>";
    print_r(curl_getinfo($ch));
    echo "\n\ncURL error number:" .curl_errno($ch);
    echo "\n\ncURL error:" . curl_error($ch);
    echo "</pre><br/>";
    echo "*********************************************" . "</br>";
}

?>
