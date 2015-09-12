<div class="container" id="middle">
  <?php if ($crs): ?>
    <table class="table">
      <thead>
      <tr>
        <th>課程</th>
        <th>開課序號</th>
        <th>教師</th>
        <th>限修人數</th>
        <th>已分發人數</th>
        <th>授權碼人數</th>
      </tr>
      </thead>
      <tbody>
      <?php foreach ($crs as $cr): ?>
        <tr>
          <th><?= $cr['chname'] ?></th>
          <th>serial_no</th>
          <th>teacher</th>
          <th>限修人數</th>
          <th>已分發人數</th>
          <th>授權碼人數</th>
        </tr>
      <?php endforeach ?>
      </tbody>
    </table>
  <?php else: ?>
    沒有紀錄
  <?php endif ?>
</div>
