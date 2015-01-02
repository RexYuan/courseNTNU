<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    
        <link href="<?= $urlroot ?>coursentnu/bootstrap.min.css" rel="stylesheet"/>
        <link href="<?= $urlroot ?>coursentnu/bootstrap-theme.min.css" rel="stylesheet"/>
        <link href="<?= $urlroot ?>coursentnu/styles.css" rel="stylesheet"/>
        
        <script src="<?= $urlroot ?>coursentnu/jquery-1.10.2.min.js"></script>
        <script src="<?= $urlroot ?>coursentnu/bootstrap.min.js"></script>
        <script src="<?= $urlroot ?>coursentnu/scripts.js"></script>
        
        <?php if (isset($title)): ?>
            <title>courseNTNU: <?= htmlspecialchars($title) ?></title>
        <?php else: ?>
            <title>courseNTNU</title>
        <?php endif ?>
    </head>

    <body>
        <div class="container-fluid" id="head">
            <div class="row">
                <div class="col-xs-12">
                    <h1 class="text-center"><a href="<?= $urlroot ?>coursentnu/index.php">courseNTNU</a></h1>
                </div>
            </div>
        </div>
