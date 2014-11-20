<?php
/**
 * Sales controller
 * By: Louis <louis@ne02ptzero.me>
 */

class SalesController extends AppController {

	public $uses = array('Sales', 'Website', "Product");

	/**
	 * Get sales function
	 * Template: Sales/get_sales.ctp
	 */
	public function getSales() {
		$website = $this->Website->find('all');
		$apiCredentials = $website[0]["Website"];
		$api = new Api();
		$api->setApiKeys($apiCredentials);
		$result = $api->getMagentoSales();
		foreach ($result as $r) {
			// Base search
			for ($v = 0; isset($r["items"][$v]); $v++) {
				$product = $this->Product->find('all', array(
					"conditions" => array(
						"currentWebsite LIKE " => "%".$r["items"][$v]["product_id"]."%"
					)
				));
				// Verify informations
				if (isset($product[0])) {
					for ($i = 0; isset($product[$i]); $i++) {
						$id = $product[$i]["Product"]["currentWebsite"];
						$id = json_decode($id);
						foreach ($id as $val) {
							if ($val == $r["items"][$v]["product_id"] ) {
								$order = $r;
								$creator = $product[$i]["Product"]["userId"];
							}
						}
					}
					if (isset($order)) {
						// Treat Order
						$data = array(
							"orderId" => $r["order_id"],
							"clientInfo" => json_encode(array(
								"email" => $order["customer_email"],
								"firstName" => $r["customer_firstname"],
								"lastName" => $r["customer_lastname"]
							)),
							"addressInfo" => json_encode(array(
								"street" => $r["shipping_address"]["street"],
								"city" => $r["shipping_address"]["city"],
								"postCode" => $r["shipping_address"]["postcode"],
								"firstName" => $r["shipping_address"]["firstname"],
								"lastName" => $r["shipping_address"]["lastname"],
								"region" => $r["shipping_address"]["region"],
								"company" => $r["shipping_address"]["company"],
								"country" => $r["shipping_address"]["country_id"]
							)),
							"quoteInfo" => json_encode(array(
								"qty" => round($r["items"][$v]["qty_ordered"]),
								"date" => $r["created_at"]
							)),
							"priceInfo" => json_encode(array(
								"basePrice" => $r["items"][$v]["base_price"],
								"tax" => $r["items"][$v]["tax_amount"] + $r["shipping_tax_amount"],
								"final" => $r["items"][$v]["row_total"],
								"discount" => $r["items"][$v]["base_discount_invoiced"],
								"shipping_address" => $r["shipping_invoiced"],
							)),
							"creatorId" => $creator
						);
						$tmp = $this->Sales->find('all', array(
							"conditions" => array(
								"orderId" => $data["orderId"]
						)));
						if (!isset($tmp[0])) {
							$this->Sales->create();
							$this->Sales->save($data);
						}
					}
				}
			}
		}
	}
}
?>
