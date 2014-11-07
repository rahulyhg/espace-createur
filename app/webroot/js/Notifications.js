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
