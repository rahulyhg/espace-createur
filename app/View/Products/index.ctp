<?php
if (isset($menu))
	echo $this->element('Menus/main', array("menu" => $menu)); 
?>
<div class='messageProducts'></div>
<?php if (AuthComponent::user('type')) { ?>
	<div class='delete'>
		<span class='fui-cross'></span>
	</div>
	<div class='more'>
		<span class='fui-plus'></span>
	</div>
	<div class='collections todo'>
		<ul>
			<?php
				for ($i = 0; isset($collections[$i]); $i++) {
					$c = $collections[$i]["Collection"];
					echo "<li name='$c[id]'>";
						echo "<div class='todo-icon fui-plus'></div>";
						echo "<div class='todo-content'>";
							echo "<h4 class='todo-name'>$c[name]</h4>";
						echo "</div>";
					echo "</li>";
				}
			?>
		</ul>
	<button class='btn btn-success'>Ajouter</button>
	</div>
	<div class='selectAll'>
		<span class='fa fa-check-square'></span>
	</div>

<?php } else { ?>
	<div class='addWebsite'>
		<span class='fui-plus'></span>
	</div>
	<div class='websites todo'>
		<ul>
			<?php
				for ($i = 0; isset($websites[$i]); $i++) {
					$w = $websites[$i]["Website"];
					echo "<li name='$w[id]'>";
						echo "<div class='todo-icon fui-exit'></div>";
						echo "<div class='todo-content'>";
							echo "<h4 class='todo-name'>";
								echo utf8_encode($w["name"]);
							echo "</h4>";
							echo $w["url"];
						echo "</div>";
				}
			?>
		</ul>
	<button class='btn btn-success'>Ajouter</button>
	</div>
	<div class='selectAll'>
		<span class='fa fa-check-square'></span>
	</div>
<?php } 
			if (isset($nav)) {
				echo "<div class='subMenu'>";
					echo "<ul>";
						for ($i = 0; isset($nav["collections"][$i]); $i++) {
							$c = $nav["collections"][$i]["Collection"];
							echo "<li>";
								echo "<a href='/ec/Products/viewCollection/$c[id]'>$c[name]</a>";
							echo "</li>";
						}
								foreach ($nav["productSite"] as $key => $value) {
							echo "<li>
									<a href='/ec/Products/viewWebsite/".$userId."/$key'>$value[name]<span class='number'>$value[count]</span></a>
								</li>";
							}
					echo "<li>
								<a href='/ec/Products/productOk/".$userId."'>
									Créations acceptées<span class='number'>$nav[productOk]</span>
								</a>
							</li>
							<li class='last'>
								<a href='/ec/Products/productWait/".$userId."'>
									Créations en attente<span class='number'>$nav[productWait]</span>
								</a>
							</li>";

					echo "</ul>";
				echo "</div>";
			}

?>
<div class='product_list result'>
	<?php	if (isset($title)) {
				echo "<h1>$title</h1>";
			} else { ?>
			<?php if (AuthComponent::user('type') != 0) { ?>
					<h1>Mes Créations</h1>
			<?php } else { ?>
					<h1>Créations</h1>
			<?php } 
				} 
		?>
	<?php 
		echo "<ul>";
		$product = $result;
		for ($i = 0; isset($product[$i]); $i++) {
			$p = $product[$i]['Product'];
			echo "<li class='datFade'>";
			echo "<div class='status'>";
				if ($p["status"] == 1) {
					echo "<i class='fa fa-gavel'></i>";
				} else if ($p) {
					echo "<i class='fa fa-check'></i>";
				}
			echo "</div>";
			echo '<label class="checkbox count" for="checkbox'.$i.'">
					<input class="custom-checkbox countCheckBox" value="'.$p["id"].'" id="checkbox'.$i.'" data-toggle="checkbox" type="checkbox">
					<span class="icons">
						<span class="icon-checked"></span>
						<span class="icon-unchecked"></span>
					</span>
				</label>';
				$img = substr(json_decode($p["img"])[0], 8);
				echo "<img src='$img'><br />";
				if (AuthComponent::user('type') != 0)
					echo "<a href='/ec/Products/edit/$p[id]'><button class='btn btn-success'>Editer</button></a>";
				if (AuthComponent::user('type') == 0)
					echo "<h6>".$p["name"]."<br/><span class='creator'>".$p["creator"]."</span></h6>";
				else
					echo "<h6>".$p["name"]."</h6>";
			echo "</li>";
		}
		echo "</ul>";
		if ($i == 0) {
			if (AuthComponent::user('type'))
				echo "Aucune création ! Si vous voulez en ajouter, merci de clique sur le '+'";
			echo "Aucune création !";
		}
	?>
</div>
