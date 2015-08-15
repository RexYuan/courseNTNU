<div class="container" id="middle">

    <h3>搜尋</h3>
    <div class="alert alert-warning hidden" id="search_blank_message" role="alert">欄位空白</div>
    <form class="form-inline" action="../search.php" method="GET">
        <div class="form-group">
            <input autofocus type="text" class="form-control" placeholder="想找什麼？" name="word">
        </div>
        <button type="submit" class="btn btn-default">搜尋</button>
    </form>

    <h4>
    <?php if (empty($results) && $home !== true): ?>
        沒有結果
    <?php elseif ($home === true): ?>
        輸入課程名稱或老師名字
    <?php else: ?>
        搜尋「<?= $word ?>」結果：
    <?php endif ?>
    </h4>

    <ul class="list-group">
        <?php foreach ($results as $result): ?>

            <?php if ($result["availability"] == '1'): ?>
                <a href="<?= $urlroot ?>index.php?dpm=<?= $result['department'] ?>&amp;cod=<?= $result['code'] ?>">
                    <li class="list-group-item">
                        <h4><span class="label label-success"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></span>
                            <?= $result['chname'] ?>
                        </h4>
                        <h5>
                            <?= $result['chdepartment'] ?>：
                            <?php if ($result['teacher'] === ""): ?>
                                沒有資料
                            <?php else: ?>
                                <?= $result['teacher'] ?>
                            <?php endif ?>
                        </h5>
                    </li>
                </a>
            <?php endif ?>

        <?php endforeach ?>
        <?php foreach ($results as $result): ?>

            <?php if ($result["availability"] == '0'): ?>
                <a href="<?= $urlroot ?>index.php?dpm=<?= $result['department'] ?>&amp;cod=<?= $result['code'] ?>">
                    <li class="list-group-item">
                        <h4><span class="label label-danger"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></span>
                            <?= $result['chname'] ?>
                        </h4>
                        <h5>
                            <?= $result['chdepartment'] ?>：
                            <?php if ($result['teacher'] === ""): ?>
                                沒有資料
                            <?php else: ?>
                                <?= $result['teacher'] ?>
                            <?php endif ?>
                        </h5>
                    </li>
                </a>
            <?php endif ?>

        <?php endforeach ?>
    </ul>

</div>
