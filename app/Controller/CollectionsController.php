<?php
/**
 * Collection Controller
 * By: Louis <louis@ne02ptzero.me>
 */

class CollectionsController extends AppController {

	public $uses = array("Collection", "Product");

	public function		index() {

	}

	/**
	 * Add a collection function
	 * Template: Collections/add.ctp
	 */
	public function		add($name) {
		$this->Collection->save(array(
			"name" => $name,
			"userId" => AuthComponent::user('id')
		));
		$this->set("id", $this->Collection->getLastInsertId());
	}

	/**
	 * Add a product to a Collection
	 * Template: Collection/add_product.ctp
	 */
	public function		addProduct($productId, $collectionId) {
		$c = $this->Collection->findById($collectionId);
		if ($c["Collection"]["userId"] == AuthComponent::user('id')) {
			$this->Product->id = $productId;
			$this->Product->save(array("collection" => $collectionId));
		}
	}
}
?>
