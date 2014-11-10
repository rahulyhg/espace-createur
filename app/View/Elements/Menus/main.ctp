<?php
	$submenu = array(
		'submenu1',
		'poney2',
		'rickroll',
		);
?>

<div class="col-xs-2">
	<div class="todo menuTodo">
		<ul>
		<?php if (!isset($menus) || empty($menus)) {
				$menus = $this->requestAction('/menus/index');
			}
			foreach ($menus as $menu):
		?>
			<li>
			<?php echo "<a href='#'>".$menu['Collection']['name']."</a>"; ?>
			<ul class='dropdownMenu'>
				<?php foreach ($submenu as $sub): ?>
					<li>
						<?php echo "<a href='#'>".$sub."</a>"; ?>
					</li>
				<?php endforeach; ?>
		</ul>
			</li>
		<?php endforeach; ?>
		</ul>
	</div>
	</div>
