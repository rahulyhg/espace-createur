/**
 * Main JS
 * By: Louis <louis@ne02ptzero.me>
 */

$(document).ready(function () {

	// Fix for Flat-UI focus
	$(document).on('focus', '.form-control', function () {
		$(this).closest('.form-group').addClass('focus');
	}).on('blur', '.form-control', function () {
		$(this).closest('.form-group').removeClass('focus');
	});
});
