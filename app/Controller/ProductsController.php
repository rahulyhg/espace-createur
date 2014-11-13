<?php
	/**
	 * Products Controller
	 * By: Louis <louis@ne02ptzero.me>
	 */

	App::import('Controller', 'Notifications');
	 class		ProductsController extends AppController {

		private $_Notification;
		public $uses = array('User', 'Product', 'Website', 'Commentary', 'Collection');

		public function		beforeFilter() {
			parent::beforeFilter();
			$this->_Notification = new NotificationsController;
		}

		/**
		 * Index view function
		 * Template: Products/index.ctp
		 */
		public function		index() {
			$menu = array(
				"search" => array(
					"class" => "productSearch"
				)
			);
			if (AuthComponent::user('type') != 0) {
				$result = $this->Product->find('all', array(
					"conditions" => array(
						"userId" => AuthComponent::user('id')
					)
				));
				$collections = $this->Collection->find('all', array(
					"conditions" => array(
						"userId" => AuthComponent::user('id')
					)
				));
				$menu["mainMenu"]["Toutes mes créations"] = array("link" => "/ec/Products");
				for ($i = 0; isset($collections[$i]); $i++) {
					$c = $collections[$i]["Collection"];
					$menu["mainMenu"]["Collections"][$c["name"]] = array(
						"link" => "/ec/products/viewCollection/$c[id]"
					);
				}
				if ($i == 0) {
					$menu["mainMenu"]["Collections"]["Pas de collections !"] = array("link" => "#");
				}
			} else {
				$result = $this->Product->find('all');
				for ($i = 0; isset($result[$i]); $i++) {
				   $u = $this->User->findById($result[$i]["Product"]["userId"]);
					$result[$i]["Product"]["creator"] = $u["User"]["nickName"];
					$menu["mainMenu"]["Créateurs"][$u["User"]["nickName"]] = array(
						"link" => "/ec/products/viewCreator/".$u["User"]["id"]
					);
				}
				$this->set('websites', $this->Website->find('all'));
			}
			$this->set("result", $result);
			$this->set("menu", $menu);
		}

		/**
		 * Adding a product to a website
		 * @param: Product id
		 * @param: Website id
		 */
		 public function	addWebsite($productId, $websiteId) {
			if (AuthComponent::user('type') == 0) {
				$website = $this->Website->findById($websiteId);
				$apiCredentials = $website["Website"];
				$api = new Api();
				$api->setApiKeys($apiCredentials);

				$product = $this->Product->findById($productId);
				$product = $product["Product"];
				$img = json_decode($product["img"]);
				for ($i = 0; isset($img[$i]); $i++) {
					$imageData = file_get_contents($img[$i]);
					$img[$i] = array(
						"content" => base64_encode($imageData),
						"mime" => "image/jpeg"
					);
				}
				$product["img"] = $img;
				$api->addProduct($product);
				$api->sendProduct();
				if (!$product["currentWebsite"])
					$website = $websiteId;
				else
					$website .= ",".$websiteId;
				$this->Product->id = $productId;
				$this->Product->saveField('website', $website);
			}
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
					$this->Notification->save(array(
						"type" => "newProduct",
						"userId" => 0,
						"isAdmin" => 1,
						"additionnalInfo" => json_encode(array(
							"productId" => $this->Product->getLastInsertId()
						))
					));
					$this->Session->setFlash("Votre création à bien été sauvegardé !", 'default', array(), 'good');
					$this->redirect('/Products');
				}
			}
		}

		/**
		 * Edit a Product
		 * Template: Products/edit.ctp
		 */
		public function		edit($id) {
			$p = $this->Product->findById($id);
			if ($p["Product"]["userId"] != AuthComponent::user('id')) {
					$this->Session->setFlash("Pardon ?", 'default', array(), 'bad');
					$this->redirect('/Products');
			}
			if ($this->request->is('post')) {
				$d = $this->request->data["edit"];
				$data = array(
					"description" => $d["description"],
					"name" => $d["name"],
					"price" => $d["price"]
				);
				if ($d["img"]["name"] != "") {
					$file = $d["img"];
					$path = $_SERVER['DOCUMENT_ROOT'] .'/ec/app/webroot/files/'.AuthComponent::user('id');
					if (is_dir($path) == false)
						mkdir($path);
					move_uploaded_file($file['tmp_name'], $path."/".$file["name"]);
					$data["img"] = json_encode(array(0 => $path."/".$file["name"]));
				}
				if (isset($d["shortDescription"]))
					$data["shortDescription"] = $d["shortDescription"];
				$this->Product->id = $id;
				if ($this->Product->save($data)) {
					$this->Notification->save(array(
						"type" => "updateProduct",
						"userId" => 0,
						"isAdmin" => 1,
						"additionnalInfo" => json_encode(array(
							"productId" => $id
						))
					));
					$this->Commentary->deleteAll(array("productId" => $id));
					$this->Session->setFlash("Votre produit a bien été mise à jour.", 'default', array(), 'good');
					$this->redirect("/Products");
				}
			}
			$c = $this->Commentary->find('all', array(
				"conditions" => array(
					"productId" => $p["Product"]["id"]
				)
			));
			if (isset($c[0]))
				$this->set("comments", $c);
			$this->set("product", $p);
		}

		/**
		 * View Product by Creator
		 * Template: Products/index.ctp
		 */
		public function		viewCreator($id) {
			if (AuthComponent::user('type') != 0) {
				$this->Session->setFlash("Pardon ?", 'default', array(), 'bad');
				$this->redirect("/Products");
			} else {
				$result = $this->Product->find('all', array(
					"conditions" => array(
						"userId" => $id
					)
				));
				for ($i = 0; isset($result[$i]); $i++) {
				   $u = $this->User->findById($result[$i]["Product"]["userId"]);
					$result[$i]["Product"]["creator"] = $u["User"]["nickName"];
				}
				$this->set("result", $result);
				$this->render('index');
			}
		}

		/**
		 * Search product function
		 * Template: Products/index.ctp
		 */
		public function		search($search) {
			$conditions = array(
				"name LIKE" => "%$search%"
			);
			if (AuthComponent::user('type') != 0)
				$conditions["userId"] = AuthComponent::user('id');
			$result = $this->Product->find('all', array(
				"conditions" => $conditions
			));
			for ($i = 0; isset($result[$i]); $i++) {
				$u = $this->User->findById($result[$i]["Product"]["userId"]);
				$result[$i]["Product"]["creator"] = $u["User"]["nickName"];
			}
			$this->set("result", $result);
			$this->render('index');
		}
	 }
?>
