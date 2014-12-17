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
						if (AuthComponent::user('firstConnection') == 0)
							$this->redirect('/Users/welcome');
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
		 public function	edit($id = 0) {
			if ($this->request->is('post')) {
				$d = $this->request->data["user"];
				$infos = array();
				$pass = $this->User->findById(AuthComponent::user('id'))["User"]["password"];
				if ((isset($d["oldPass"]) && $d["oldPass"] != "") || (!AuthComponent::user('type') && isset($d["newPass1"]))) {
					// Nasty fix for treatment errors
					if (isset($d["oldPass"]))
						$d["oldPass"] = Security::hash($d["oldPass"], null, true);
					else
						$d["oldPass"] = NULL;
					if ($d["oldPass"] != $pass && AuthComponent::user('type'))
						$this->Session->setFlash("Le mot de passe actuel ne correspond pas.", 'default', array(), 'bad');
					else if ($d["newPass1"] != $d["newPass2"])
						$this->Session->setFlash("Le nouveau mot de passe ne correspond pas", 'default', array(), 'bad');
					else
						$d["password"] = Security::hash($d["newPass1"], null, true);
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
				if ($id != 0 && AuthComponent::user('type') == 0)
					$this->User->id = $id;
				else
					$this->User->findById(AuthComponent::user('id'));
				$this->User->save($d);
			}
			if ($id != 0 && AuthComponent::user('type') == 0) {
				$infos = $this->User->findById($id);
			} else {
				$infos = $this->User->findById(AuthComponent::user('id'));
			}
			$infos["User"]["infos"] = json_decode($infos["User"]["infos"], true);
			$this->set("infos", $infos);
		 }

		 /**
		  * Forgot password function
		  */
		 function forgotPassword() {
			if ($this->request->is('post')) {
				$mail = $this->request->data["forgot"]["email"];
				$u = $this->User->find('all', array(
					"conditions" => array(
						"email" => $mail
					)
				));
				if ($u[0]["User"]["id"] && $u[0]["User"]["id"] != 0) {
					// Mail thing
					$this->Session->setFlash("Vous allez recevoir votre nouveau mot de passe par mail !", array(), 'default', 'good');
					$password = Security::hash("password", null, true);
					$this->User->id = $u[0]["User"]["id"];
					$this->User->saveField('password', $password);
				} else {
					$this->Session->setFlash("Aucun compte avec cet email !", array(), 'default', 'bad');
				}
			}
		 }

		 /**
		  * Welcome function
		  * Template: Users/welcome.ctp
		  */
		function 	welcome() {
			if ($this->request->is('post')) {
				$d = $this->request->data["Form"];
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
				if (($this->User->saveField('infos', $d["infos"]))) {
					$this->User->saveField('firstConnection', 1);
					$this->redirect("/?tour");
				}
			}
		}
	}
?>
