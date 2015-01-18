//console.log(fbID);
//console.log(fbstatus);
//console.log(cod);
var initBtn = function() {
    var cod = $('#code').val();
    if (fbstatus == "connected")
    {
        $.post("btn.php", {"code": cod, "fbid": fbID})
            .done(function( data ) {
                // update html
                var datum = jQuery.parseJSON(data);
                console.log(datum);
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
                alert("Error!Error!Error!這你也有問題？!");
            });
    }
};

initBtn();