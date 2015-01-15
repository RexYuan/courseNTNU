<div class="container" id="middle">
    <form action="<?= $urlroot ?>index.php" method="get" role="form">
        
        <h3>
            <a href="<?= $urlroot ?>index.php?dpm=<?= $courses[0]['department'] ?>">
                <?= $courses[0]['chdepartment'] ?>
            </a>
        </h3>
        
        <ul class="list-group">
        <?php foreach($courses as $course): ?>

            <li class="list-group-item">
                <h4><a href="<?= $urlroot ?>index.php?dpm=<?= $course['department'] ?>&amp;cod=<?= $course['code'] ?>">
                    <?= $course['chname'] ?>
                </a></h4>
            </li>
        
        <?php endforeach ?>
        </ul>
        
    </form>
</div>
