<?php
/**
 * Users Controller
 * See Views/Users
 * Login, logout, subscription
 * By: Louis <louis@ne02ptzero.me>
 */


	App::uses('Security', 'Utility');
	App::uses('AuthComponent', 'Controller/Component');
	//App::import('Controller', 'Notifications');
	class UsersController extends AppController {

		private $_Notification;
		public $uses = array("Notification", "User");

		public function		beforeFilter() {
			parent::beforeFilter();
			//$this->_Notification = new NotificationsController;
		}

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
						$this->Session->setFlash("Votre inscription à bien été prise en compte !", 'default', array(), 'good');
						$this->Notification->save(array(
							"type" => "new_user",
							"userId" => 0,
							"isAdmin" => 1,
							"additionnalInfo" => json_encode(array(
								"userId" => $this->User->getLastInsertId()
							))));
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
					if ($this->Auth->user('isConfirmed') == 1) {
						$this->User->saveField('lastLoginDate', date(DATE_ATOM));
						$this->Session->setFlash("Bienvenue ".$this->Auth->user('firstName')."!", 'default', array(), 'good');
						$this->redirect('/');
					} else {
						$this->Session->setFlash("Votre compte n'a pas été encore accepté.", 'default', array(), 'bad');
						$this->Auth->logout();
					}
				} else {
					$this->Session->setFlash("Merci de vérifier vos détails de connexion.", 'default', array(), 'bad');
				}
			}
		}

		/**
		 * LogOut function
		 */
		public function		logOut() {
			$this->Auth->logout();
			$this->Session->setFlash("A la prochaine!", 'default', array(), 'good');
			$this->redirect('/');
		}

		/**
		 * Delete User function
		 */
		public function		delete($id) {
			if (AuthComponent::user('type') != 0) {
				$this->Session->setFlash("Vous essayez de faire un truc là ?", 'default', array(), 'bad');
				$this->redirect('/');
			} else {
				$this->User->delete($id);
				$this->Session->setFlash("L'utilisateur à bien été supprimé.", 'default', array(), 'good');
				$this->redirect($this->referer());
			}
		}

		/**
		 * Accept User function
		 */
		 public function	accept($id) {
			if (AuthComponent::user('type') != 0) {
				$this->Session->setFlash("Vous essayez de faire un truc là ?", 'default', array(), 'bad');
				$this->redirect('/');
			} else {
				$this->User->id = $id;
				$this->User->saveField('isConfirmed', 1);
				$this->Session->setFlash("L'utilisateur a bien été accepté.", 'default', array(), 'good');
				$this->redirect($this->referer());
			}
		 }

		 /**
		  * Edit profile
		  */
		 public function	edit() {
			if ($this->request->is('post')) {
				$d = $this->request->data["user"];
				print_r($d);
				$infos = array();
				$pass = $this->User->findById(AuthComponent::user('id'))["User"]["password"];
				if ($d["oldPass"] != "") {
					$d["oldPass"] = Security::hash($d["oldPass"], null, true);
					if ($d["oldPass"] != $pass)
						$this->Session->setFlash("Le mot de passe actuel ne correspond pas.", 'default', array(), 'bad');
					else if ($d["newPass1"] != $d["newPass2"])
						$this->Session->setFlash("Le nouveau mot de passe ne correspond pas", 'default', array(), 'bad');
					else
						$d["password"] = Security::hash($d["newPass1"]);
				}
				if ($d["img"]["size"] != 0) {
					// Upload the file
					$path = $_SERVER['DOCUMENT_ROOT'] .'/ec/app/webroot/files/'.AuthComponent::user('id');
					if (is_dir($path) == false)
						mkdir($path);
					move_uploaded_file($d["img"]['tmp_name'], $path."/".$d["img"]["name"]);
					$infos["img"] = array(
						0 => $path."/".$d["img"]["name"]
					);
				}
				$infos["address"] = array(
					"street" => $d["infosStreet"],
					"city" => $d["infosCity"],
					"postal" => $d["infosPostal"]
				);
				$d["infos"] = json_encode($infos);
				$this->User->id = AuthComponent::user('id');
				$this->User->save($d);
			}
			$infos = $this->User->findById(AuthComponent::user('id'));
			$infos["User"]["infos"] = json_decode($infos["User"]["infos"], true);
			$this->set("infos", $infos);
		 }
	}
?>
