<?php
	/**
	 * Products Controller
	 * By: Louis <louis@ne02ptzero.me>
	 */

	App::import('Controller', 'Notifications');
	 class		ProductsController extends AppController {

		private $_Notification;

		public function		beforeFilter() {
			parent::beforeFilter();
			$this->_Notification = new NotificationsController;
		}

		/**
		 * Index view function
		 * Template: Products/index.ctp
		 */
		public function		index() {
			$result = $this->Product->find('all', array(
				"conditions" => array(
					"userId" => AuthComponent::user('id')
				)
			));
			$this->set("result", $result);
   /*         $obj = new Api();*/
			//$obj->setApiKeys(array(
				//"url" => "http://team.emma-chloe.com/Fusiow/index.php",
				//"apiKey" => "ne02ptzero",
				//"apiSecret" => "password",
				//"type" => 1
			/*));*/
			//$obj->addCreatorMagento("Fusiow");
		}

		/**
		 * Add a product function
		 * Template: Products/add.ctp
		 */
		public function		add() {
			if ($this->request->is('post')) {
				$d = $this->request->data['add'];
				$file = $d["img"];
				$d['id'] = NULL;
				$d['userId'] = AuthComponent::user('id');
				if (isset($d["useShortDescription"]))
					$d["shortDescription"] = $d["description"];
				// Upload the file
					$path = $_SERVER['DOCUMENT_ROOT'] .'/ec/app/webroot/files/'.$d['userId'];
					if (is_dir($path) == false)
						mkdir($path);
					move_uploaded_file($file['tmp_name'], $path."/".$file["name"]);
				$d["img"] = json_encode(array(0 => $path."/".$file["name"]));
				$d["addDate"] = date("Y-m-d h:m:s");
				$d["ugs"] = AuthComponent::user('nickName').date("hms");
				if ($this->Product->save($d)) {
					$this->Notification->add(array(
						"type" => "newProduct",
						"userId" => 0,
						"isAdmin" => 1,
						"additionnalInfo" => array(
							"productId" => $this->Product->getLastInsertId()
						)
					));
					$this->Session->setFlash("Votre création à bien été sauvegardé !", 'default', array(), 'good');
					$this->redirect('/Products');
				}
			}
		}
	 }
?>
