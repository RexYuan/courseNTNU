<h1><?= $title ?></h1>
<?php foreach ($drecords as $dr): ?>
  <a href="<?= $urlroot ?>index.php?dpm=<?= $_GET["dpm"] ?>&amp;cod=<?= $dr["code"] ?>"><?= $dr["name"] ?></a></br />
<?php endforeach ?>
