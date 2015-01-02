$(function() {
    // when like clicked
    $('#likebtn').click(function(event) {
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
            });
    });
    
    // when dislike clicked
    $('#dislikebtn').click(function(event) {
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
            })
    });
});

console.log("師大最強的系?");
tahrd = "ㄏㄏ";
