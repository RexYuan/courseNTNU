$(function() {
    var cod = $('#code').val();
$.post("btn.php", {"code": cod, "fbid": fbID})
    .done(function( data ) {
        // update html
        console.log(cod);
        console.log(fbID);
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
    });
    });