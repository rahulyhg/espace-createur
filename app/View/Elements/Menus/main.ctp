<div class="col-xs-2">
	<div class="todo menuTodo">
		<div class="todo-search">
		<?php
			// Search form
			if ($menu["search"] != false) {
				$class = "todo-search-field";
				$placeholder = "Recherche ..";
				if (isset($menu["search"]["class"]))
					$class .= " ".$menu["search"]["class"];
				if (isset($menu["search"]["placeholder"]))
					$placeholder = $menu["search"]["placeholder"];
				echo "<input class='$class' type='search' placeholder='$placeholder'>";
			}
		?>
		</div>
		<ul class='mainUl'>
		<?php 
			// Main Menu
			foreach ($menu["mainMenu"] as $name => $val) {
				echo "<li>";
					echo "<a href='#'>".$name."<span class='fui fui-triangle-down'></span></a>";
					echo "<ul class='dropdownMenu'>";
					foreach ($val as $subMenu => $infos) {
						echo "<li>";
							echo "<a href='$infos[link]'>$subMenu</a>";
						echo "</li>";
					}
					echo "</ul>";
				echo "</li>";
			}
		?>
	</div>
</div>
