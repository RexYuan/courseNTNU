<?php

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
        $result = [];
        // check if there's more than one time
        $sub_strs = array_slice(explode(",", $str), 0, $length = -1);
        // parse every time
        foreach ($sub_strs as $sub_str)
        {

            list($day, $time, $campus, $location) = explode(" ", $sub_str);
            $result[] = [$day, $time, $campus, $location];
        }
        // return an array of arrays of info
        return $result;
    }
    else
    {
        return NULL;
    }
}

//Use to parse the department code and name mapping
function parse_dept_code($dept_str) {
    $dept_str = substr($dept_str, 1, strlen($dept_str) - 2);
    $tok = strtok($dept_str , "]");

    while($tok !== false) {
        $tok = substr($tok, strpos($tok, "[") + 1);
        sscanf($tok, "'%*[^']','%[^ ]%[^'']'", $code, $name);
        $dept_list[$code] = $name;
        $tok = strtok("]");
    }
  
    return $dept_list;
}
?>
