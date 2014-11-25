<?php
	/**
	 * Admin Panel Controller
	 * By: Louis <louis@ne02ptzero.me>
	 */

	App::uses('AuthComponent', 'Controller/Component');
	class AdminsController extends AppController {

		public $uses = array('Admins', 'Website', 'User');

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
			// Get Creators
			$creators = $this->User->find('all', array(
				"conditions" => array(
					"type" => 1
				)));
			for ($i = 0; isset($creators[$i]); $i++) {
				$c = $creators[$i]["User"];
				$creatorResult[$c["nickName"]] = array("link" => "/ec/Users/edit/$c[id]");
			}

			// Get Websites
			$websites = $this->Website->find('all');
			for ($i = 0; isset($websites[$i]); $i++) {
				$w = $websites[$i]["Website"];
				$websitesResult[utf8_encode($w["name"])] = array("link" => "/ec/Website/edit/$w[id]");
			}
			$websitesResult["Ajouter un site"] = array("link" => "/ec/Admins/addWebsite");
			$this->set('creators', $creatorResult);
			$this->set('websites', $websitesResult);
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
