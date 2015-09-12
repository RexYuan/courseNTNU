<div class="container" id="middle">

    <h3>
        <a href="<?= $urlroot ?>index.php">
            首頁
        </a>
        &gt;&gt;
        <a href="<?= $urlroot ?>index.php?dpm=<?= $course['department'] ?>">
            <?= $course['chdepartment'] ?>
        </a>
        &gt;&gt;
        <a href="<?= $urlroot ?>index.php?dpm=<?= $course['department'] ?>&amp;cod=<?= $course['code'] ?>">
            <?= $course['chname'] ?>
        </a>
        <?php if ($course["availability"] == '1'): ?>
            <span class="label label-success"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> 本學期有開課</span>
        <?php else: ?>
            <span class="label label-danger"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> 本學期未開課</span>
        <?php endif ?>
    </h3>

    <div class="jumbotron">
        <div class="row">
            <div class="col-xs-12 col-sm-8">
                <h1><?= $course["chname"] ?></h1>
                <h2><?= $course["eng_name"] ?></h2>
                <h3>開課序號：  <?= $course["serial_no"] ?></h3>
                <h4>教師：  <?= $course["teacher"] ?></h4>
                <h4>學分數：  <?= $course["credit"] ?></h4>
                <?php if ($course["availability"] === '1'): ?>
                  <h4>選課人數／限修人數：  <?= $course["counter_exceptAuth"]."／".$course["limit_count_h"] ?>
                <?php endif ?>
            </div>
            <div class="col-xs-12 col-sm-4">
                <h1 id="rating_score" class="text-center"><?= $ratings ?></h1>
                <div class="progress">
                    <div id="like_bar" class="progress-bar progress-bar-success" role="progressbar" style="width: <?= $likes ?>"></div>
                    <div id="dislike_bar" class="progress-bar progress-bar-danger" role="progressbar" style="width: <?= $dislikes ?>"></div>
                </div>
                <form role="form">
                    <div class="row">
                        <input id="code" class="hidden" name="code" value="<?= $course['code'] ?>"/>
                        <div class="col-xs-6 form-group">
                            <input id="likebtn" type="submit" class="btn btn-success btn-block" name="rate" value="推" disabled="disabled"/>
                        </div>
                        <div class="col-xs-6 form-group">
                            <input id="dislikebtn" type="submit" class="btn btn-danger btn-block" name="rate" value="不推" disabled="disabled"/>
                        </div>
                    </div>
                </form>
                <h4 id="message" class="text-center"><?= $message ?></h4>
            </div>
        </div>
        <div class="clearfix visible-xs"></div>
    </div>

    <div>
        <h4>課程簡介：</h4>
        <p>
            <?php if ($course["description"] === ""): ?>
                <div class="text-muted">沒有資料</div>
            <?php else: ?>
                <?= $course["description"] ?>
            <?php endif ?>
        </p>

        <div class="fb-comments" data-href="<?= htmlspecialchars($purl) ?>" data-width="100%" data-numposts="5" data-colorscheme="light"></div>
    </div>

</div>
