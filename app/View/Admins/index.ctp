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
	<div class="list_summary">
		<ul>
			<h1>Websites</h1>
			<?php foreach($websites as $key => $name) {
					echo "<li class='admin_home'>";
					echo "<a href=".$name['link'].">".$key."</a>";
					echo "</li>";
				}
			?>
		</ul>
		<ul>
			<h1>Createurs</h1>
			<?php foreach($creators as $key => $name) {
					echo "<li class='admin_home'>";
					echo "<a href=".$name['link'].">".$key."</a>";
					echo "</li>";
				}
			?>
		</ul>
	</div>
</div>
