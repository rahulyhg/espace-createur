<?php

class TicketsController extends AppController {

	public function index() {
		$menu = array(
			"search" => array(
				"class" => "ticketSearch"
				)
			);
		$tickets = $this->Ticket->find('all', array(
			"conditions" => array(
				"user_id" => AuthComponent::user('id')
			)
		));
	}

}
