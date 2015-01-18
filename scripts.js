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
                    $("#likebtn").addClass('active');
                })
                .fail(function() {
                    alert("Error!Error!Error!因為很重要所以要說三次!");
                });
        }
            else
            {
                console.log("PLEASE LOGIN");
                $("#likebtn").attr('btn', 'btn-success', 'btn-block');
            }
        });
    
    // when dislike clicked
    $('#dislikebtn').click(function(event) {
        event.preventDefault();
        if (fbstatus == "connected"){
        var cod= $('#code').val();
        var rat = $('#dislikebtn').val();

        // update database
        $.post("rate.php", {"code": cod, "rate": rat, "fbid": fbid})
            .done(function( data ) {
                // update html
                var datum = jQuery.parseJSON(data);
                $('#rating_score').html(datum["ratings"]);
                $('#like_bar').css("width", datum["like_bar"]);
                $('#dislike_bar').css("width", datum["dislike_bar"]);
                $('#message').html(datum["message"]);
                $("#dislikebtn").addClass('active');
            })
            .fail(function() {
                alert("Error!Error!Error!因為很重要所以要說三次!");
            });}else{console.log("PLEASE LOGIN");}
    });
});

console.log("師大最強的系?");
tahrd = "ㄏㄏ";