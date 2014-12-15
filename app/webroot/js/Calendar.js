/**
 * Calendar script
 * By: Louis <louis@ne02ptzero.me>
 */

actual = {};

$(document).ready(function() {
	$(document).on("click", ".calendar .month .chevron", function() {
		dir = $(this).attr('class')[0];
		month = $(this).parent().find(".num").html();
		if (dir == "r") {
			$(this).parent().parent().find(".month_"+ month).fadeOut(200, function() {
				$(this).parent().find(".month_"+ ((month * 1) + (1 * 1))).fadeIn(200);
			});
		} else {
			$(this).parent().parent().find(".month_"+ month).fadeOut(200, function() {
				$(this).parent().find(".month_"+ ((month * 1) - (1 * 1))).fadeIn(200);
			});
		}
	});

	$(document).on("click", ".calendar .month table tr td", function() {
		calendarNum = $(this).parent().parent().parent().parent().parent().find(".num").html();
		month = $(this).parent().parent().parent().parent().find(".num").html();
		$(actual[calendarNum]).find("span").css({"background": "none", "color": "#514E4E"});
		$(this).find("span").css({"background": "#c0392b", "color": "white"});
		actual[calendarNum] = $(this);
		console.log(month);
		$(".date"+calendarNum).val("2014-"+ month +"-"+ $(this).find("span").html());
	});
});
