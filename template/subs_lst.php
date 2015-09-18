<!-- 處理追蹤頁面 -->
<?php if ($clst): ?>
  <table class="table">
    <thead>
    </thead>
    <tobdy>
      <tr>
        <td>開課序號</td>
        <td>教師姓名</td>
        <td>課程名稱</td>
        <td>限修人數</td>
        <td>選課人數</td>
        <td>已分發人數</td>
        <td>授權碼總數</td>
        <td>授權碼已使用數</td>
      </tr>
  <?php foreach ($clst as $c): ?>
    <tr>
      <td><?= $c["SerialNo"] ?></td>
      <td><?= $c["TeChName"] ?></td>
      <td><a href="<?= $urlroot ?>index.php?dpm=<?= $c["DeptId"] ?>&amp;cod=<?= $c["CourseCode"] ?>"><?= $c["ChName"] ?></a></td>
      <td><?= $c["TotalMaxSize"] ?></td>
      <td><?= $c["Enrolled"] ?></td>
      <td><?= $c["Assigned"] ?></td>
      <td><?= $c["AuthMaxSize"] ?></td>
      <td><?= $c["AuthAssigned"] ?></td>
    </tr>
  <?php endforeach ?>
    </tbody>
  </table>
<?php else: ?>
  沒有紀錄
<?php endif ?>
<!--<dl>
  <dt>開課序號</dt>
  <dd><= $c["SerialNo"] ?></dd>

  <dt>教師姓名</dt>
  <dd><= $c["TeChName"] ?></dd>

  <dt>課程中文名稱</dt>
  <dd><a href="<= $urlroot ?>index.php?dpm=<= $c["DeptId"] ?>&amp;cod=<= $c["CourseCode"] ?>"><= $c["ChName"] ?></a></dd>

  <dt>限修人數</dt>
  <dd><= $c["TotalMaxSize"] ?></dd>

  <dt>選課人數</dt>
  <dd><= $c["Enrolled"] ?></dd>

  <dt>已分發人數</dt>
  <dd><= $c["Assigned"] ?></dd>

  <dt>授權碼總數</dt>
  <dd><= $c["AuthMaxSize"] ?></dd>

  <dt>授權碼已使用數</dt>
  <dd><= $c["AuthAssigned"] ?><dd>
</dl>-->
