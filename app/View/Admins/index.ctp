<?php
	$menu = array(
		"search" => false,
		"mainMenu" => array(
			"Sites" => $websites,
			"Créateurs" => $creators
		)
	);
	echo $this->element('Menus/main', array("menu" => $menu));
?>
<div class='adminIndex'>

</div>
