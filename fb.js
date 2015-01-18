window.fbAsyncInit = function() {
    FB.init({
        appId      : '1423906917900490',
        xfbml      : true,
        version    : 'v2.2'
    });

    checkLoginState();

    $(function() {
    var cod = $('#code').val();
    if (fbstatus == "connected")
    {
        $.post("btn.php", {"code": cod, "fbid": fbID})
            .done(function( data ) {
            // update html
                var datum = jQuery.parseJSON(data);
                console.log(datum);
                if (datum["vote"] == 'likeit')
                {
                    $("#likebtn").addClass('active');
                }
                else if (datum["vote"] == 'dislikeit')
                {
                    $("#dislikebtn").addClass('active');
                }
            })
            .fail(function() {
                alert("Error!Error!Error!這你也有問題？!");
            });}
    });
};

(function(d, s, id){
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

var fbstatus;
var fbID;

function statusChangeCallback(response) {
    fbstatus = response.status;
    if (fbstatus === 'connected')
    {
        // Logged into your app and Facebook.
        console.log(response);
        FB.api('/me', function(response) {
            console.log(JSON.stringify(response));
            document.getElementById('fbstatus').innerHTML = 'Hi,' + response.name;
            fbID = response.id;
        });
    }
    else if (fbstatus === 'not_authorized')
    {
        // The person is logged into Facebook, but not your app.
        document.getElementById('fbstatus').innerHTML = 'Please log into this app.';
        console.log(response);
    }
    else
    {
        // The person is not logged into Facebook, so we're not sure if
        // they are logged into this app or not.
        document.getElementById('fbstatus').innerHTML = 'Please log into Facebook.';
        console.log(response);
    }
}

function checkLoginState() {
    FB.getLoginStatus(function(response) {
        statusChangeCallback(response);
    });
}