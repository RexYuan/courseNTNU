<?php
// Testing output
echo '$SerialNo = ';var_dump($course['serialNo']);
echo 'FmReserve = ';var_dump($FmReserve);
echo 'Assigned  = ';var_dump($Assigned);
$a = $course['serialNo'];$b = $course['courseCode'];$c = $course['acadmYear'];
$d = $course['acadmTerm'];$e = $course['chnName'];
echo <<<HEREDOC
課程識別碼     CourseId       = $CourseId
開課序號       SerialNo       = $a
課程代碼       CourseCode     = $b
學年          AcadmYear      = $c
學期          AcadmTerm      = $d
課程中文名稱    ChName        = $e
----------------------------------------------------
保留新生人數    FmReserve     = $FmReserve
選課人數       Enrolled      = $Enrolled
已分發人數     Assigned      = $Assigned
未分發人數     Unassigned    = $Unassigned
授權碼選課人數  AuthAssigned  = $AuthAssigned
交換生選課人數  ExAssigned    = $ExAssigned
不佔名額生人數  PtAssigned    = $PtAssigned
====================================================

HEREDOC;

?>
