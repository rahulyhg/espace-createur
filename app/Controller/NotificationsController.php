<?php
	/**
	 * Notifications Controller
	 * By: Louis <louis@ne02ptzero.me>
	 */

	 class		NotificationsController extends AppController {

	 public $uses = array("User", "Commentary", "Product");

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

		 /* Notification treatement */
			if ($this->request->is('post')) {
				$r = $result[0]["Notification"];
				$d = $this->request->data;
				if ($r["type"] == "newProduct" || $r["type"] == "updateProduct") {
				$product = $this->Product->findById(json_decode($r["additionnalInfo"], true)["productId"]);
					if (isset($d["go"])) {
						$this->Product->id = $product["Product"]["id"];
						$this->Product->saveField('status', 2);
						$this->Session->setFlash("La Création a bien été accepté.", 'default', array(), "good");
						$this->Notification->save(array(
							"type" => "productAccepted",
							"userId" => $product["Product"]["userId"],
							"additionnalInfo" => json_encode(array(
								"productId" => $product["Product"]["id"]
							))
						));
						$this->Notification->id = $id;
						$this->Notification->saveField('isDone', 1);
						$this->redirect("/Notifications");
					} else if (isset($d["change"])) {
						foreach ($d["add"] as $k => $v) {
							if ($v == "")
								unset($d["add"][$k]);
						}
						$data = array(
							"productId" => $product["Product"]["id"],
							"userId" => AuthComponent::user('id'),
							"additionnalInfo" => json_encode($d["add"])
						);
						$this->Commentary->save($data);
						$this->Notification->save(array(
							"type" => "productRefused",
							"userId" => $product["Product"]["userId"],
							"additionnalInfo" => json_encode(array(
								"productId" => $product["Product"]["id"]
							))
						));
						$this->Session->setFlash("Vos commentaires ont bien été pris en compte.", 'default', array(), "good");
						$this->Notification->id = $id;
						$this->Notification->saveField('isDone', 1);
						$this->redirect("/Notifications");
					}
				}
			}

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
			} else if ($result[0]["Notification"]["type"] == "newProduct" || $result[0]["Notification"]["type"] == "updateProduct") {
				$product = $this->Product->findById(json_decode($result[0]["Notification"]["additionnalInfo"], true)["productId"]);
				$commentary = $this->Commentary->find('all', array(
					"conditions" => array(
						"productId" => json_decode($result[0]["Notification"]["additionnalInfo"], true)["productId"]
					)
				));
				for ($i = 0; isset($commentary[$i]); $i++) {
					$c = $commentary[$i]["Commentary"];
					$this->User->id = $c["userId"];
					$commentary[$i]["Commentary"]["userInfo"] = $this->User->nickName;
				}
				$this->set("product", $product);
				$this->set("creator", $this->User->findById($product["Product"]["userId"]));
				$this->set("commentary", $commentary);
			} else if ($result[0]["Notification"]["type"] == "productRefused") {
				$this->redirect("/Products/edit/".json_decode($result[0]["Notification"]["additionnalInfo"], true)["productId"]);
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
