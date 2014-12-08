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
	<div class="list_summary">
		<ul>
			<h1>Websites</h1>
			<li><input type="button" name="add_website" value="Ajouter un website"></li>
		</ul>
		<ul>
				<h1>Dernieres Actions effectuees</h1>
			<li>
				<code>en attendant avant de mettre des log j'ecrit nimplol</code>
			</li>
		</ul>
	</div>
</div>
