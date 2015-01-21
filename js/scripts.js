$(function() {
    // when like clicked
    $('#likebtn').click(function(event) {
        event.preventDefault();
        if (fbstatus == "connected")
        {
            var cod = $('#code').val();
            var rat = $('#likebtn').val();

            // update database
            $.post("../rate.php", {"code": cod, "rate": rat, "fbid": fbID})
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
                .fail(function( data ) {
                    alert("錯誤: 代碼0，請聯絡開發人員\n(" + data.status + ": " + data.statusText + ")");
                    console.log(data);
                });
        }
        else
        {
            $('#myModal').modal('show');
        }
    });
    
    // when dislike clicked
    $('#dislikebtn').click(function(event) {
        event.preventDefault();
        if (fbstatus == "connected"){
        var cod= $('#code').val();
        var rat = $('#dislikebtn').val();

        // update database
        $.post("../rate.php", {"code": cod, "rate": rat, "fbid": fbID})
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
            .fail(function( data ) {
                alert("錯誤: 代碼1，請聯絡開發人員\n(" + data.status + ": " + data.statusText + ")");
                console.log(data);
            });
        }
        else
        {
            $('#myModal').modal('show');
        }
    });
});

// initialize btn state
var initBtn = function() {
    $("#likebtn").prop('disabled', false);
    $("#dislikebtn").prop('disabled', false);
    var cod = $('#code').val();
    if (fbstatus === "connected")
    {
        $.post("../btn.php", {"code": cod, "fbid": fbID})
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
            .fail(function( data ) {
                alert("錯誤: 代碼2，請聯絡開發人員\n(" + data.status + ": " + data.statusText + ")");
                console.log(data);
            });
    }
};