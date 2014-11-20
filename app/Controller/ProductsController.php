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
				$this->set("collections", $collections);
				$menu["mainMenu"]["Ajouter un produit"] = array("link" => "/ec/Products/add");
				for ($productOk = 0, $productWait = 0, $i = 0; isset($result[$i]); $i++) {
					if ($result[$i]["Product"]["status"] == 1)
						$productWait++;
					else
						$productOk++;
				}
				$menu["mainMenu"]["Toutes mes créations"] = array(
					"Toutes" => array(
						"link" => "/ec/products/",
						"left" => $productOk + $productWait,
						"leftClass" => ""
					),
					"Créations acceptées" => array(
						"link" => "/ec/Products/productOk",
						"left" => $productOk,
						"leftClass" => ""
					),
					"Créations non validées" => array(
						"link" => "/ec/Products/productWait",
						"left" => $productWait,
						"leftClass" => ""
					)
				);
				$menu["mainMenu"]["Collections"]["addCollection"] = array(
					"input" => true,
					"class" => "addCollection",
					"placeholder" => "Ajouter une collection..",
					"icon" => "fui-plus"
				);
				for ($i = 0; isset($collections[$i]); $i++) {
					$c = $collections[$i]["Collection"];
					$count = $this->Product->find('count', array(
						"conditions" => array(
							"collection" => $c["id"]
						)
					));
					$menu["mainMenu"]["Collections"][$c["name"]] = array(
						"link" => "/ec/products/viewCollection/$c[id]",
						"left" => $count,
						"leftClass" => "collectionId$c[id]"
					);
				}
				} else {
				$result = $this->Product->find('all');
				$menu["mainMenu"]["Créations"] = array(
					"Toutes" => array(
						"link" => "/ec/products"
					)
				);
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
				$id = $api->sendProduct();
				if (!$product["website"])
					$website = $websiteId;
				else
					$website .= ",".$websiteId;
				if (!$product["currentWebsite"]) {
					$id = json_encode(array($websiteId => $id));
				} else {
					$tmp = json_decode($p["currentWebsite"]);
					$tmp[$websiteId] = $id;
					$id = json_encode($tmp);
				}
				$this->Product->id = $productId;
				$this->Product->saveField('website', $website);
				$this->Product->saveField('currentWebsite', $id);
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
					"price" => $d["price"],
					"status" => 1
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
				$collection = $this->Collection->find('all', array(
					"conditions" => array(
						"userId" => $id
					)
				));
				for ($productSite = array(), $productWait = 0, $productOk = 0, $i = 0; isset($result[$i]); $i++) {
					$u = $this->User->findById($result[$i]["Product"]["userId"]);
					$name = $result[$i]["Product"]["creator"] = $u["User"]["nickName"];
					if ($result[$i]["Product"]["status"] == 1)
						$productWait++;
					else
						$productOk++;
					if ($result[$i]["Product"]["website"])
						$productSite[$result[$i]["Product"]["website"]]++;
				}
				foreach ($productSite as $key => $value) {
					$nameSite = $this->Website->findById($key)["Website"]["name"];
					$productSite[$key] = array(
						"name" => utf8_encode($nameSite),
						"count" => $value
					);
				}
				$nav = array(
					"collections" => $collection,
					"productWait" => $productWait,
					"productOk" => $productOk,
					"productSite" => $productSite
				);
				$this->set("nav", $nav);
				$this->set("result", $result);
				$this->set("userId", $id);
				if (isset($name))
					$this->set("title", $name);
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

		/**
		 * View Collection function
		 * Template: Products/index.ctp
		 */
		public function		viewCollection($id) {
			$result = $this->Product->find('all', array(
				"conditions" => array(
					"userId" => AuthComponent::user('id'),
					"collection" => $id
				)
			));
			for ($i = 0; isset($result[$i]); $i++) {
				$u = $this->User->findById($result[$i]["Product"]["userId"]);
				$result[$i]["Product"]["creator"] = $u["User"]["nickName"];
			}
			$this->set("result", $result);
			$this->set("title", $this->Collection->findById($id)["Collection"]["name"]);
			$this->render('index');
		}

		/**
		 * Validate Product
		 * Template: Products/index.ctp
		 */
		function		productOk($id = 0) {
			if ($id == 0)
				$id = AuthComponent::user('id');
			$result = $this->Product->find('all', array(
				"conditions" => array(
					"userId" => $id,
					"status" => 2
				)
			));
			for ($i = 0; isset($result[$i]); $i++) {
				$u = $this->User->findById($result[$i]["Product"]["userId"]);
				$result[$i]["Product"]["creator"] = $u["User"]["nickName"];
			}
			$this->set("result", $result);
			$this->set("title", "Créations acceptées");
			$this->render('index');
		}

		/**
		 * Wait Product
		 * Template: Products/index.ctp
		 */
		function		productWait($id = 0) {
			if ($id == 0)
				$id = AuthComponent::user('id');
			$result = $this->Product->find('all', array(
				"conditions" => array(
					"userId" => $id,
					"status" => 1
				)
			));
			for ($i = 0; isset($result[$i]); $i++) {
				$u = $this->User->findById($result[$i]["Product"]["userId"]);
				$result[$i]["Product"]["creator"] = $u["User"]["nickName"];
			}
			$this->set("result", $result);
			$this->set("title", "Créations en attente de Validation");
			$this->render('index');
		}

		/**
		 * view Product by Website
		 * Template: Products/index.ctp
		 */
		function	viewWebsite($userId, $websiteId) {
			$result = $this->Product->find('all', array(
				"conditions" => array(
					"userId" => $userId,
					"website LIKE" => "%$websiteId%"
				)
			));
			for ($i = 0; isset($result[$i]); $i++) {
				$u = $this->User->findById($result[$i]["Product"]["userId"]);
				$result[$i]["Product"]["creator"] = $u["User"]["nickName"];
			}
			$this->set("result", $result);
			$this->set("title", "Créations en attente de Validation");
			$this->render('index');
		}

	 }
?>
