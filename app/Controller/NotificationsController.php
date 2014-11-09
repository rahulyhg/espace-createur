<?php
	/**
	 * Notifications Controller
	 * By: Louis <louis@ne02ptzero.me>
	 */

	 class		NotificationsController extends AppController {

	 public $uses = array("User");

	 	/**
		 * Index function
		 * @param: string
		 * Template: Notifications/index.ctp
		 */
		public function		index($str = "all") {
			$conditions = array();
			if ($str == "read") {
				$conditions["isRead"] = 0;
			} else {
				$conditions["isDone"] = 0;
			}
			if (AuthComponent::user('type') == 0)
				$conditions["isAdmin"] = 1;
			else
				$conditions["userId"] = AuthComponent::user('id');
			$result = $this->Notification->find('all', array(
				"conditions" => $conditions
			));
			$this->set("notifications", $result);
		}

		/**
		 * View a Notification function
		 * Template: Notifications/view.ctp
		 */
		 public function	view($id) {
			$result = $this->Notification->find('all', array(
				"conditions" => array(
					"id" => $id
				)
			));

			// Mark as read
			$this->Notification->id = $id;
			$this->Notification->saveField('isRead', 1);

			if ($result[0]["Notification"]["type"] == "new_user") {
				$user = $this->User->find('all', array(
					"conditions" => array(
						"id" => json_decode($result[0]["Notification"]["additionnalInfo"], true)["userId"]
					)
				));
				$this->set("userInfo", $user);
			}
			$this->set("result", $result);
		 }

		/**
		 * Add a Notification function
		 * @param: Array of parameters
		 */
		 public function	addNotification($param) {
		 	if (isset($param["additionnalInfo"])) {
				$param["additionnalInfo"] = json_encode($param["additionnalInfo"]);
			}
		 	$this->Notification->save($param);
		 }

		 /**
		  * Mark a Notification as done
		  */
		 public function	done($id) {
			$this->Notification->id = $id;
			$this->Notification->saveField('isDone', 1);
		 }

		/**
		 * Mark a Notification as read
		 */
		public function		read($id) {
			$this->Notification->id = $id;
			$this->Notification->saveField('isRead', 1);
			$this->header('HTTP/1.1 200 OK');
			exit;
		 }
	 }
?>
