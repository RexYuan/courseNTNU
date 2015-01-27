var fbstatus;
var token;
window.fbAsyncInit = function() {
    FB.init({
        appId      : '1423906917900490',
        xfbml      : true,
        version    : 'v2.2'
    });

    checkLoginState();
};

(function(d, s, id){
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

function statusChangeCallback(response) {
    fbstatus = response.status;
    if (fbstatus === 'connected')
    {
        // Logged into your app and Facebook.
        //console.log(response.authResponse.accessToken);
        token = response.authResponse.accessToken;
        FB.api('/me', function(response) {
            // console.log(JSON.stringify(response));
            //document.getElementById('fbstatus').innerHTML = 'Hi, ' + response.name;
            fbID = response.id;
            //fbMail = response.email;
            //fbName = response.name;
            //fbGender = response.gender;
          //  console.log(response);

            // initialize btns state
            initBtn();
            initRepBtn();
        });
    }
    else if (fbstatus === 'not_authorized')
    {
        // The person is logged into Facebook, but not your app.
        //document.getElementById('fbstatus').innerHTML = '尚未登入';

        // initialize btns state
        initBtn();
        initRepBtn();
    }
    else
    {
        // The person is not logged into Facebook, so we're not sure if
        // they are logged into this app or not.
        //document.getElementById('fbstatus').innerHTML = '';

        // initialize btns state
        initBtn();
        initRepBtn();
    }
}

function checkLoginState() {
    FB.getLoginStatus(function(response) {
        statusChangeCallback(response);
    });
}