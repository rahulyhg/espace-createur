<?php
/**
 * Facture Controller
 * By: Louis <louis@ne02ptzero.me>
 */

class FacturesController extends AppController {

	public $uses = array("Sales", "Product", "Users");

	public function view($salesId = 0) {


		$sales = $this->Sales->findById($salesId)["Sales"];
		if (($sales["creatorId"] == AuthComponent::user('id') || AuthComponent::user('type') == 0) 
			&& $salesId != 0) {
			$product = $this->Product->findById($sales["productId"])["Product"];
			$s = $sales;
			$user = $this->Users->findById($product["userId"])["Users"];
			$infos = json_decode($user["infos"], true);
			foreach ($s as $n => $v) {
				if ($n == "clientInfo" || $n == "addressInfo" || $n == "quoteInfo" || $n == "priceInfo")
					$s[$n] = json_decode($v, true);
			}

			$p = PDF_new();
			if (PDF_begin_document($p, "", "") == 0) {
				die("Error: " . PDF_get_errmsg($p));
			}

			/* Headers */
				PDF_set_info($p, "Creator", "Espace Créateurs");
				PDF_set_info($p, "Author", "Emma & Chloé");
				PDF_set_info($p, "Title", "Facture_$product[name]_".$s["quoteInfo"]["date"]);


			PDF_begin_page_ext($p, 595, 842, "");
			$fontTitle = PDF_load_font($p, "Helvetica-Bold", "winansi", "");
			$font = PDF_load_font($p, "Helvetica", "winansi", "");
			// PDF Header
				PDF_set_text_pos($p, 40, 800);
				PDF_setfont($p, $font, 12.0);
				PDF_show($p, $user["firstName"]." ".$user["lastName"]);
				PDF_continue_text($p, $infos["address"]["street"]);
				PDF_continue_text($p, $infos["address"]["postal"].", ".$infos["address"]["city"]);
				PDF_continue_text($p, $user["email"]);
			// Title
				PDF_set_text_pos($p, 170, 700);
				PDF_setfont($p, $fontTitle, 22.0);
				PDF_show($p, $product["name"]);

			// Table
				//PDF_add_table_cell($p, 0, 1, 1, "lol", nell);
			PDF_end_page_ext($p, "");
			PDF_end_document($p, "");
			$buf = PDF_get_buffer($p);
			$len = strlen($buf);

			/* File headers */
				header("Content-type: application/pdf");
				header("Content-Length: $len");
				header("Content-Disposition: inline; filename=hello.pdf");

			/* Print the PDF */
				print $buf;
				PDF_delete($p);
				die(0);
		} else {
			$this->redirect('/sales');
		}
	}
}
?>
