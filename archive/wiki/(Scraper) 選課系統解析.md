# (Scraper) 選課系統解析

jaidTw edited this page 7 days ago · 2 revisions

## 概觀
由於新生保留名額，已分發人數等資料必須經由選課系統才能取得，若欲即時更新已分發人數資料，則必須設計出可以自動登入選課系統的Scrapper。

學校的**學生選課系統**共有5部主機可以使用，登入網址分別為：
```URL
http://cos1.ntnu.edu.tw/AasEnrollStudent/LoginCheckCtrl
http://cos2.ntnu.edu.tw/AasEnrollStudent/LoginCheckCtrl
http://cos3.ntnu.edu.tw/AasEnrollStudent/LoginCheckCtrl
http://cos4.ntnu.edu.tw/AasEnrollStudent/LoginCheckCtrl
http://cos5.ntnu.edu.tw/AasEnrollStudent/LoginCheckCtrl
```
而**在職專班暨EMBA學生選課系統**則有2部可以使用，登入網址為
```URL
http://cos4.ntnu.edu.tw/AasPEnrollStudent/LoginCheckCtrl
http://cos5.ntnu.edu.tw/AasPEnrollStudent/LoginCheckCtrl
```
由於cookies，所有進行的請求都必須在同一台主機上完成。
一般來說由登入至查詢課程的流程如下：

1. 在`LoginCheckCtrl`輸入學號、密碼、驗證碼後點擊`登入`按鈕。
2. 重新定向至`IndexCtrl`，點選`下一頁(開始選課)`按鈕。
3. 重新定向至`EnrollCtrl?action=go`。
4. 載入`StfseldListCtrl`，負責控制`我的選課`。
5. 點選`登記`，進入課程查詢功能，此時會送出請求`CourseQueryCtrl?action=query`。
6. 選擇系所後點選查詢，列出該系所之開課清單，此時會送出請求`CourseQueryCtrl?action=showGrid&deptCode=系所代碼`。

接下來就這幾個步驟進行解析。

##LoginCheckCtrl
登入時，會向`LoginCheckCtrl?action=login&id=xxxxxxxxxxxxx`送出POST Request。

其中`id`的部分為一由英數字組成，長度13~14之字串，於每次載入`LoginCheckCtrl`時生成，目前可直接由html原始碼中取出，位於第265行尾。

接著則是POST所需要的資料：

1. `userid` : 學號，**字母必須為大寫**(若使用登入系統前端會自動檢查並轉換)。
2. `password` : 密碼。
3. `validateCode` : 驗證碼。

很明顯地瓶頸在於驗證碼，不過RexYuan發現到了，點擊`無障礙輸入輔助`按鈕即可以獲得驗證碼之純文字形式。
分析後，此功能會向`ImageBoxFromIndexCtrl`送出請求，而該網址會根據`JSESSIONID`回傳包含驗證碼之JSON，如下：
```JSON
{success:true,msg:"xxxx"}
```
此處需要注意，若只使用cURL載入`LoginCheckCtrl`，接著請求`ImageBoxFromIndexCtrl`，會發現回傳之JSON的`msg`為空白，這是因為cURL只取得網頁內容，並不會執行Script，導致驗證碼實際上並沒有被生成。

解析連線資料後發現驗證碼由`RandImage`控制，每次向`RandImage`發送請求可以獲得隨機驗證碼之jpg圖片。
只要先請求`RandImage`後再請求`ImageBoxFromIndexCtrl`即可正常獲得資料，但其回傳與`RandImage`取得之圖片所顯示之驗證碼並不一致，測試後得知，使用`ImageBoxFromIndexCtrl`回傳之文字資料即可登入系統。

因此，登入系統階段之必須流程如下：

1. 請求`http://cos1.ntnu.edu.tw/AasEnrollStudent/LoginCheckCtrl`，解析出`id`。
2. 請求`http://cos1.ntnu.edu.tw/AasEnrollStudent/RandImage`，產生驗證碼。
3. 請求`http://cos1.ntnu.edu.tw/AasEnrollStudent/ImageBoxFromIndexCtrl`解析出驗證碼。
4. 向`http://cos1.ntnu.edu.tw/AasEnrollStudent/LoginCheckCtrl?action=login&id=ID`發出POST請求以登入系統。

##IndexCtrl
成功登入系統後，會被重新定向至本頁面。
原以為這樣就登入成功了，但向`EnrollCtrl`、`StfseldListCtrl`、`CourseQueryCtrl`發送請求仍然是回應不合法執行選課系統，
代表點擊`下一頁(開始選課)`按鈕時絕對還有其他的動作。

經過逐步測試，點擊按鈕後，在被重新定向至`EnrollCtrl?action=go`之前實際上還送出了一個POST Request，對象是`LoginCtrl`。

POST包含了以下資料：

1. `userid`　：　學號，一樣必須是**大寫**。
2. `stdName` ： 學生姓名，經測試後此項資料可以不送。

模擬發送後，就可以正常的載入`EnrollCtrl`和`StfseldListCtrl`等頁面了。

因此，本階段只需要向`http://cos1.ntnu.edu.tw/AasEnrollStudent/LoginCtrl`發送POST Request。
而測試後發現不請求接下來的`EnrollCtrl`和`StfseldListCtrl`也可以獲得資料，故此處不做說明，直接跳至`CourseQueryCtrl`部分。

##CourseQueryCtrl
在發送查詢課程請求(`CourseQueryCtrl?action=showGrid&deptCode=系所代碼`)前，必須滿足兩個條件：

1. 必須登入系統，也就是檢查`JSESSIONID`必須已經登入，沒有登入會提示不合法執行選課系統。
2. 請求過`CourseQueryCtrl?action=query`，沒有請求過會提示Error 500 : Internal Server Error。

另外，查詢課程請求必須從第二次開始才能正常獲得資料，第一次會是空白，目前原因不明。
因此，本階段需先發送兩個請求

1. 請求`http://cos1.ntnu.edu.tw/AasEnrollStudent/CourseQueryCtrl?action=query`
2. 請求`http://cos1.ntnu.edu.tw/AasEnrollStudent/CourseQueryCtrl?action=showGrid&deptCode=`

其中第二個請求，因為第一次查詢無法正常獲得資料，故deptCode留空也沒關係。

##總結

總結查詢課程前需要的請求總共有7個，其中兩個為POST，剩餘為GET：

1. 請求`http://cos1.ntnu.edu.tw/AasEnrollStudent/LoginCheckCtrl`，解析出`id`。
2. 請求`http://cos1.ntnu.edu.tw/AasEnrollStudent/RandImage`，產生驗證碼。
3. 請求`http://cos1.ntnu.edu.tw/AasEnrollStudent/ImageBoxFromIndexCtrl`解析出驗證碼。
4. 向`http://cos1.ntnu.edu.tw/AasEnrollStudent/LoginCheckCtrl?action=login&id=ID`發出POST Request以登入系統。
5. 向`http://cos1.ntnu.edu.tw/AasEnrollStudent/LoginCtrl`發送POST Request以登入系統。
6. 請求`http://cos1.ntnu.edu.tw/AasEnrollStudent/CourseQueryCtrl?action=query`
7. 請求`http://cos1.ntnu.edu.tw/AasEnrollStudent/CourseQueryCtrl?action=showGrid&deptCode=`

接下來以`CourseQueryCtrl?action=showGrid&deptCode=系所代碼`之格式請求即可獲得課程JSON資料。

##附錄
[PHP使用cURL之實作參考](https://gist.github.com/jaidTw/0f65496b054f35ccf12f)