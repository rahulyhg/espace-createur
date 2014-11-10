/**
 * Notifications Scripts
 * By: Louis <louis@ne02ptzero.me>
 */

	/**
 	* Mark a notification as Done
 	* @param: int
 	*/
	function	notificationDone(id) {
		$.ajax({
			url: "/ec/Notifications/done/" + id,
			async: false
		});
	}

	/**
	 * Mark a Notification as read
	 * @param: int
	 */
	function	markAsRead(id) {
		$(".notification" + id + " .right").html('<i class="fa fa-circle-o-notch fa-spin"></i>');
		$.ajax({
			url: "/ec/Notifications/read/" + id,
			success: function(data, status) {
				$(".notification" + id).hide(300);
				$(".notification-count").html($(".notification-count").html() - 1);
			}
		});
	}

$(document).ready(function() {
	var		count = 0;
	/**
	 * Commentary show
	 */
	$(".commentaryCheckbox input").on('change', function() {
		var name = $(this).val();
		console.log(".commentary" + name);
		if (this.checked) {
			$(".commentary" + name).hide(200);
			count--;
		} else {
			$(".commentary" + name).show(200);
			count++;
		}
		if (count == 0) {
			$(".go").show(200);
			$(".change").hide(200);
		} else {
			$(".go").hide(200);
			$(".change").show(200);
		}
	});

});
