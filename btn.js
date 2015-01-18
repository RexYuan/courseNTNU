var cod = $('#code').val();
$.post("rate.php", {"code": cod, "fbid": fbID})
    .done(function( data ) {
        // update html
        var datum = jQuery.parseJSON(data);
        if ($datum["vote"] == 'likeit')
        {
            
        }
    })
    .fail(function() {
        alert("Error!Error!Error!這你也有問題？!");
    });