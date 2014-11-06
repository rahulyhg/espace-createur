<?php
	/**
	 * Admin Panel Controller
	 * By: Louis <louis@ne02ptzero.me>
	 */

	App::uses('AuthComponent', 'Controller/Component');
	class AdminsController extends AppController {

		public function		beforeFilter() {
			parent::beforeFilter();
			if (AuthComponent::user("type") != 0) {
				$this->Session->setFlash("Vous cherchez quelque chose ?", 'default', array(), "bad");
				$this->redirect('/');
			}
		}

		/**
		 * Index function
		 * Template: Admins/index.ctp
		 */
		public function		index() {
			
		}

		/**
		 * Add a website view
		 * Template: Admins/add_website.php
		 * Form for adding the website in: WebsitesController::add
		 */
		public function		addWebsite() {
			
		}
	 }
?>
