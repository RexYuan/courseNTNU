function statusChangeCallback(response) {
    var response = response.status;
    /*if (response.status === 'connected')
    {
        // Logged into your app and Facebook.
        console.log(response);
        FB.api('/me', function(response) {
            console.log(JSON.stringify(response));
        });
    }
    else if (response.status === 'not_authorized')
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
    }*/
}

function checkLoginStateRate() {
    FB.getLoginStatus(function(response) {
        statusChangeCallback(response);
    });
}

$(function() {
    // when like clicked
    $('#likebtn').click(function(event) {
        if (response == "connected"){
        event.preventDefault();
        var cod= $('#code').val();
        var rat = $('#likebtn').val();

        // update database
        $.post("rate.php", {"code": cod, "rate": rat})
            .done(function( data ) {
                // update html
                var datum = jQuery.parseJSON(data);
                $('#rating_score').html(datum["ratings"]);
                $('#like_bar').css("width", datum["like_bar"]);
                $('#dislike_bar').css("width", datum["dislike_bar"]);
                $('#message').html(datum["message"]);
            })
            .fail(function() {
                alert("Error!Error!Error!因為很重要所以要說三次!");
            });}else{console.log(PLEASE LOGIN);}
    });
    
    // when dislike clicked
    $('#dislikebtn').click(function(event) {
        if (response == "connected"){
        event.preventDefault();
        var cod= $('#code').val();
        var rat = $('#dislikebtn').val();

        // update database
        $.post("rate.php", {"code": cod, "rate": rat})
            .done(function( data ) {
                // update html
                var datum = jQuery.parseJSON(data);
                $('#rating_score').html(datum["ratings"]);
                $('#like_bar').css("width", datum["like_bar"]);
                $('#dislike_bar').css("width", datum["dislike_bar"]);
                $('#message').html(datum["message"]);
            })
            .fail(function() {
                alert("Error!Error!Error!因為很重要所以要說三次!");
            });}else{console.log(PLEASE LOGIN);}
    });
});

console.log("師大最強的系?");
tahrd = "ㄏㄏ";
