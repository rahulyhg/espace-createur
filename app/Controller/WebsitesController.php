<?php
	/**
	 * Websites Controller
	 * By: Louis <louis@ne02ptzero.me>
	 */

	 class		WebsitesController extends AppController {

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
	 }
?>
