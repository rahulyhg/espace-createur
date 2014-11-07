<div class='more'>
	<a href="/ec/Products/add"><span class='fui-plus'></span></a>
</div>
<h1>Mes Créations</h1>
<div class='product_list'>
	<?php 
		echo "<ul>";
		$product = $result;
		for ($i = 0; isset($product[$i]); $i++) {
			$p = $product[$i]['Product'];
			echo "<li class='datFade'>";
				$img = substr(json_decode($p["img"])[0], 8);
				echo "<img src='$img'><br />";
				echo "<h6>".$p["name"]."</h6>";
			echo "</li>";
		}
		echo "</ul>";
		if ($i == 0)
			echo "Aucune création ! Si c'est vous voulez en ajouter, merci de clique sur le '+'";
	?>
</div>
