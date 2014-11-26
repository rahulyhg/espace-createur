<div class='detailsPage'>
<a href='/ec/sales'><button class='btn btn-success'><i class='fa fa-chevron-left'></i> Retour </button></a>
<?php
	$img = substr(json_decode($product["img"])[0], 8);
	echo "<h1>".$product["name"]."</h1>";
	echo "<img src='".$img."'><br />";
	echo "<i>".$product["description"]."</i>";
	echo "<h3>Détails</h3>";
	$price = $sales["priceInfo"];
	echo "<table class='price'>";
		echo "<tr>";
			echo "<td class='title'>".$product["name"]."</td>";
			echo "<td>".$price["basePrice"]." €</td>";
		echo "</tr><tr>";
			echo "<td class='title'>frais de ports</td>";
			echo "<td>".$price["shipping_address"]." €</td>";
		echo "</tr><tr class='bigTitle'>";
			echo "<td class='title'>Total H.t</td>";
			echo "<td>".($price["basePrice"] + $price["shipping_address"])." €</td>";
		echo "</tr><tr>";
			echo "<td class='title'>Taxes</td>";
			echo "<td>".$price["tax"]." €</td>";
		echo "</tr>";
			if (isset($price["discount"]) && $price["discount"] != "") {
				echo "<tr><td class='title'>Réduction</td>";
				echo "<td>-".$price["discount"]." €</td></tr>";
			}
		echo "<tr class='bigTitle'>";
			echo "<td class='title'>Total t.t.c</td>";
			$total = $price["basePrice"] + $price["shipping_address"] + $price["tax"];
			if (isset($price["discount"]) && $price["discount"] != "")
				$total -= $price["discount"];
			echo "<td>$total €</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td class='title'>Commission</td>";
			$com = $total * (AuthComponent::user('creator_com') / 100);
			echo "<td>-".$com." €</td>";
		echo "</tr>";
		echo "<tr class='veryBigTitle bigTitle'>";
			echo "<td class='title'>total final</td>";
			echo "<td>".($total - $com)." €</td>";
		echo "</tr>";
	echo "</table>";
	echo "<h3>Adresse</h3>";
	$address = $sales["addressInfo"];
	$client = $sales["clientInfo"];
	echo "<address>";
		echo "$address[street]<br>
				$address[city], $address[region] $address[postCode]<br>
		</address>";
?>
</div>
