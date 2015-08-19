<!DOCTYPE html>

<html lang="zh-Hant">
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <meta property="fb:app_id" content="1423906917900490"/>

        <meta property="og:image" content="images/og_logo.png"/>
        <meta property="og:title" content="Course NTNU"/>
        <meta property="og:description" content="評價和查詢師大課程"/>
        <link rel="shortcut icon" href="images/16x16course.ico" type="image/x-icon"/>
		    <link rel="icon" href="images/16x16course.ico" type="image/x-icon"/>

        <link href="css/bootstrap.min.css" rel="stylesheet"/>
        <link href="css/bootstrap-theme.min.css" rel="stylesheet"/>
        <link href="css/styles.css" rel="stylesheet"/>

        <script src="js/jquery-1.11.2.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/scripts.js"></script>
        <script src="js/konami.js"></script>

        <?php if (isset($title)): ?>
            <title>courseNTNU：<?= htmlspecialchars($title) ?></title>
        <?php else: ?>
            <title>courseNTNU</title>
        <?php endif ?>
    </head>

    <body>
        <div id="fb-root"></div>
        <script src="js/fb.js"></script>
        <div class="container-fluid" id="head">
            <div class="row">
                <div class="col-xs-2 col-sm-2">
                    <h2 class="text-left">
                        <a href="leaderboard.php">
                            <span class="label label-warning">
                                <small>
                                    <span class="glyphicon glyphicon-stats" aria-hidden="true"></span>
                                    <span class="hidden-xs">排行</span>
                                </small>
                            </span>
                        </a>
                    </h2>
                </div>
                <div class="col-xs-8 col-sm-8">
                    <h1 class="text-center">
                        <strong id="title"><a href="index.php">courseNTNU</a></strong><small>Beta</small>
                    </h1>
                </div>
                <div class="col-xs-2 col-sm-2">
                    <h2 class="text-right">
                        <a href="search.php">
                            <span class="label label-warning">
                                <small>
                                    <span class="hidden-xs">搜尋</span>
                                    <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                </small>
                            </span>
                        </a>
                    </h2>
                </div>
            </div>
        </div>
