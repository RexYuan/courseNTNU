<div class="container" id="middle">
    <form action="<?= $urlroot ?>index.php" method="get" role="form">
        
        <h3>
            <a href="<?= $urlroot ?>index.php">
                首頁
            </a>
            >>
            <a href="<?= $urlroot ?>index.php?dpm=<?= $courses[0]['department'] ?>">
                <?= $courses[0]['chdepartment'] ?>
            </a>
        </h3>
        
        <ul class="list-group">
        <?php foreach($courses as $course): ?>

            <?php if ($course["availability"] === '1'): ?>
            <a href="<?= $urlroot ?>index.php?dpm=<?= $course['department'] ?>&amp;cod=<?= $course['code'] ?>">
                <li class="list-group-item">
                    <h4><span class="label label-success"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></span>
                            <?= $course['chname'] ?>
                    </h4>
                </li>
            </a>
            <?php endif ?>
            
        <?php endforeach ?>
        <?php foreach($courses as $course): ?>

            <?php if ($course["availability"] === '0'): ?>
            <a href="<?= $urlroot ?>index.php?dpm=<?= $course['department'] ?>&amp;cod=<?= $course['code'] ?>">
                <li class="list-group-item">
                    <h4><span class="label label-danger"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></span>
                        <?= $course['chname'] ?>
                    </h4>
                </li>
            </a>
            <?php endif ?>

        <?php endforeach ?>
        </ul>
        
    </form>
</div>
