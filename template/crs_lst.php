<div class="outer">
    <div class="courses-list" id="clst">
        <h2><a href="<?=$urlroot?>index.php?dpm=<?= $_GET["dpm"] ?>"><?= $title ?></a></h2>
        <input class="search" />
        <ul class="list">
            <?php foreach ($drecords as $dr): ?>
            <li>
                <a href="<?= $urlroot ?>index.php?dpm=<?= $_GET["dpm"] ?>&amp;cod=<?= $dr["code"] ?>">
                    <div class="teacherName">
                        <?= $dr["code"] ?>
                    </div>
                    <div class="courseName">
                        <?= (mb_strlen($dr["name"]) > 9) ? mb_substr($dr["name"], 0, 9-1)."…" : $dr["name"]; ?>
                    </div>
                </a>
            </li>
            <?php endforeach ?>
        </ul>
    </div>
</div>
<script type="text/javascript">
var opts = {valueNames: [ 'courseName' ]};
var clst = new List('clst', opts);
</script>
