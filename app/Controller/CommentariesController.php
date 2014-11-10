<?php
	/**
	 * Commentaries controller
	 * By: Louis <louis@ne02ptzero.me>
	 * Be careful, in this controller we use $this->Commentary
	 */

	 class CommentariesController extends AppController {
		public function		index() {
			print_r($this->Commentary->find('all'));
		}
	 }
?>
