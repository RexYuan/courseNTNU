<div class="container" id="middle">

    <h3>
        <a href="<?= $urlroot ?>index.php?dpm=<?= $course['department'] ?>">
            <?= $course['chdepartment'] ?>
        </a>
        >>
        <a href="<?= $urlroot ?>index.php?dpm=<?= $course['department'] ?>&amp;cod=<?= $course['code'] ?>">
            <?= $course['chname'] ?>
        </a>
    </h3>
    
    <div class="jumbotron">
        <div class="row">
            <div class="col-xs-12 col-sm-8">
                <h2><?= $course["chname"] ?></h2>
                <h4>學分數：  <?= $course["credit"] ?></h4>
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
                            <input id="likebtn" type="submit" class="btn btn-success btn-block" name="rate" value="推"/>
                        </div>
                        <div class="col-xs-6 form-group">
                            <input id="dislikebtn" type="submit" class="btn btn-danger btn-block" name="rate" value="不推"/>
                        </div>
                    </div>
                </form>
                <h4 id="message" class="text-center"><?= $message ?></h4>
            </div>
        </div>
        <div class="clearfix visible-xs"></div>
    </div>
    
    <div>
        <h4>選課沒地雷：  </h4>
        <?php if ($course["fbreview"] === NULL): ?>
            <div class="text-muted"><p>沒有評論</p></div>
        <?php else: ?>
            <p>
                <?= $course["fbreview"] ?>
            </p>
        <?php endif ?>
        
        <h4>課程簡介：  </h4>
        <p>
            <?= $course["description"] ?>
        </p>
    </div>
    
</div>
