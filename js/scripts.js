var debug = false;
$(function() {
  $('.ratbtn').click(function(event) {
    var id = $(this).data("cid");
    var rate = $(this).data("rate");
    var code = $(this).data("cod");
    event.preventDefault();
    FB.getLoginStatus(function(response) {
      var fbstatus = response.status;
      if (fbstatus == "connected")
      {
        $.post("../rate_handle.php", {"t": token, "r": rate, "i": id, "c": code})
          .done(function( data ) {
            var d = $.parseJSON(data)["scores"];
            $.each(d, function(k,v) {
              $(".lk-"+k).html(v["LikeIt"]);
              $(".dlk-"+k).html(v["DislikeIt"]);
              // TODO: 更新按鈕外觀樣子表示出已經按下去或是按起來
            });
          })
          .fail(function( data ) {
            if (debug)
            {
              alert("錯誤: 0\n(" + data.status + ": " + data.statusText + ")");
              console.log(data);
            }
          });
        }
        else
        {
          $('#fbModal').modal('show');
        }
        });
    });
    // 按下追蹤
    $('.subscribe').click(function(event) {
      var n = $(this).data("serial");
      event.preventDefault();
      FB.getLoginStatus(function(response) {
        var fbstatus = response.status;
        if (fbstatus == "connected"){
          // 拿 token, CourseCode Ajax 更新資料庫
          $.post("../sub_handle.php", {"n": n, "t": token})
            .done(function( data ) {
              // 更新前端
              alert(n);
            })
            .fail(function( data ) {
              if (debug)
              {
                alert("錯誤: 3\n(" + data.status + ": " + data.statusText + ")");
                console.log(data);
              }
            });
        }
        else
        {
          $('#fbModal').modal('show');
        }
      });
    });
});

// initialize btn state
/*var initBtn = function() {
  // 初始追蹤按鈕以及投票按鈕
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
