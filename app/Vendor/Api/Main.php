<?php
	/**
	 * API Main class
	 * By: Louis <louis@ne02ptzero.me>
	 */

	 /* Magento API require */
		use Magento\Client\Xmlrpc\MagentoXmlrpcClient;

	 class		Api {

	 	/* Protected Variables */
			private		$_product;
			private		$_apiUrl;
			private		$_apiUser;
			private		$_apiKey;
			private		$_apiType;
			private		$_client;

		/**
		 * Construct function
		 * @param: array of the product
		 */
		public function	__construct() {
		}

		/**
		 * Add product
		 * @param: array of the product
		 */
		 public function	addProduct($product) {
			if (!($r = $this->_verifyProduct($product))) {
				$this->_product = $product;
			} else {
				throw new Exception("Le produit est incomplet: $r");
			}
		 }

		/**
		 * Set Api Keys
		 * @param: array
		 */
		public function		setApiKeys($infos) {
			if (isset($infos["url"]) && isset($infos["apiKey"]) && isset($infos["apiSecret"]) && isset($infos["type"])) {
				$this->_apiUrl = $infos["url"];
				$this->_apiUser = $infos["apiKey"];
				$this->_apiKey = $infos["apiSecret"];
				$this->_apiType = $infos["type"];
			} else {
				throw new Exception("Les informations API ne sont pas complètes !");
			}
		}

		 /**
		  * Verify the product informations
		  * @param: array of the product
		  * @return: boolean
		  */
		private function	_verifyProduct($product) {
			$p = $product;
			$error = false;
			$key = array(
				"description",
				"shortDescription",
				"name",
				"ugs",
				"weight",
				"price",
				"img",
				"type",
				"website",
				"currentWebsite",
				"userId",
				"color",
				"size"
			);
			foreach ($key as $k) {
				if (!isset($product[$k]))
					$error .= " $k";
			}
			return $error;
		  }

		/**
		 * Send a product to a website
		 */
		public function		sendProduct() {
			if ($this->_apiType == 1)
				$this->_sendMagentoProduct();
			else
				throw new Exception("La technologie demandée n'est pas supportée");
		}

		/**
		 * Get client Magento
		 */
		private function	_getMagentoClient() {
			$this->_client = MagentoXmlrpcClient::factory(array(
				"base_url" => $this->_apiUrl,
				"api_user" => $this->_apiUser,
				"api_key" => $this->_apiKey
			));
		}

		/**
		 * Send a magento Product
		 */
		private function	_sendMagentoProduct() {
			$this->_getMagentoClient();
			$data = array(
				"name" => $this->_product["name"],
				"websites" => array(5),
				"short_description" => $this->_product["shortDescription"],
				"description" => $this->_product["description"],
				"price" => $this->_product["price"],
				"status" => 1,
				"tax_class_id" => 0,
				"url_key" => $this->_product["ugs"],
				"url_path" => $this->_product["ugs"],
				"visibility" => 4
			);
			$sku = $this->_product["ugs"];
			$store = "shop_view";
			$attribute = 4;
			$type = 'simple';
			$this->_product["id"] = $this->_client->call('catalog_product.create', array($type, $attribute, $sku, $data, $store));
			$this->_addImage();
		}

		/**
		 * Add image to the product
		 */
		 private function	_addImage() {
		 	for ($i = 0; isset($this->_product["img"][$i]); $i++) {
				$result = $this->_client->call('catalog_product_attribute_media.create', array(
					$this->_product["id"],
					array(
						"file" => $this->_product["img"][$i],
						"label" => $this->_product["name"],
						"position" => 100,
							'types' => array('thumbnail', 'small_image', 'image'),
						'exclude' => 0
					)
				));
			}
		 }

		 /**
		  * Add a createur category to magento
		  * @param: Name
		  */
		 public function	addCreatorMagento($name) {
			$this->_getMagentoClient();
			$result = $this->_client->call("catalog_category.create", array(22,
				array(
					"name" => $name,
					"is_active" => 1,
					"is_anchor" => 1,
					"available_sort_by" => 'position',
					'custom_design' => null,
					'custom_apply_to_products' => null,
					'custom_design_from' => null,
					'custom_design_to' => null,
					'custom_layout_update' => null,
					'default_sort_by' => 'position',
					'description' => 'Category description',
					'display_mode' => null,
					'is_anchor' => 0,
					'landing_page' => null,
					'page_layout' => 'one_column',
					'url_key' => $name,
					'include_in_menu' => 0,
					'image' => $name.'.png'
				)
			));
		 }
	 }
?>
