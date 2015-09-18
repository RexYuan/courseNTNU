<!--<div class="container" id="middle">

    <div class="row">
        <div class="col-xs-12 col-sm-6">
            <h3>通識課程排行榜</h3>
            <ul class="list-group">
                <?php foreach ($geleaders as $geleader): ?>

                    <a href="<?= $urlroot ?>index.php?dpm=<?= $geleader['department'] ?>&amp;cod=<?= $geleader['code'] ?>">
                        <li class="list-group-item">
                            <h4><span class="label label-primary"><?= floor($geleader['ratings'] * 100) ?></span>
                                <?= $geleader['chname'] ?>
                            </h4>
                            <h5>
                                <?= $geleader['chdepartment'] ?>：
                                <?php if ($geleader['teacher'] === ""): ?>
                                    沒有資料
                                <?php else: ?>
                                    <?= $geleader['teacher'] ?>
                                <?php endif ?>
                            </h5>
                        </li>
                    </a>

                <?php endforeach ?>
            </ul>
        </div>
        <div class="col-xs-12 col-sm-6">
            <h3>其他課程課程排行榜</h3>
            <ul class="list-group">
                <?php foreach ($otherleaders as $otherleader): ?>

                    <a href="<?= $urlroot ?>index.php?dpm=<?= $otherleader['department'] ?>&amp;cod=<?= $otherleader['code'] ?>">
                        <li class="list-group-item">
                            <h4><span class="label label-primary"><?= floor($otherleader['ratings'] * 100) ?></span>
                                <?= $otherleader['chname'] ?>
                            </h4>
                            <h5>
                                <?= $otherleader['chdepartment'] ?>：
                                <?php if ($otherleader['teacher'] === ""): ?>
                                    沒有資料
                                <?php else: ?>
                                    <?= $otherleader['teacher'] ?>
                                <?php endif ?>
                            </h5>
                        </li>
                    </a>

                <?php endforeach ?>
            </ul>
        </div>
    </div>
    <div class="text-center">
        <h6>僅列出達到一定總投票數的課程</h6>
    </div>

</div>-->
