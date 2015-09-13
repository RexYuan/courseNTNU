<!-- 處理追蹤頁面 -->
<?php if ($clst): ?>
  <?php foreach ($clst as $c): ?>
    <pre><?php print_r($c) ?></pre>
  <?php endforeach ?>
<?php else: ?>
  沒有紀錄
<?php endif ?>
