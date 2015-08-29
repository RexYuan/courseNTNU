<h1><?= $crecords[0]["ChName"] ?></h1>
<?php foreach ($crecords as $crecord): ?>
<!-- 為了讓這個檔案簡潔一點，儒老師跟系所的部分都還沒做連結所以只有id，也不一定每行資料都會用得上 -->
  <h2><?= $crecord["CourseId"] ?></h2>
  <h2><?= $crecord["SerialNo"] ?></h2> <!-- 開課序號 -->
  <h2><?= $crecord["CourseCode"] ?></h2> <!-- 課程代碼 -->
  <h2><?= $crecord["AcadmYear"] ?></h2> <!-- 學年 -->
  <h2><?= $crecord["AcadmTerm"] ?></h2> <!-- 學期 -->
  <h2><?= $crecord["ChName"] ?></h2> <!-- 中文課程名稱 -->
  <h2><?= $crecord["EnName"] ?></h2> <!-- 中文課程名稱 -->
  <h2><?= $crecord["TeacherId"] ?></h2> <!-- 教師識別碼 -->
  <h2><?= $crecord["CourseGroup"] ?></h2> <!-- 組別 -->
  <h2><?= $crecord["ClassCode"] ?></h2> <!-- 開課班級代碼 -->
  <h2><?= $crecord["Duration"] ?></h2> <!-- 全/半學期 -->
  <h2><?= $crecord["Credit"] ?></h2> <!-- 學分數 -->
  <h2><?= $crecord["DeptId"] ?></h2> <!-- 開課系所識別碼 -->
  <h2><?= $crecord["DeptGroup"] ?></h2> <!-- 開課組別 -->
  <h2><?= $crecord["IsEngTeach"] ?></h2> <!-- 全英語授課 -->
  <h2><?= $crecord["Grade"] ?></h2> <!-- 開課年級 -->
  <h2><?= $crecord["GenderRestrict"] ?></h2> <!-- 性別限制 -->
  <h2><?= $crecord["IsMOOC"] ?></h2> <!-- MOOCs -->
  <h2><?= $crecord["IsElective"] ?></h2> <!-- 必／選修 -->
  <h2><?= $crecord["RestrictInfo"] ?></h2> <!-- 限制 -->
  <h2><?= $crecord["RemoteTeach"] ?></h2> <!-- 遠距授課 -->
  <h2><?= $crecord["selfTeachName"] ?></h2> <!-- 正課實驗親授 -->
  <h2><?= $crecord["ChLocation"] ?></h2> <!-- 中文上課地點 -->
  <h2><?= $crecord["EnLocation"] ?></h2> <!-- 英文上課地點 -->
  <h2><?= $crecord["TimeInfo"] ?></h2> <!-- 上課時間 -->
  <h2><?= $crecord["StatusInfo"] ?></h2> <!-- 是否停開 -->
  <h2><?= $crecord["ChComment"] ?></h2> <!-- 中文註解 -->
  <h2><?= $crecord["EnComment"] ?></h2> <!-- 英文註解 -->
  <h2><?= $crecord["AuthMaxSize"] ?></h2> <!-- 授權碼名額 -->
  <h2><?= $crecord["AuthRate"] ?></h2> <!-- 授權碼比例 -->
  <h2><?= $crecord["NTAMaxSize"] ?></h2> <!-- 台大聯盟限修人數 -->
  <h2><?= $crecord["TotalMaxSize"] ?></h2> <!-- 限修人數 -->
  <h2><?= $crecord["Hour"] ?></h2> <!-- 上課時數 -->
  <h2><?= $crecord["Description"] ?></h2> <!-- 課程簡介 -->
  <h2><?= $crecord["FmReserve"] ?></h2> <!-- 保留新生人數 -->
  <h2><?= $crecord["Enrolled"] ?></h2> <!-- 選課人數 -->
  <h2><?= $crecord["Assigned"] ?></h2> <!-- 已分發人數 -->
  <h2><?= $crecord["Unassigned"] ?></h2> <!-- 未分發人數 -->
  <h2><?= $crecord["AuthAssigned"] ?></h2> <!-- 授權碼選課人數 -->
  <h2><?= $crecord["ExAssigned"] ?></h2> <!-- 交換生選課人數 -->
  <h2><?= $crecord["PtAssigned"] ?></h2> <!-- 不佔名額生人數 -->
<?php endforeach ?>
<!-- 還要規劃評論跟投票區，以及一個「追蹤（subscribe）」按鈕 -->
<div class="fb-comments" data-href="<?= $urlroot.$_SERVER["REQUEST_URI"] ?>" data-width="100%" data-numposts="5" data-colorscheme="light"></div></div>
