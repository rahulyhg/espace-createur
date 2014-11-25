/**
 * Admin Javascript
 * By: Louis <louis@ne02ptzero.me>
 */

/**
 * Get Information on a website through Ajax
 */
function	getInfos() {
	url = $(".addWebsiteForm .url").val();
	$.ajax({
		url: "/ec/infos/websiteInfo/" + url,
		success: function (result, status) {
			$(".addWebsiteFormm .form-group").hide(500);
			$(".addWebsiteForm button").hide(500);
			$(".addWebsiteForm .resultWebsite").html(result).fadeIn(400);
		}
	});
}
