<?php foreach ($dpms as $dpm): ?>
  <a href="<?= $urlroot ?>index.php?dpm=<?= $dpm["DeptCode"] ?>"><?= $dpm["ChName"] ?></a><br />
<?php endforeach ?>
