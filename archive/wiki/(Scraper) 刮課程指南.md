# (Scraper) 刮課程指南

RexYuan edited this page on Sep 19 · 2 revisions

## Request Analysis
根據分析，我們可以藉由 GET Request 取得各系所開課之 JSON 資料。
下面以資工系 104 學年第 1 學期為例，我們可以從以下 URL query 該學期所開課程的部分相關資料：

```URL
http://courseap.itc.ntnu.edu.tw/acadmOpenCourse/CofopdlCtrl?_dc=1439021294652&acadmYear=104&acadmTerm=1&chn=&engTeach=N&moocs=N&remoteCourse=N&deptCode=SU47&classCode=&generalCore=&teacher=&language=chinese&action=showGrid&start=0&limit=99999&page=1
```
其中各參數意義分析如下：

編號 | 變數名稱 | 解讀
--- | ------- | ----
1. | `_dc` | Ext.JS 的disableCaching功能，值為POSIX Time (ms)，*可不加。*
2. | `acadmYear` | 學年，以 2015 年秋季（上學期）來說，就是 `104`。
3. | `acadmTerm` | 學期，秋季課程（上學期）為 `1`，春季課程（下學期）為 `2`，暑期課程為`3`。
4. | `chn` | 篩選中文課程名稱，*如要得到全部資料應留空。*
5. | `engTeach` | 是否篩選全英語授課課程，其值為 `Y` 或是 `N`，*如要得到全部資料應輸入 `N`或不填。*
6. | `moocs` | 是否篩選 MOOCS 課程，其值為 `Y` 或是 `N`，*如要得到全部資料應輸入 `N`或不填。*
7. | `remoteCourse` | 是否篩選遠距教學課程，其值為 `Y` 或是 `N`，*如要得到全部資料應輸入 `N`或不填。*
8. | `deptCode` | 系所代碼，表示系所，可見Department Scraping Guide
9. | `classCode` | 過濾開課班級，其可能值為 `1`（甲班）、`2`（乙班）、`3`（丙班）、`4`（丁班）、`7`（大碩博合開）、`8`（碩博合開）或 `9`（大碩合開），*如要得到全部資料應留空。*
10. | `generalCore` | 過濾通識核心領域， `1`（藝術與美感）、`2`（哲學思維與道德推理）、`3`（公民素養與社會探究）、`4`（歷史與文化）、`5`（數學與科學思維）、`6`（科學與生命）、`7`（一般通識）或 `8`（所有通識），*如要得到全部資料應留空或是輸入 `8`。*
11. | `teacher` | 搜尋教師有關，只要教師名稱含有其值便會被搜尋到。
12. | `language` | 語言，中文為 `chinese`，英文為`english`。
13. | `action` | 無其他用途，應輸入 `showGrid`
14. | `start` | 課程起始值，為正常運作應輸入 `0`或不填。
15. | `limit` | 要求課程數量，為正常運作應輸入 `99999`或不填。
16. | `page` | 頁數，為正常運作應輸入 `1`或不填。

只需加上 `acadmYear`、`acadmTerm` 和 `deptCode` 就能切換學年、學期和系所而得到資料。

## Response Parsing

從 GET Request 得到的回傳資料會是以 JSON 為結構送出。[104-1資工系課程，整理過後的 JSON 範例](https://gist.github.com/RexYuan/b059800c6e44b074e9f6#file-104-1_cs-json)。
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

編號 | 變數名稱 | 解讀
--- | ------- | ----
1. | `acadmTerm` | 學期，秋季課程（上學期）為 `1`，春季課程（下學期）為 `2`，。
2. | `acadmYear` | 學年，以 2015 年秋季（上學期）來說，就是 `104`。
3. | `authorize_p` | 授權碼名額。
4. | `authorize_r` | **未確定**，允許授權碼比例。
5. | `authorize_using` | **未確定**，授權碼選課人數(可能包含預選)。
6. | `cancel` | **未知。**
7. | `chn_name` | 課程中文名稱。
8. | `class_name` | 開課班級名稱，如`大碩`。
9. | `classes` | 開課班級代碼，如`大碩`對應於`9`。
10.|  `comment` | 註解，目的不一定。如共同科國文科的註解會解釋該堂是為哪幾個系開設的。
11. | `counter` | **已廢除**，選課人數(含授權碼)
12. | `counter_exceptAuth` | 選課總人數。
13. | `course_avg` | **未知。**
14. | `course_code` | 課程代碼。
15. | `course_group` | 課程組，如果一堂課如因有多位教師或時段，有多個選擇，便會以英文字母區隔。如物理教學實習（一）有兩堂課，分別在 `course_group` 為 `A` 與 `B`；而普通物理實驗則有 `A` - `G` 組。
16. | `course_kind` | 全／半年，課程長度，通常是半學年，該值為 `半`。
17. | `credit` | 學分數，值為帶一位小數的數字，如 `3.0`。
18. | `deleteQ` | **未知**。
19. | `dept_chiabbr` | 系所中文名稱。
20. | `dept_code` | 系所代碼。
21. | `dept_group` | 系所組別，通常當系所有分組，而當某堂課是開設給某個特定組別時，便會以英文字母區隔。如基礎素描（一）是西畫組，該值為 `B`；膠彩畫材料運用是國畫組，該值為 `A`。
22. | `dept_group_name` | 系所組別中文名稱，通常當系所有分組，而當某堂課是開設給某個特定組別時，便會以英文字母區隔。如基礎素描（一）是西畫組，該值為 `西畫組`；膠彩畫材料運用是國畫組，該值為 `國畫組`。
23. | `eng_name` | 課程英文名稱。
24. | `eng_teach` | 全英語授課。如語言學概論（一），該值為 `是`。
25. | `exp_hours` | **未知**，猜測為未使用的預計每週花費小時。
26. | `fillcounter` | **未知**。
27. | `for_query` | **未知**。
28. | `form_s` | 開課年級，為一數字。若為一年級，該值為 `1`。
29. | `form_s_name` | 開課年級中文名稱，為中文字。若為一年級，該值為 `一`。
30. | `full_flag` | **未確定**，課程已滿與否。
31. | `gender_restrict` | 性別限制，男生為 `M`，女生為 `F`。如田徑（一）有兩堂，該值分別為 `F` 或是 `M`。
32. | `hours` | **未知**。
33. | `iCounter` | **未知**。
34. | `limit` | 聯盟(各校)跨校選課人數。
35. | `limit_count_h` | 限修人數。
36. | `moocs_teach` | MOOCS。
37. | `not_choose` | **未知**。
38. | `option_code` | 必／選修，必修或是選修，必修為 `必`，選修為 `選`。
39. | `percentage` | **未知。**
40. | `restrict` | 擋修限制。
41. | `rt` | 遠距教學。
42. | `school_avg` | **未知**
43. | `selfTeach` | **未知**，猜測和`selfTeachName`有關。
44. | `selfTeachName` | 正課/實驗親授？
45. | `send_time` | **未知**
46. | `serial_no` | 開課序號，方便選課系統快速查詢。
47. | `status` | 停開。
48. | `tcode` | **未知。**
49. | `teacher` | 教師姓名。
50. | `time_inf` | 時間與開課地點，如 `一 2-4 公館 Ｂ101,`。
51. | `tname` | 教師英文姓名（僅在英文版系統出現）。
52. | `week_section1` | **未知。**
53. | `week_section2` | **未知。**
54. | `week_section3` | **未知。**
55. | `week_section4` | **未知。**