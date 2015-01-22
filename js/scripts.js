$(function() {
    // when like clicked
    $('#likebtn').click(function(event) {
        event.preventDefault();
        if (fbstatus == "connected")
        {
            var cod = $('#code').val();
            var rat = $('#likebtn').val();

            // update database
            $.post("../rate.php", {"code": cod, "rate": rat, "fbid": fbID, "fbname": fbName, "fblink": fbLink, "fbgender": fbGender})
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
            $('#fbModal').modal('show');
        }
    });
    
    // when dislike clicked
    $('#dislikebtn').click(function(event) {
        event.preventDefault();
        if (fbstatus == "connected"){
        var cod= $('#code').val();
        var rat = $('#dislikebtn').val();

        // update database
        $.post("../rate.php", {"code": cod, "rate": rat, "fbid": fbID, "fbname": fbName, "fblink": fbLink, "fbgender": fbGender})
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
            $('#fbModal').modal('show');
        }
    });

    // when report btn clicked
    $('#submit_report').click(function(event) {
        event.preventDefault();
        if (fbstatus == "connected"){
        var report = $('#report').val();

            if (report === "")
            {
                $("#report_blank_message").removeClass('hidden');
            }
            else
            {
                // update database
                $.post("../report.php", {"report": report, "fbid": fbID, "fbmail": fbMail, "fbname": fbName, "fblink": fbLink, "fbgender": fbGender})
                    .done(function( data ) {
                        // update html
                        $("#report_success_message").removeClass('hidden');
                        $("#report_blank_message").addClass('hidden');
                        $("#submit_report").prop('disabled', true);
                        setTimeout(function(){parent.history.back()();}, 1000);
                    })
                    .fail(function( data ) {
                        alert("錯誤: 代碼3，請聯絡開發人員\n(" + data.status + ": " + data.statusText + ")");
                        console.log(data);
                    });
            }
        }
        else
        {
            $('#fbModal').modal('show');
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

// initialize report btn state
var initRepBtn = function() {
    // update html
    $("#submit_report").prop('disabled', false);
};
