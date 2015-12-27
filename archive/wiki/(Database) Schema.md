# (Database) Schema

RexYuan edited this page on Aug 23 · 13 revisions

# Info
* [w3schools SQL tutorial](http://www.w3schools.com/sql/default.asp)
* [SQL Dump](https://gist.github.com/RexYuan/b4fa7394503cb96f6efe)

# Schema

## TABLE Departments
儲存所有系所資訊

| 名稱     | 型別       | 意義         | 範例 | 備註
| -------- | ---------- | ------------ | --------------------------------------------------------------------------------------|-------
| DeptId   | u_INT      | PRIMARY KEY  | 1,53,4523
| Abbr     | CHAR(3)    | 開課代碼前綴 | HED（衛教博）,EDC（教育大碩）,PCM（心輔碩）,CSU（資工系）,02U（其中一種通識）|
| DeptCode | CHAR(4)    | 系所代碼 	   | 9UAA（校際學士班（臺大））,SU47（資工系）,E（教育學院）,CU（共同科）
| ChName   | NVARCHAR() | 系所中文名稱 | 資工系,教育輔,理學院,生物多樣學位學程
| EnName   | VARCHAR()  | 系所英文名稱 | Department of Computer Science and Information Engineering (Undergraduate)

## TABLE Courses
儲存所有課程資訊

| 名稱           	   | 對應原欄位          | 型別       | 意義             | 範例                     | 備註
| ------------------ | ------------------- | ---------- | ---------------- | ------------------------ | --------
| CourseId      	   | course_id           | u_INT      | ID               | 1,32,793                 | PRIMARY
| SerialNo      	   | serial_no           | u_SMALLINT | 開課序號         | 3025                     |
| CourseCode         | course_code         | CHAR(7)    | 開課代碼         | CSU0001                  |
| AcadmYear      	   | acadmYear           | u_TINYINT  | 學年             | 104                      |
| AcadmTerm      	   | acadmTerm           | u_TINYINT  | 學期             | 1                        |
| ChName       	   | chn_name            | NVARCHAR() | 課程中文名稱     | 程式設計（一）             |
| EnName       	   | eng_name            | VARCHAR()  | 課程英文名稱     | Computer Programming (I) |
| TeacherId 	   | N/A                 | u_INT      | 教師             | 1,245,63                 | 可能有多名老師教授同一堂課。
| CourseGroup   	   | course_group        | CHAR(1)    | 組別             |                          |
| ClassCode      	   | classes             | CHAR(1)    | 開課班級代碼     |                          | 見Scraper Guide之classCode
| Duration    	   | course_kind         | CHAR(1)    | 全/半學期        | H                        | 值為H/F
| Credit         	   | credit              | FLOAT()    | 學分數           | 3.0                      | 是否有小數之學分數？
| DeptId      	   | N/A           | u_INT    | 開課系所識別碼     | 1,23                     |
| DeptGroup     	   | dept_group          | CHAR()     | 開課組別         |                          |
| IsEngTeach         | eng_teach           | BOOL       | 全英語授課       | F                        |
| Grade         	   | form_s              | CHAR(1)    | 開課年級         | 1                        |
| GenderRestrict	   | gender_restrict     | CHAR(1)    | 性別限制         | N                        | 值為N/M/F
| IsMOOC    	   | moocs_teach         | BOOL       | MOOCs            | F                        |
| IsElective    	   | option_code         | CHAR(1)    | 必/選修          | R                        | 值為R/S
| RestrictInfo           | restrict            | NVARCHAR() | 擋修條件         |                          | 是否有英文?
| RemoteTeach        | rt                  | BOOL       | 遠距授課         | F                        |
|*selfTeachName      | selfTeachName       | NVARCHAR() | 正課/實驗親授    |                          | 未見使用
| ChLocation         | split from time_inf | NVARCHAR() | 中文上課地點     | 公館 理圖807          	| 若建立教室表，可改用Id
| EnLocation         | split from time_inf | VARCHAR()  | 英文上課地點     |                          | 同上
| TimeInfo               | split from time_inf | VARCHAR()  | 上課時間         | 三 8-9, 五 7             | parse日期以及節次
|*StatusInfo             | status              | BOOL       | 是否停開         | F                        |
| ChComment      	   | comment             | NVARCHAR() | 中文註解         |                          |
| EnComment    	   |                     | VARCHAR()  | 英文註解         |                          |
| ~~CourseSize~~         | counter_exceptAuth  | u_TINYINT  | 修課總人數       | 52                       |
| AuthMaxSize        | authorize_p         | u_TINYINT  | 授權碼名額       | 20                       | 尚需觀察，暫無法確定是否更新
| AuthRate    	   | authorize_r         | FLOAT()    | 授權碼比例       | 0.40                     |
| ~~AuthUsed~~	         | authorize_using     | TINYINT    | 授權碼使用人數   | -52                      | 懷疑與預選有關，暫無法解讀
| NTAMaxSize         | limit               | u_TINYINT  | 台大聯盟限修人數 | 0                        | NTA = NTU Triangle Alliance
| TotalMaxSize       | limit_count_h       | u_TINYINT  | 限修人數         | 50                       |
| Hour               | 每週授課時數		 | u_TINYINT  | 每週授課時數     | 2     				|
| Description	   | 課程簡介 		 | TEXT       | 課程簡介         |             			|
| FreshReserve       | v_reserve_count     | u_TINYINT  | 新生保留人數     | 0                        | ***須從選課系統抓取
| ~~Distributed~~        | v_stfseld_deal      | u_TINYINT  | 已分發人數       | 0                        | ***須從選課系統抓取

## TABLE Teachers
儲存教師資料，目前只能手動輸入

| 名稱        | 對應原欄位   | 型別         | 意義         | 範例                      | 備註                                    |
| ----------- | ------------ | ------------ | ------------ | ------------------------- | --------------------------------------- |
| TeacherId   | N/A          | u_INT        | 識別碼       | 34,124,21,4               | PRIMARY				         |
| DeptId      | N/A          | u_INT        | 隸屬系所代碼 | 2,34,124,3                | FOREIGN Departments(DeptId), ALLOW NULL |
| ChName      | teacher      | VARCHAR(255) | 中文名字     | 蔣宗哲                    | CHARSET utf8, ALLOW NULL                |  
| EnName      | tname        | VARCHAR(255) | 英文名字     | CHIANG, Tsung-Che         | ALLOW NULL 同上   			         |
| Description | N/A          | TEXT         | 簡短描述     |                           | ALLOW NULL					   |

## TABLE CourseRecords
以課程代碼查詢同堂課各學期開課記錄用，映射至course之PRIMARY KEY集合。

| 名稱        | 型別    | 意義     | 範例     |備註
| ----------- | ------- | -------- | -------- |-----
| CourseRecordId    | INT     | Id       | 1
| CourseCode  | CHAR(7) | 課程代碼 | CSU0001
| CourseRecord      | TEXT    | 開課紀錄 | 1

## TABLE DepartmentRecords
以系所查詢該系所當學期開課情況

| 名稱          | 型別    | 意義     | 範例     | 備註 |
| ------------ | ------- | ------- | ------- | ---- |
| DeptRecordId |         |         |         |      |
| DeptId       |         |         |         |      |
| DeptCourseNameRecord   |         |         |         |      |
| DeptCourseCodeRecord   |         |         |         |      |

## TABLE Users
儲存用戶資料，來源目前只有 Facebook

| 名稱      | 型別          | 意義      | 範例                      |                                      | 備註                     |
| -------- | ------------ | --------- | ------------------------- | ------------------------------------- | ---- |
| UserId   | u_INT        | 識別碼     | 1,234,14315               | PRIMARY, NOT NULL, AUTO_INCREMENT      | |
| FBId     | u_BIGINT     | FB.id     | 10203739867764562         | UNIQUE, NOT NULL                      | |
| Name     | VARCHAR(255) | FB.name   | Chih-cheng Yuan           | CHARSET utf8, NOT NULL                | |
| Gender   | VARCHAR(255) | FB.gender | male,female               | NOT NULL                              | |
| Locale   | VARCHAR(255) | FB.locale | en_US,zh_TW               | NOT NULL                              | |

## TABLE Votes
投票資料，一份投票會對應至投票者和投票課程

| 名稱     | 型別      | 意義                | 範例                | 備註                                                                 |
| -------- | --------- | ------------------- | ------------------- | -------------------------------------------------------------------- |
| VoteId   | u_INT     | 識別碼              | 12,246,2462         | PRIMARY, NOT NULL, AUTO_INCREMENT                                    |
| CourseId | u_INT     | 對應至 TABLE course | 34,982,1345         | FOREIGN Courses(CourseId), INDEX, UNIQUE(CourseId, UserId), NOT NULL |
| UserId   | u_INT     | 對應至 TABLE user   | 56,810,2030         | FOREIGN Users(UserId), INDEX, UNIQUE(CourseId, UserId), NOT NULL     |
| Decision | BOOL      | 推或不推            | 0(推),1(不推)       | NOT NULL                                                             |
| VoteTime | TIMESTAMP | 時間戳記            | 1970-01-01 00:00:01 | DEFAULT CURRENT_TIMESTAMP ON UPDAT CURRENT_TIMESTAMP, NOT NULL       |

## TABLE Leaderboards