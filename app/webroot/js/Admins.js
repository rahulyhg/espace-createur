/**
 * Admin Javascript
 * By: Louis <louis@ne02ptzero.me>
 */

/**
 * Get Information on a website through Ajax
 */
function	getInfos() {
	url = $(".addWebsite .url").val();
	$.ajax({
		url: "/ec/infos/websiteInfo/" + url,
		success: function (result, status) {
			$(".addWebsite .form-group").hide(500);
			$(".addWebsite button").hide(500);
			$(".addWebsite .result").html(result).fadeIn(400);
		}
	});
}
