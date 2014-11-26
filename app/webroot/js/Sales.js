/**
 * Sales Javascript
 * By: Louis <louis@ne02ptzero.me>
 */
	/**
	 * Change Sale status
	 * @param: Sales id
	 * @param: New status
	 * @param: button
	 */
	function	changeStatus(id, newStatus, button) {
		$(button).find("i").attr("class", "fa fa-circle-o-notch fa-spin");
	   $.ajax({
			url: "/ec/sales/changeStatus/"+ id +"/"+ newStatus,
			async: false
		});
		$(button).find("i").attr("class", "fa fa-check");
		$(".sales" + id).attr("class", "list-group-item status sales "+id+" status"+newStatus);
	}

$(document).ready(function() {
	var current = 0;
	$(".sales .status").on('click', function() {
		var next = 0;
		if (current != 0) {
			$(current).next().slideUp(200);
			if ($(this).find("i").attr('class') == "fa fa-sort-asc") {
				next = 1;
				current = 0;
				$(this).find("i").attr('class', "fa fa-sort-desc");
			}
			$(current).find("i").attr('class', "fa fa-sort-desc");
		}
		if (next == 0) {
			$(this).next().slideDown(200);
			$(this).find("i").attr('class', "fa fa-sort-asc");
			current = $(this);
		}
	});
	$(document).on('click', ".moreInfo", function() {
		url = $(this).attr('href');
		$(".result").html('<div class="wait">Un instant...<br /><i class="fa fa-refresh fa-spin"></i></div>');
		$.ajax({
			url: url,
			success: function(data, status) {
				$(".result").html(data);
			}
		});
		return false;
	});
});
