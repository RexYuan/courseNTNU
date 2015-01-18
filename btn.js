var check = function(){
    if (fbID !== null)
    {
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
                    });
            }
        });
    }
    else
    {
        setTimeout(check, 500); // check again in 1 second
    }
}