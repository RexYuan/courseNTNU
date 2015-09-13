/*$(function() {
    // when like clicked
    $('#likebtn').click(function(event) {
        event.preventDefault();
        FB.getLoginStatus(function(response) {
        var fbstatus = response.status;
        if (fbstatus == "connected")
        {
            var cod = $('#code').val();
            var rat = $('#likebtn').val();

            // update database
            $.post("../rate.php", {"token": token, "rate": rat, "code": cod})
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
                    //alert("錯誤: 0\n(" + data.status + ": " + data.statusText + ")");
                    console.log(data);
                });
        }
        else
        {
            $('#fbModal').modal('show');
        }
        });
    });

    // when dislike clicked
    $('#dislikebtn').click(function(event) {
        event.preventDefault();
        FB.getLoginStatus(function(response) {
        var fbstatus = response.status;
        if (fbstatus == "connected"){
        var cod= $('#code').val();
        var rat = $('#dislikebtn').val();

        // update database
        $.post("../rate.php", {"token": token, "rate": rat, "code": cod})
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
                //alert("錯誤: 1\n(" + data.status + ": " + data.statusText + ")");
                console.log(data);
            });
        }
        else
        {
            $('#fbModal').modal('show');
        }
        });
    });

    // 按下追蹤
    $('#subscribe').click(function(event) {
      event.preventDefault();
      FB.getLoginStatus(function(response) {
        var fbstatus = response.status;
        if (fbstatus == "connected"){
          // 拿 token, CourseCode Ajax 更新資料庫
          $.post("../sub_btn.php", {"code": , "token": token})
            .done(function( data ) {
              // 更新前端
            })
            .fail(function( data ) {
              //alert("錯誤: 3\n(" + data.status + ": " + data.statusText + ")");
              console.log(data);
            });
        }
        else
        {
          $('#fbModal').modal('show');
        }
      });
    });
});*/

// initialize btn state
/*var initBtn = function() {
  // 初始追蹤按鈕
    $("#likebtn").prop('disabled', false);
    $("#dislikebtn").prop('disabled', false);
    var cod = $('#code').val();
    FB.getLoginStatus(function(response) {
    var fbstatus = response.status;
    if (fbstatus === "connected")
    {
        $.post("../rate_btn.php", {"code": cod, "fbid": fbID})
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
                //alert("錯誤: 2\n(" + data.status + ": " + data.statusText + ")");
                console.log(data);
            });
    }
    });
};*/

(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
ga('create', 'UA-58924606-1', 'auto');
ga('send', 'pageview');
