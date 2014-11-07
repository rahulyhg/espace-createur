/**
 * Products Script
 * By: Louis <louis@ne02ptzero.me>
 */

$(document).ready(function() {
	// Check and Unchecked shortDescription
	$('.custom-checkbox').change(function() {
	if (!this.checked)
			$(".addProduct .shortDescription").show(300);
		else
			$(".addProduct .shortDescription").hide(300);
	});
});

$(window).load(function() {
	$(".datFade").each(function(i) {
		$(this).delay(400*i).css({'opacity': 0, 'display': "inline-table"}).animate({'opacity': 1}, 500);
	});
});
