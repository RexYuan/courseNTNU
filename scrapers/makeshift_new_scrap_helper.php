<?php
  require("../functions.php");

  $DEPARTMENT_CODE_LIST = [
    'GU'  => '通識',
    'EU00' => '教育系',
    'EU01' => '心輔系',
    'EU02' => '社教系',
    'EU05' => '衛教系',
    'EU06' => '人發系',
    'EU07' => '公領系',
    'EU09' => '特教系',
    'LU20' => '國文系',
    'LU21' => '英語系',
    'LU22' => '歷史系',
    'LU23' => '地理系',
    'LU26' => '臺文系',
    'SU40' => '數學系',
    'SU41' => '物理系',
    'SU42' => '化學系',
    'SU43' => '生科系',
    'SU44' => '地科系',
    'SU47' => '資工系',
    'TU60' => '美術系',
    'TU68' => '設計系',
    'HU70' => '工教系',
    'HU71' => '科技系',
    'HU72' => '圖傳系',
    'HU73' => '機電系',
    'HU75' => '電機系',
    'AU30' => '體育系',
    'AU32' => '競技系',
    'IU83' => '東亞系',
    'IU85' => '應華系',
    'MU90' => '音樂系',
    'OU57' => '企管系',
  ];

  $URL_GET_BASE = 'http://courseap.itc.ntnu.edu.tw/acadmOpenCourse/CofopdlCtrl?';

  $URL_GET_LIST = [
    '_dc'          => '',
    'acadmYear'    => '104',
    'acadmTerm'    => '1',
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
 ?>
