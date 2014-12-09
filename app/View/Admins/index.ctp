<?php
	$menu = array(
		"search" => false,
		"mainMenu" => array(
			"Accueil" => array(),
			"Sites" => $websites,
			"Créateurs" => $creators
		)
	);
	echo $this->element('Menus/main', array("menu" => $menu));
?>
<div class='adminIndex result'>
<h1>Admin</h1>
</div>
