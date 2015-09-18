<div class="outer">
    <div class="courses-list">
        <h2><a href="<?=$urlroot?>index.php?dpm=<?= $_GET["dpm"] ?>"><?= $title ?></a></h2>
        <ul>
            <?php foreach ($drecords as $dr): ?>
            <li>
                <a href="<?= $urlroot ?>index.php?dpm=<?= $_GET["dpm"] ?>&amp;cod=<?= $dr["code"] ?>">
                    <div class="teacherName">
                        <?= $dr["code"] ?>
                    </div>
                    <div class="courseName">
                        <?= (strlen($dr["name"]) > 9*3) ? substr($dr["name"], 0, 9*3-3)."…" : $dr["name"]; ?>
                    </div>
                </a>
            </li>
            <?php endforeach ?>
        </ul>
    </div>
</div>
