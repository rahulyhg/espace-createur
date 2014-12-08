<?php
/**
 * Facture Controller
 * By: Louis <louis@ne02ptzero.me>
 */

class FacturesController extends AppController {

	public $uses = array("Sales", "Product");

	public function view($salesId = 0) {


		$sales = $this->Sales->findById($salesId)["Sales"];
		if (($sales["creatorId"] == AuthComponent::user('id') || AuthComponent::user('type') == 0) 
			&& $salesId != 0) {
			$product = $this->Product->findById($sales["productId"])["Product"];
			$s = $sales;
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
			PDF_set_text_pos($p, 40, 800);
			PDF_setfont($p, $font, 12.0);
			PDF_show($p, "YAY");
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
