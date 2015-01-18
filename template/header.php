<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    
        <link href="bootstrap.min.css" rel="stylesheet"/>
        <link href="bootstrap-theme.min.css" rel="stylesheet"/>
        <link href="styles.css" rel="stylesheet"/>
        
        <script src="jquery-1.10.2.min.js"></script>
        <script src="bootstrap.min.js"></script>
        <script src="scripts.js"></script>
        <script src="btn.js"></script>
        
        <?php if (isset($title)): ?>
            <title>courseNTNU: <?= htmlspecialchars($title) ?></title>
        <?php else: ?>
            <title>courseNTNU</title>
        <?php endif ?>
    </head>

    <body>
        <div id="fb-root"></div>
        <script src="fb.js"></script>
        <div class="container-fluid" id="head">
            <div class="row">
                <div class="col-xs-12">
                    <h1 class="text-center"><a href="index.php">courseNTNU</a></h1>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <fb:login-button scope="public_profile,email" onlogin="checkLoginState();"></fb:login-button>
                </div>
                <div class="col-xs-6">
                    <h1 class="text-center" id="fbstatus"></h1>
                </div>
            </div>
        </div>
