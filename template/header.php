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
        <script>
            window.fbAsyncInit = function() {
                FB.init({
                    appId      : '1423906917900490',
                    xfbml      : true,
                    version    : 'v2.2'
                });
            };

            (function(d, s, id){
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) {return;}
                    js = d.createElement(s); js.id = id;
                    js.src = "//connect.facebook.net/en_US/sdk.js";
                    fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));

            function statusChangeCallback(response) {
                if (response.status === 'connected')
                {
                    // Logged into your app and Facebook.
                    console.log(response);
                }
                else if (response.status === 'not_authorized')
                {
                    // The person is logged into Facebook, but not your app.
                    document.getElementById('status').innerHTML = 'Please log into this app.';
                    console.log(response);
                }
                else
                {
                    // The person is not logged into Facebook, so we're not sure if
                    // they are logged into this app or not.
                    document.getElementById('status').innerHTML = 'Please log into Facebook.';
                    console.log(response);
                }
            }

            function checkLoginState() {
                FB.getLoginStatus(function(response) {
                    statusChangeCallback(response);
                });
            }
        </script>
        <div class="container-fluid" id="head">
            <div class="row">
                <div class="col-xs-12">
                    <h1 class="text-center"><a href="<?= $urlroot ?>index.php">courseNTNU</a></h1>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <fb:login-button scope="public_profile,email" onlogin="checkLoginState();"></fb:login-button>
                </div>
            </div>
        </div>
