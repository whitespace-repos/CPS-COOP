(function ($) {
  "use strict";



	$(".menuBtn").on('click', function() {

			$('.sideBar').toggleClass("menu-toggle");

		});


$(window).on("load resize ", function() {
  var scrollWidth = $('.tbl-content').width() - $('.tbl-content table').width();
  $('.tbl-header').css({'padding-right':scrollWidth});
}).resize();

$('table').DataTable();


$(function() {
    function c() {
        p();
        var e = h();
        var r = 0;
        var u = false;
        l.empty();
        while (!u) {
            if (s[r] == e[0].weekday) {
                u = true
            } else {
                l.append('<div class="blank"></div>');
                r++
            }
        }
        for (var c = 0; c < 42 - r; c++) {
            if (c >= e.length) {
                l.append('<div class="blank"></div>')
            } else {
                var v = e[c].day;
                var m = g(new Date(t, n - 1, v)) ? '<div class="today"><span>' : "<div>";
                l.append(m + "" + v + "</span></div>")
            }
        }
        var y = o[n - 1];
        a.css("background-color", y).find("h5").text(i[n - 1] + " " + t);
        f.find("div").css("color", y);
        l.find(".today").css("background-color", y);
        d()
    }

    function h() {
        var e = [];
        for (var r = 1; r < v(t, n) + 1; r++) {
            e.push({
                day: r,
                weekday: s[m(t, n, r)]
            })
        }
        return e
    }

    function p() {
        f.empty();
        for (var e = 0; e < 7; e++) {
            f.append("<div>" + s[e].substring(0, 2) + "</div>")
        }
    }

    function d() {
        var t;
        var n = $("#calendar").css("width", e + "px");
        n.find(t = "#calendar_weekdays, #calendar_content").css("width", e + "px").find("div").css({
            width: e / 7 + "px",
            height: e / 9 + "px",
            "line-height": e / 7 + "px"
        });
        n.find("#calendar_header").css({
            height: e * (1 / 9) + "px"
        }).find('i[class^="icon-chevron"]').css("line-height", e * (1 / 9) + "px")
    }

    function v(e, t) {
        return (new Date(e, t, 0)).getDate()
    }

    function m(e, t, n) {
        return (new Date(e, t - 1, n)).getDay()
    }

    function g(e) {
        return y(new Date) == y(e)
    }

    function y(e) {
        return e.getFullYear() + "/" + (e.getMonth() + 1) + "/" + e.getDate()
    }

    function b() {
        var e = new Date;
        t = e.getFullYear();
        n = e.getMonth() + 1
    }
    var e = 375;
    var t = 2013;
    var n = 9;
    var r = [];
    var i = ["JANUARY", "FEBRUARY", "MARCH", "APRIL", "MAY", "JUNE", "JULY", "AUGUST", "SEPTEMBER", "OCTOBER", "NOVEMBER", "DECEMBER"];
    var s = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
    var o = ["#ffffff"];
    var u = $("#calendar");
    var a = u.find("#calendar_header");
    var f = u.find("#calendar_weekdays");
    var l = u.find("#calendar_content");
    b();
    c();
    a.find('i[class^="icon-chevron"]').on("click", function() {
        var e = $(this);
        var r = function(e) {
            n = e == "next" ? n + 1 : n - 1;
            if (n < 1) {
                n = 12;
                t--
            } else if (n > 12) {
                n = 1;
                t++
            }
            c()
        };
        if (e.attr("class").indexOf("left") != -1) {
            r("previous")
        } else {
            r("next")
        }
    })
})


$(function () {
    $('selectpicker').selectpicker();
});




// $('#inputDate').datepicker({
// });


$('table').DataTable();



})(jQuery);

