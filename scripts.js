$(function() {
    // when like clicked
    $('#likebtn').click(function(event) {
        event.preventDefault();
        if (fbstatus == "connected")
        {
            var cod = $('#code').val();
            var rat = $('#likebtn').val();

            // update database
            $.post("rate.php", {"code": cod, "rate": rat, "fbid": fbID})
                .done(function( data ) {
                    // update html
                    var datum = jQuery.parseJSON(data);
                    $('#rating_score').html(datum["ratings"]);
                    $('#like_bar').css("width", datum["like_bar"]);
                    $('#dislike_bar').css("width", datum["dislike_bar"]);
                    $('#message').html(datum["message"]);
                    if ($("#likebtn").hasClass("active"))
                    {
                        $("#likebtn").removeClass('active');
                    }
                    else
                    {
                        $("#likebtn").addClass('active');
                        $("#dislikebtn").removeClass('active');
                    }
                })
                .fail(function() {
                    alert("Error!Error!Error!因為很重要所以要說三次!");
                });
        }
            else
            {
                console.log("PLEASE LOGIN");
            }
        });
    
    // when dislike clicked
    $('#dislikebtn').click(function(event) {
        event.preventDefault();
        if (fbstatus == "connected"){
        var cod= $('#code').val();
        var rat = $('#dislikebtn').val();

        // update database
        $.post("rate.php", {"code": cod, "rate": rat, "fbid": fbID})
            .done(function( data ) {
                // update html
                var datum = jQuery.parseJSON(data);
                $('#rating_score').html(datum["ratings"]);
                $('#like_bar').css("width", datum["like_bar"]);
                $('#dislike_bar').css("width", datum["dislike_bar"]);
                $('#message').html(datum["message"]);
                if ($("#dislikebtn").hasClass("active"))
                {
                    $("#dislikebtn").removeClass('active');
                }
                else
                {
                    $("#dislikebtn").addClass('active');
                    $("#likebtn").removeClass('active');
                }
            })
            .fail(function() {
                alert("Error!Error!Error!因為很重要所以要說三次!");
            });}else{console.log("PLEASE LOGIN");}
    });
});

// initialize btn state
var initBtn = function() {
    $("#likebtn").prop('disabled', false);
    var cod = $('#code').val();
    if (fbstatus == "connected")
    {
        $.post("btn.php", {"code": cod, "fbid": fbID})
            .done(function( data ) {
                // update html
                var datum = jQuery.parseJSON(data);
                //console.log(datum);
                if (datum["vote"] === "1")
                {
                    $("#likebtn").addClass('active');
                }
                else if (datum["vote"] === "0")
                {
                    $("#dislikebtn").addClass('active');
                }
            })
            .fail(function() {
                alert("Error!Error!Error!因為很重要所以要說三次!");
            });
    }
};