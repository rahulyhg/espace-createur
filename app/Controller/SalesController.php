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
								$creator = $product[$i]["Product"];
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
							"creatorId" => $creator["userId"],
							"productId" => $creator["id"]
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

	/**
	 * Index function
	 * Template: Sales/index.ctp
	 */
	function	index() {
		if (AuthComponent::user('type')) {
			$sales = $this->Sales->find('all', array(
				"conditions" => array(
					"creatorId" => AuthComponent::user('id')
				),
				"limit" => 5,
				"order" => array(
					"id DESC"
				)
			));
		} else {
			$sales = $this->Sales->find('all', array(
				"conditions" => array(
					"status" => 0
				),
				"limit" => 5,
				"order" => array(
					"id DESC"
				)
			));
		}
		for ($i = 0, $data = array(); isset($sales[$i]); $i++) {
			$s = $sales[$i]["Sales"];
			$date = json_decode($s["quoteInfo"], true)["date"];
			$p = $this->Product->findById($s["productId"]);
			$sales[$i]["Sales"]["productName"] = $p["Product"]["name"];
			$sales[$i]["Sales"]["img"] = $p["Product"]["img"];
			$date = explode('-', explode(' ', $date)[0]);
			if ($date[0] == date("Y") && $date[1] == date("m")) {
				if (!isset($data[$date[2]]))
					$data[$date[2]] = 0;
				$data[$date[2]] += 1;
			}
		}
		$this->set('sales', $sales);
		$this->set('data', $data);
	}

	/**
	 * Change the status of the command
	 */
	public	function	changeStatus($salesId, $newStatus) {
		$product = $this->Sales->findById($salesId);
		if ($product["Sales"]["creatorId"] == AuthComponent::user('id')) {
			$this->Sales->id = $salesId;
			$this->Sales->saveField("status", $newStatus);
		}
	}

	/**
	 * Sales details function
	 * Template: Sales/details.ctp
	 */
	public function		details($id) {
		$s = $this->Sales->findById($id);
		if (AuthComponent::user('id') != $s["Sales"]["creatorId"] && AuthComponent::user('type')) {
			$this->redirect("/sales");
		} else {
			$s = $s["Sales"];
			foreach ($s as $n => $v) {
				if ($n == "clientInfo" || $n == "addressInfo" || $n == "quoteInfo" || $n == "priceInfo")
					$s[$n] = json_decode($v, true);
			}
			$p = $this->Product->findById($s["productId"]);
			$this->set("product", $p["Product"]);
			$this->set("sales", $s);
		}
	}

	/**
	 * Export function
	 * Template: Sales/export.ctp
	 */
	public function		export($type = 0) {
		$sales = $this->Sales->find('all', array(
			"conditions" => array(
				"creatorId" => AuthComponent::user('id')
			)
		));

		$d = $this->request->data;
		if (isset($d["date"])) {
			$type = 4;
			$requestDate[0] = explode("-", $d["date"]["date1"]);
			$requestDate[1] = explode("-", $d["date"]["date2"]);
		}
		for ($i = 0; isset($sales[$i]["Sales"]); $i++) {
			$date = json_decode($sales[$i]["Sales"]["quoteInfo"], true);
			$date = explode('-', $date["date"]);
			$date[2] = explode(' ', $date[2])[0];
			if ($type == 2 && $date[1] == date('m')) {
				$result[] = $sales[$i]["Sales"];
			} else if ($type == 3 && $date[2] == date('d')) {
				$result[] = $sales[$i]["Sales"];
			} else if ($type == 1) {
				$result[] = $sales[$i]["Sales"];
			} else if ($type == 4) {
				if ($date[1] >= $requestDate[0][1]) {
					if ($date[1] == $requestDate[0][1]) {
						if ($date[2] >= $requestDate[0][2])
							$result[] = $sales[$i]["Sales"];
					} else {
						if ($date[1] <= $requestDate[1][1]) {
							if ($date[1] == $requestDate[1][1]) {
								if ($date[2] <= $requestDate[1][2])
									$result[] = $sales[$i]["Sales"];
							} else {
								$result[] = $sales[$i]["Sales"];
							}
						}
					}
				}
			}
		}

		if (isset($result)) {
			echo "orderId,productId,productName,qty,date,price,firstName,lastName,email,shippingFirstName,shippingLastName,street,city,zip,country\n";
			foreach ($result as $r) {
				$address = json_decode($r["addressInfo"], true);
				$clientInfo = json_decode($r["clientInfo"], true);
				$quote = json_decode($r["quoteInfo"], true);
				$price = json_decode($r["priceInfo"], true);
				$product = $this->Product->findById($r["productId"])["Product"];
				echo '"'.$r["orderId"].'","'.$product["id"].'","'.$product["name"].'","'.$quote["qty"].'","'.$quote["date"].'","'.$product["price"].'","'.$clientInfo["firstName"].'","'.$clientInfo["lastName"].'","'.$clientInfo["email"].'", "'.$address["firstName"].'", "'.$address["lastName"].'","'.$address["street"].'", "'.$address["city"].'", "'.$address["postCode"].'", "'.$address["country"].'"'."\n";
			}
			header("Content-type: text/csv");
			header("Content-Disposition: attachment; filename=ventes(".date("m-d_h:m").").csv");
			header("Pragma: no-cache");
			header("Expires: 0");
			die(0);
		}
	}
}
?>
