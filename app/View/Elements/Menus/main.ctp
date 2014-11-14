<div class="col-xs-2">
	<div class="todo menuTodo">
		<?php
			// Search form
			if ($menu["search"] != false) {
				echo '<div class="todo-search">';
					$class = "todo-search-field";
					$placeholder = "Recherche ..";
					if (isset($menu["search"]["class"]))
						$class .= " ".$menu["search"]["class"];
					if (isset($menu["search"]["placeholder"]))
						$placeholder = $menu["search"]["placeholder"];
					echo "<input class='$class' type='search' placeholder='$placeholder'>";
				echo "</div>";
			}
		?>
		<ul class='mainUl'>
		<?php 
			// Main Menu
			foreach ($menu["mainMenu"] as $name => $val) {
				echo "<li>";
					if (!isset($val["link"])) {
						echo "<a href='#'>".$name;
						echo "<span class='fui fui-triangle-down'></span>";
					} else {
						echo "<a href='$val[link]'>$name";
					}
					echo "</a>";
					if (!isset($val["link"])) {
						echo "<ul class='dropdownMenu'>";
						foreach ($val as $subMenu => $infos) {
							echo "<li>";
							if (isset($infos["input"]) && $infos["input"] == 1) {
								echo "<input type='text' class='$infos[class]' placeholder='$infos[placeholder]'><span class='$infos[icon]'></span>";
							} else {
								echo "<a href='$infos[link]'>$subMenu";
								if (isset($infos["left"])) {
									echo "<span class='left $infos[leftClass]'>$infos[left]</span>";
								}
								echo "</a>";
							}
							echo "</li>";
						}
						echo "</ul>";
					}
				echo "</li>";
			}
		?>
	</div>
</div>
