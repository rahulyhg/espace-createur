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
		<a href="/ec/Products/add"><span class='fui-plus'></span></a>
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
		<span class='fui fui-loop'></span>
	</div>
<?php } ?>

<?php if (AuthComponent::user('type') != 0) { ?>
	<h1>Mes Créations</h1>
<?php } else { ?>
	<h1>Créations</h1>
<?php } ?>
<div class='product_list result'>
	<?php 
		echo "<ul>";
		$product = $result;
		for ($i = 0; isset($product[$i]); $i++) {
			$p = $product[$i]['Product'];
			echo "<li class='datFade'>";
			echo '<label class="checkbox count" for="checkbox'.$i.'">
					<input class="custom-checkbox countCheckBox" value="'.$p["id"].'" id="checkbox'.$i.'" data-toggle="checkbox" type="checkbox">
					<span class="icons">
						<span class="icon-checked"></span>
						<span class="icon-unchecked"></span>
					</span>
				</label>';
				$img = substr(json_decode($p["img"])[0], 8);
				echo "<img src='$img'><br />";
				echo "<button class='btn btn-success'>Editer</button>";
				if (AuthComponent::user('type') == 0)
					echo "<h6>".$p["name"]."<br/><span class='creator'>".$p["creator"]."</span></h6>";
				else
					echo "<h6>".$p["name"]."</h6>";
			echo "</li>";
		}
		echo "</ul>";
		if ($i == 0)
			echo "Aucune création ! Si c'est vous voulez en ajouter, merci de clique sur le '+'";
	?>
</div>
