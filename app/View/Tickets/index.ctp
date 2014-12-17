<?php
	$menu = array(
		"search" => true,
		"mainMenu" => array(
			"Ticket" => $newticket,
		));
	echo $this->element('Menus/main', array("menu" => $menu));
?>

<div class="ticketIndex">
	<h1>Ticket</h1>
	<div>while ticket de l'user,afficher ticket</div>
</div>
