<?php
/**
 * Users Controller
 * See Views/Users
 * Login, logout, subscription
 * By: Louis <louis@ne02ptzero.me>
 */


	App::uses('Security', 'Utility');
	class UsersController extends AppController {
		public function		index() {

		}

		/**
		 * Subscription function
		 * Template: Users/sign_up.ctp
		 */
		public function		signUp() {
			if ($this->request->is('post')) {
				$d = $this->request->data;
				if ($d["password"] != $d["passwordConfirmation"]) {
					$this->Session->setFlash("Les deux mots de passe ne correspondent pas !", 'default', array(), 'bad');
				} else {
					$d['id'] = null;
					$d['password'] = Security::hash($d['password'], null, true);
					$d['subscriptionDate'] = date("Y-m-d h:m:s");
					if ($this->User->save($d, true, array("email", "firstName", "lastName", "password", "website", "type", "nickName", "subscriptionDate"))) {
						$this->Session->setFlash("Bienvenue $d[firstName] !", 'default', array(), 'good');
						$this->redirect("/");
					}
				}
			}
		}
	}

?>
