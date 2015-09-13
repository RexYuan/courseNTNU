<?php $last_code = 0; ?>
<div class="outer">
    <div class="courses-list">
        <h2><?= $title ?></h2>  <!-- 系所名稱 -->
        <ul>
            <?php foreach ($drecords as $dr): // 印出本系所有課程
            if ($dr["code"] !== $last_code) {
            ?>

            <li>
                <a href="<?= $urlroot ?>index.php?dpm=<?= $_GET["dpm"] ?>&amp;cod=<?= $dr["code"] ?>">
                    <div class="teacherName">
                        <?= $dr["code"] ?>
                    </div>
                    <div class="courseName">
                        <?php
                            $last_code = $dr["code"];
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
            <?php }
            endforeach ?>
        </ul>
    </div>
</div>
