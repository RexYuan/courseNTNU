# (Scraper) 刮系所指南

RexYuan edited this page on Sep 19 · 3 revisions

## Request Analysis
經由觀察可分析出以下系所的 query 網址：

```URL
http://courseap.itc.ntnu.edu.tw/acadmOpenCourse/CofnameCtrl?type=chn&year=104&term=1&_dc=1439022729278&page=1&start=0&limit=25
```

解析過後的檔案可參考 [104-1 的所有系所與代碼整理後的對照表](https://gist.github.com/RexYuan/b059800c6e44b074e9f6#file-104-1_dept-md)。

原始資料其中參數意義如下：
* `type` : 返回查詢結果之語言，`chn`為中文，`eng`為英文。
* `year` : 查詢之學年。
* `term` : 查詢之學期，`1`為上學期，`2`為下學期，`3`為暑期班。

以下參數經數種數值測試後未見結果改變，
* `_dc`  : Ext.js之disableCaching功能自動加上之參數，值為POSIX TIME(ms)，可不加。
* `page` : 頁數?可不加。
* `start` : 開始?可不加。
* `limit` : 限制？可不加。

## Response Parsing
其返回之資料形式如下
```
[['系所代碼','系所代碼 開課單位名稱'],['系所代碼','系所代碼 開課單位名稱'],...]
```
推測為JavaScript之Array字串輸出，因使用PHP處理，故目前需手動處理字串以解析，實作如下：
```php
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
```
處理後將會輸出格式如下之Associative Array：
```php
Array
(
    [系所代碼] =>   開課單位名稱
    [系所代碼] =>   開課單位名稱
    ...
)
```