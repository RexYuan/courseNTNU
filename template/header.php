<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    
        <link href="<?= $urlroot ?>bootstrap.min.css" rel="stylesheet"/>
        <link href="<?= $urlroot ?>bootstrap-theme.min.css" rel="stylesheet"/>
        <link href="<?= $urlroot ?>styles.css" rel="stylesheet"/>
        
        <script src="<?= $urlroot ?>jquery-1.10.2.min.js"></script>
        <script src="<?= $urlroot ?>bootstrap.min.js"></script>
        <script src="<?= $urlroot ?>scripts.js"></script>
        
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
                    <h1 class="text-center"><a href="<?= $urlroot ?>index.php">courseNTNU</a></h1>
                </div>
            </div>
        </div>
