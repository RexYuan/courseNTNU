<div class="outer">
  <div class="tip">
    小提醒：如果覺得一個個找太累的話，可以善用 <pre>ctrl</pre>/<pre>command</pre> + <pre>f</pre> 的搜尋功能！
  </div>
  <div class="deps">
    <input type="text" class="fuzzy-search" />
    <?php $lsc = 0; $anchor = 0; foreach ($gnc as $g): ?>
      <h2><?= $g[0] ?></h2>
      <div id="dlst<?php echo $lsc; $lsc++; ?>">
        <ul class="list">
          <?php foreach (array_slice($dpms, $anchor, $g[1]) as $dpm): ?>
            <li><a class="dname" href="<?= $urlroot ?>index.php?dpm=<?= $dpm["DeptCode"] ?>"><?= $dpm["ChName"] ?></a></li>
          <?php endforeach; $anchor = $anchor+$g[1]; ?>
        </ul>
      </div>
    <?php endforeach ?>
  </div>
</div>
<script type="text/javascript">
  var args = {valueNames: [ 'dname' ]};
  <?php for ($i = 0; $i < 13; $i++): ?>
    var dlst<?= $i ?> = new List("dlst<?= $i ?>", args);
  <?php endfor ?>
  $(".fuzzy-search").keyup(function(){
    <?php for ($i = 0; $i < 13; $i++): ?>
      dlst<?= $i ?>.search($(this).val());
    <?php endfor ?>
  });
</script>
