/**
 * Main JS
 * By: Louis <louis@ne02ptzero.me>
 */

$(document).ready(function () {

	var current = 0;

	// Fix for Flat-UI focus
	$(document).on('focus', '.form-control', function () {
		$(this).closest('.form-group').addClass('focus');
	}).on('blur', '.form-control', function () {
		$(this).closest('.form-group').removeClass('focus');
	});

	// Fixes on Flat-UI
	$(".todo ul li").on('click', function() {
		var className = $(this).attr('class');
		if ($(this).parent().attr('class') != "dropdownMenu") {
			if (className == undefined || className == "") {
				$(this).addClass("todo-done");
			} else {
				$(this).removeClass("todo-done");
			}
		}
	});

	// Menu
	$(".menuTodo ul li").on('click', function() {
		var className = $(this).attr('class');
		if ($(this).parent().attr('class') != "dropdownMenu") {
			if (className == "todo-done") {
				$(this).find('.dropdownMenu').slideDown(200);
				if (current != 0) {
					current.find('.dropdownMenu').slideUp(200);
					current.removeClass("todo-done");
				}
				current = $(this);
			} else {
				$(this).find('.dropdownMenu').slideUp(200);
				current = 0;
			}
		}
	});

});
