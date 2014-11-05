<?php
/**
 * Users Controller
 * See Views/Users
 * Login, logout, subscription
 * By: Louis <louis@ne02ptzero.me>
 */


	App::uses('Security', 'Utility');
	App::uses('AuthComponent', 'Controller/Component');
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

		/**
		* Login function
		* Template: Users/log_in.ctp
		*/
		public function		logIn() {
			if ($this->request->is('post')) {
				if ($this->Auth->login()) {
					$this->User->id = $this->Auth->user('id');
					$this->User->saveField('lastLoginDate', date(DATE_ATOM));
					$this->Session->setFlash("Bienvenue ".$this->Auth->user('firstName')."!", 'default', array(), 'good');
					$this->redirect('/');
				} else {
					$this->Session->setFlash("Merci de vérifier vos détails de connexion.", 'default', array(), 'bad');
				}
			}
		}

		public function		logOut() {
			$this->Auth->logout();
			$this->Session->setFlash("A la prochaine!", 'default', array(), 'good');
			$this->redirect('/');
		}
	}

?>
