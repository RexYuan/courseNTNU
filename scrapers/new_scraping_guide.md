# New Scraping Guide
根據在教務資訊系統中開課查詢的資料，一個系所在某學期開設的資料可藉由對某 URL 做出 GET Request 便能取得以 JSON 形式回傳的資料。一個範例是在 104 學年第 1 學期的資工系，我們可以從以下 URL 得到該學期所通識課程的部分相關資料：

```URL
http://courseap.itc.ntnu.edu.tw/acadmOpenCourse/CofopdlCtrl?_dc=1439021294652&acadmYear=104&acadmTerm=1&chn=&engTeach=N&moocs=N&remoteCourse=N&deptCode=SU47&classCode=&generalCore=&teacher=&language=chinese&action=showGrid&start=0&limit=99999&page=1
```

一小段回傳資料的範例如下：

```JSON
{"acadm_term":"1","acadm_year":"104","authorize_p":"20","authorize_r":"0.40","authorize_using":"-51","cancel":"","chn_name":"線性代數","class_name":"","classes":"","comment":"","counter":"0","counter_exceptAuth":"51","course_avg":"","course_code":"CSU0016","course_group":"","course_kind":"半","credit":"3.0","deleteQ":"","dept_chiabbr":"資工系","dept_code":"SU47","dept_group":"","dept_group_name":"","eng_name":"Linear Algebra","eng_teach":"","exp_hours":"","fillcounter":"","for_query":"","form_s":"2","form_s_name":"二","full_flag":"","gender_restrict":"","hours":"","iCounter":"","limit":"3","limit_count_h":"50","moocs_teach":"","not_choose":"","option_code":"必","percentage":"","restrict":"","rt":"N","school_avg":"","selfTeach":"","selfTeachName":"","send_time":"","serial_no":"3033","status":"","tcode":"","teacher":"陳柏琳","time_inf":"一 2 公館 Ｓ501,五 3-4 公館 Ｓ501,","tname":"","week_section1":"","week_section2":"","week_section3":"","week_section4":""}
```

## 解析 URL
注意到整理過後的範例 URL：

```URL
http://courseap.itc.ntnu.edu.tw/acadmOpenCourse/CofopdlCtrl?
  _dc=1439021294652&
  acadmYear=104&
  acadmTerm=1&
  chn=&
  engTeach=N&
  moocs=N&
  remoteCourse=N&
  deptCode=SU47&
  classCode=&
  generalCore=&
  teacher=&
  language=chinese&
  action=showGrid&
  start=0&
  limit=99999&
  page=1
```

解讀 GET Request 變數意義：

1. `_dc`：Ext JS 讓 GET Request 避免 cache 的參數，為一以毫秒為單位的 UNIX POSIX Time，*使用時不應加上此變數，讓伺服器自行處理*
2. `acadmYear`：學年，以 2015 年秋季（上學期）來說，就是 `104`
3. `acadmTerm`：學期，秋季課程（上學期）為 `1`，春季課程（下學期）為 `2`
4. `chn`：過濾中文課程名稱，*如要得到全部資料應留空*
5. `engTeach`：過濾是否為全英語授課課程，其值為 `Y` 或是 `N`，*如要得到全部資料應輸入 `N`*
6. `moocs`：過濾是否為 MOOCS 課程，其值為 `Y` 或是 `N`，*如要得到全部資料應輸入 `N`*
7. `remoteCourse`：過濾是否為遠距教學課程，其值為 `Y` 或是 `N`，*如要得到全部資料應輸入 `N`*
8. `deptCode`：系所代碼，表示系所
9. `classCode`：過濾開課班級，其可能值為 `1`（甲班）、`2`（乙班）、`3`（丙班）、`4`（丁班）、`7`（大碩博合開）、`8`（碩博合開）或 `9`（大碩合開），*如要得到全部資料應留空*
10. `generalCore`：過濾通識核心領域， `1`（藝術與美感）、`2`（哲學思維與道德推理）、`3`（公民素養與社會探究）、`4`（歷史與文化）、`5`（數學與科學思維）、`6`（科學與生命）、`7`（一般通識）或 `8`（所有通識），*如要得到全部資料應留空或是輸入 `8`*
11. `teacher`：搜尋教師有關，只要教師名稱含有其值便會被搜尋到
12. `language`：語言，中文為 `chinese`
13. `action`：**未知**，為正常運作應輸入 `showGrid`
14. `start`：課程起始值，為正常運作應輸入 `0`
15. `limit`：要求課程數量，為正常運作應輸入 `99999`
16. `page`：頁數，為正常運作應輸入 `1`

目前部份的 GET Request 變數意義還*未知*，但注意到只需要操控 `acadmYear`、`acadmTerm` 和 `deptCode` 就能夠切換學年、學期和系所，因此得到大部份的資料。

### `deptCode`
可以從這個 URL 得到在本學期所有可能的系所代碼：

```URL
http://courseap.itc.ntnu.edu.tw/acadmOpenCourse/CofnameCtrl?type=chn&year=104&term=1&_dc=1439022729278&page=1&start=0&limit=25
```

