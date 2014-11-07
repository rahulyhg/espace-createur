<?php

class MenusController extends AppController {
	public $name = 'Menus';
	public $uses = array('Collection');

	function index() {
		if (isset($this->params['requested']) && $this->params['requested'] == true) {
			$Menus = $this->Collection->find('all');
			return $Menus;
		} else {
			$this->set('menus', $this->Collection->find('all'));
		}
	}

	function add() {
		if (!empty($this->data)) {
			if ($this->Collection->save($this->data)) {
				$this->Session->setFlash(__('Le sous-menu a bien ete ajoute', true));
			}
		}
	}
}
