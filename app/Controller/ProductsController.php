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
			$obj = new Api();
			$obj->setApiKeys(array(
				"url" => "http://team.emma-chloe.com/Fusiow/index.php",
				"apiKey" => "ne02ptzero",
				"apiSecret" => "password",
				"type" => 1
			));
			//$obj->addCreatorMagento("Fusiow");
		}
	 }
?>
