<div class="outer">
  <div class="tip">
    小提醒：如果覺得一個個找太累的話，可以善用 <pre>ctrl</pre>/<pre>command</pre> + <pre>f</pre> 的搜尋功能！
  </div>
  <div class="deps">
    <?php $anchor = 0; foreach ($gnc as $g): ?>
      <h2><?= $g[0] ?></h2>
      <ul>
        <?php foreach (array_slice($dpms, $anchor, $g[1]) as $dpm): ?>
          <li><a href="$urlroot"index.php?dpm="<?= $dpm["DeptCode"] ?>"><?= $dpm["ChName"] ?></a></li>
        <?php endforeach; $anchor = $anchor+$g[1]; ?>
      </ul>
    <?php endforeach ?>
  </div>
</div>
