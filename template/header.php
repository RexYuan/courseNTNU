<!DOCTYPE html>

<html lang="zh-Hant">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta property="fb:app_id" content="1423906917900490"/>
    
        <link href="css/bootstrap.min.css" rel="stylesheet"/>
        <link href="css/bootstrap-theme.min.css" rel="stylesheet"/>
        <link href="css/styles.css" rel="stylesheet"/>
        
        <script src="js/jquery-1.11.2.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/scripts.js"></script>
        
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
                <div class="col-xs-2 col-sm-1">
                    <h2>
                        <a href="leaderboard.php"><span class="label label-warning"><small><span class="glyphicon glyphicon-stats" aria-hidden="true"></span><small></span></a>
                    </h2>
                </div>
                <div class="col-xs-8 col-sm-10">
                    <h1 class="text-center">
                        <strong id="title"><a href="index.php">courseNTNU</a></strong><small>Beta</small>
                    </h1>
                </div>
                <div class="col-xs-2 col-sm-1">
                    <h2>
                        <a href="search.php"><span class="label label-warning"><small><span class="glyphicon glyphicon-search" aria-hidden="true"></span><small></span></a>
                    </h2>
                </div>
            </div>
        </div>
