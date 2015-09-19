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
     // connect to database
     $handle = new PDO("mysql:dbname=course_ntnu;host=localhost;port=3306", USERNAME, PASSWORD);
     //$handle = new PDO("mysql:dbname=course_ntnu;host=localhost;unix_socket=".USOCKET.";port=3306", USERNAME, PASSWORD);
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

// 系所代碼表
$rows = query("SELECT * FROM Departments");
$DEPARTMENT_CODE_LIST = [];
foreach ($rows as $row)
{
  $DEPARTMENT_CODE_LIST[] = $row['DeptCode'];
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
/* This function collects course info from $start of $DEPARTMENT_CODE_LIST
 * with length $length.
 * It then returns an indexed array of each element an associative array
 * containing the courses info of that corresponding department.
 * Note that, unlike Python, PHP does not calling functions with named arguments,
 * e.g., get_data($length = 1) is the same as get_data(1). Also note that,
 * albeit the unsupported named arguement, PHP does support default arguements.
 */
function get_data($start = 0, $length = Null)
{
    $ch = curl_init();
    $id = get_id($ch);
    set_captcha($ch);
    $captcha = get_captcha($ch);
    login($ch, $captcha, $id);
    login2($ch);

    query_request($ch);
    course_query($ch, "");

    global $DEPARTMENT_CODE_LIST;
    $result = [];
    //print_r(array_slice($DEPARTMENT_CODE_LIST,$start,1));
    foreach (array_slice($DEPARTMENT_CODE_LIST,$start,$length) as $dept_code)
    {
      //Course query starts here
      $result[] = json_decode(course_query($ch, $dept_code), $assoc = True)['List'];
    }

    //end here
    curl_close($ch);

    return $result;
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
