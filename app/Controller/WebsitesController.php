<?php
	/**
	 * Websites Controller
	 * By: Louis <louis@ne02ptzero.me>
	 */

	 class		WebsitesController extends AppController {

		public function		beforeFilter() {
			parent::beforeFilter();
			if (AuthComponent::user('type'))
				$this->redirect("/");
		}

	 	/**
		 * Add a Website function
		 */
		public function		add() {
			if ($this->request->is('post')) {
				$d = $this->request->data;
				$d['id'] = null;
				if ($this->Website->save($d, true, array("url", "name", "type", "apiUrl", "apiKey", "apiSecret"))) {
					$this->Session->setFlash("Le site a bien été ajouté !", 'default', array(), 'good');
					$this->redirect("/admins");
				}
			}
		}

		/**
		 * Edit a website function
		 * Template: Websites/edit.ctp
		 */
		function	edit($id) {
			if ($this->request->is('post')) {
				$d = $this->request->data["edit"];
				$this->Website->id = $id;
				$this->Website->save($d);
			}
			$website = $this->Website->findById($id);
			$this->set("infos", $website["Website"]);
		}
	 }
?>
