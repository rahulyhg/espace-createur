<?php
	/**
	 * Notifications Controller
	 * By: Louis <louis@ne02ptzero.me>
	 */

	 class		NotificationsController extends AppController {

	 	/**
		 * Index function
		 * Template: Notifications/index.ctp
		 */
		public function		index() {
			$result = $this->Notification->find('all', array(
				"conditions" => array(
					"isAdmin" => 1,
					"isDone" => 0
				)
			));
			$this->set("notifications", $result);
		}

		/**
		 * View a Notification function
		 * Template: Notifications/view.ctp
		 */
		 public function	view() {
			
		 }

		/**
		 * Add a Notification function
		 * @param: Array of parameters
		 */
		 public function	add($param) {
		 	if (isset($param["additionnalInfo"])) {
				$param["additionnalInfo"] = json_encode($param["additionnalInfo"]);
			}
		 	$this->Notification->save($param);
		 }
	 }
?>
