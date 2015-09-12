<div class="outer">
    <div class="course">
        <h2><?= $title ?></h2>
        <ul>
            <?php foreach ($drecords as $dr): ?>
            <li>
                <a href="<?= $urlroot ?>index.php?dpm=<?= $_GET["dpm"] ?>&amp;cod=<?= $dr["code"] ?>">
                    <div class="teacherName">
                        老師名字
                    </div>
                    <div class="courseName">
                        <?php
                            $tmp = $dr["name"];
                            if (strlen($tmp) > 11 * 3)
                            {
                                $tmp = substr($tmp, 0, 11 * 3)."…";
                            }
                            echo $tmp
                        ?>
                    </div>
                </a>
            </li>
            <?php endforeach ?>
        </ul>
    </div>
</div>