同時注意到他的 GET Request 變數除了 `type`，都包含在剛剛提到的列表內， `type` 代表的是回傳資料的語言，可能值為 `chn`（中文）或 `eng`（英文）。[依照這學期的資料，所有可能的系所代碼（`deptCode`）整理過後的列表](https://github.com/RexYuan/courseNTNU/wiki/Guide-deptCode-List)。

// 考慮department table是否涵括所有deptCode?

## 解析 JSON

從 GET Request 得到的回傳資料會是以 JSON 為結構送出。[這學期資工系課程，整理過後的 JSON 範例](https://github.com/RexYuan/courseNTNU/wiki/Guide-JSON-Example)。
考慮包含開頭一小段的擷取：

```JSON
{
  "Count":25,
  "List":
  [
    {
      "acadm_term":"1",
      "acadm_year":"104",
      "authorize_p":"20",
      "authorize_r":"0.40",
      "authorize_using":"0",
      "cancel":"",
      "chn_name":"資料探勘",
      "class_name":"大碩",
      "classes":"9",
      "comment":"",
      "counter":"0",
      "counter_exceptAuth":"0",
      "course_avg":"",
      "course_code":"CSC0001",
      "course_group":"",
      "course_kind":"半",
      "credit":"3.0",
      "deleteQ":"",
      "dept_chiabbr":"資工系",
      "dept_code":"SU47",
      "dept_group":"",
      "dept_group_name":"",
      "eng_name":"Data Mining",
      "eng_teach":"",
      "exp_hours":"",
      "fillcounter":"",
      "for_query":"",
      "form_s":"",
      "form_s_name":"",
      "full_flag":"",
      "gender_restrict":"",
      "hours":"",
      "iCounter":"",
      "limit":"3",
      "limit_count_h":"50",
      "moocs_teach":"",
      "not_choose":"",
      "option_code":"選",
      "percentage":"",
      "restrict":"◎限大三大四 ◎限碩一碩二碩三以上修習",
      "rt":"N",
      "school_avg":"",
      "selfTeach":"",
      "selfTeachName":"",
      "send_time":"",
      "serial_no":"3280",
      "status":"",
      "tcode":"",
      "teacher":"柯佳伶",
      "time_inf":"一 2-4 公館 Ｂ101,",
      "tname":"",
      "week_section1":"",
      "week_section2":"",
      "week_section3":"",
      "week_section4":""
    },
    ...
  ]
}
```

其中馬上可以發現到回傳值 JSON 包含兩個值。顯而易見地，`Count` 代表課程數目，而 `List` 則包含所有課程的資訊。
解讀在 `List`，每個課程裡中 JSON Key 的意義：

1. `acadmTerm`：學期，秋季課程（上學期）為 `1`，春季課程（下學期）為 `2`
2. `acadmYear`：學年，以 2015 年秋季（上學期）來說，就是 `104`
3. `authorize_p`：**未知**
4. `authorize_r`：**未知**
5. `authorize_using`：**未知**
6. `cancel`：**未知**
7. `chn_name`：課程中文名稱
8. `class_name`：大碩合開，若是，該值為 `大碩`
9. `classes`：**未知**
10. `comment`：註解，目的不一定。如共同科國文科的註解會解釋該堂是為哪幾個系開設的
11. `counter`：**未知**
12. `counter_exceptAuth`：**未知**
13. `course_avg`：**未知**
14. `course_code`：課程代碼
15. `course_group`：課程組，如果一堂課如因有多位教師或時段，有多個選擇，便會以英文字母區隔。如物理教學實習（一）有兩堂課，分別在 `course_group` 為 `A` 與 `B`；而普通物理實驗則有 `A` - `G` 組
16. `course_kind`：全／半年，課程長度，通常是半學年，該值為 `半`
17. `credit`：學分數，值為帶一位小數的數字，如 `3.0`
18. `deleteQ`：**未知**
19. `dept_chiabbr`：系所中文名稱
20. `dept_code`：系所代碼
21. `dept_group`：系所組別，通常當系所有分組，而當某堂課是開設給某個特定組別時，便會以英文字母區隔。如基礎素描（一）是西畫組，該值為 `B`；膠彩畫材料運用是國畫組，該值為 `A`
22. `dept_group_name`：系所組別中文名稱，通常當系所有分組，而當某堂課是開設給某個特定組別時，便會以英文字母區隔。如基礎素描（一）是西畫組，該值為 `西畫組`；膠彩畫材料運用是國畫組，該值為 `國畫組`
23. `eng_name`：課程英文名稱
24. `eng_teach`：全英語授課。如語言學概論（一），該值為 `是`。
25. `exp_hours`:**未知**，猜測為未使用的預計每週花費小時
26. `fillcounter`：**未知**
27. `for_query`：**未知**
28. `form_s`：開課年級，為一數字。若為一年級，該值為 `1`
29. `form_s_name`:開課年級中文名稱，為中文字。若為一年級，該值為 `一`
30. `full_flag`：**未知**
31. `gender_restrict`：性別限制，男生為 `M`，女生為 `F`。如田徑（一）有兩堂，該值分別為 `F` 或是 `M`
32. `hours`：**未知**
33. `iCounter`：**未知**
34. `limit`：**未知**
35. `limit_count_h`：**未知**
36. `moocs_teach`：**未知**，猜測為未使用的 MOOC 課程
37. `not_choose`：**未知**
38. `option_code`：必／選修，必修或是選修，必修為 `必`，選修為 `選`
39. `percentage`：**未知**
40. `restrict`：限制，為一串中文字
41. `rt`：**未知**
42. `school_avg`：**未知**
43. `selfTeach`：**未知**，猜測為未使用的自學課程
44. `selfTeachName`：**未知**，猜測為未使用的自學課程
45. `send_time`：**未知**
46. `serial_no`：開課序號，方便選課系統快速查詢
47. `status`：**未知**
48. `tcode`：**未知**
49. `teacher`：教師
50. `time_inf`：時間與開課地點，如 `一 2-4 公館 Ｂ101,`
51. `tname`：**未知**
52. `week_section1`：**未知**
53. `week_section2`：**未知**
54. `week_section3`：**未知**
55. `week_section4`：**未知**

// 考慮course table是否涵括所有資料以及和deparment table的關係
