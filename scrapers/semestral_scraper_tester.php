<?php
// Testing output
echo '$SerialNo = ';var_dump($SerialNo);
echo '$CourseGroup = ';var_dump($CourseGroup);
echo '$EnLocation = ';var_dump($EnLocation);
echo '$IsMOOC = ';var_dump($IsMOOC);
echo '$Grade = ';var_dump($Grade);
echo <<<HEREDOC
開課序號       SerialNo       = $SerialNo
課程代碼       CourseCode     = $CourseCode
學年          AcadmYear      = $AcadmYear
學期          AcadmTerm      = $AcadmTerm
課程中文名稱    ChName         = $ChName
課程英文名稱    EnName         = $EnName
組別          CourseGroup    = $CourseGroup
開課班級代碼    ClassCode      = $ClassCode
學分數         Credit         = $Credit
開課組別       DeptGroup      = $DeptGroup
開課年級       Grade          = $Grade
限制           RestrictInfo   = $RestrictInfo
正課實驗親授    selfTeachName  = $selfTeachName
英文上課地點    EnLocation     = $EnLocation
是否停開       StatusInfo     = $StatusInfo
中文註解       ChComment      = $ChComment
英文註解       EnComment      = $EnComment
修課總人數      CourseSize     = $CourseSize
授權碼名額      AuthMaxSize    = $AuthMaxSize
授權碼比例      AuthRate       = $AuthRate
授權碼使用人數   AuthUsed       = $AuthUsed
台大聯盟限修人數 NTAMaxSize     = $NTAMaxSize
限修人數        TotalMaxSize   = $TotalMaxSize
全/半學期       Duration       = $Duration
全英語授課      IsEngTeach     = $IsEngTeach
性別限制        GenderRestrict = $GenderRestrict
MOOCs         IsMOOC         = $IsMOOC
必／選修       IsElective      = $IsElective
遠距授課        RemoteTeach    = $RemoteTeach
開課系所識別碼   DeptId         = $DeptId
教師           TeacherId      = $TeacherId
中文上課地點    ChLocation     = $ChLocation
上課時間        TimeInfo      = $TimeInfo
上課時數       Hour           = $Hour
課程簡介       Description    = $Description
====================================================

HEREDOC;
?>
