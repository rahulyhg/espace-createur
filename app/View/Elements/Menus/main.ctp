<ul class="side-menu">
<?php if (!isset($menus) || empty($menus)) {
			$menus = $this->requestAction('/menus/index');
	}
	foreach ($menus as $menu):
?>
	<li>
	<?php echo "<a href='#'>".$menu['Collection']['name']."</a>"; ?>
	</li>
<?php endforeach; ?>
</ul>
