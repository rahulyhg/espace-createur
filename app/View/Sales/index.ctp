<?php
	$menu = array(
		"search" => array(
			"class" => "salesSearch",
			"placeholder" => "Recherche ..."
		),
		"mainMenu" => array(
			"Ventes" => array(
				"Accueil" => array(
					"link" => "#"
				)
			),
			"Factures" => array(
				"Toutes mes factures" => array(
					"link" => "#"
				)
			),
			"Statistiques" => array(
				"Statistiques de Ventes" => array(
					"link" => "#"
				)
			)
		)
	);
	echo $this->element("Menus/main", array("menu" => $menu));
?>
<div class='sales result'>
	<h1 style='text-align: center'>Mes Ventes</h1>
	<canvas id='salesStats' width="500" height="300"></canvas>
	<script>
var data = {
    labels: [
	<?php
			$currentdate = date("d") - 6;
					if ($currentdate < 0)
						$currentdate = 1;
					for ($i = $currentdate; $i <= date("d"); $i++) {
						echo '"'.$i.'"';
						if ($i + 1 <= date("d"))
							echo ",";
					}
?>
],
	    datasets: [
				{
				label: "Ventes",
				fillColor: "#34495e",
				strokeColor: "rgba(220,220,220,1)",
				pointColor: "rgba(220,220,220,1)",
				pointStrokeColor: "#fff",
				pointHighlightFill: "#fff",
				pointHighlightStroke: "rgba(220,220,220,1)",
				data: [
				<?php
					$currentdate = date("d") - 6;
					if ($currentdate < 0)
						$currentdate = 1;
					for ($i = $currentdate; $i <= date("d"); $i++) {
						if (isset($data[$i]))
							echo $data[$i];
						else
							echo "0";
						if ($i + 1 <= date("d"))
							echo ",";
					}
				?>
				]
			} ]};
			// Load Chart.js here, for Ajax calling
	var ctx = $("#salesStats").get(0).getContext("2d");
	var myLineChart = new Chart(ctx).Line(data);
	</script>
	<ul class='list-group main'>
		<?php for ($i = 0; isset($sales[$i]); $i++) {
			$s = $sales[$i]["Sales"];
			$client = json_decode($s["clientInfo"], true);
			$address = json_decode($s["addressInfo"], true);
			$quote = json_decode($s["quoteInfo"], true);
			$img = substr(json_decode($s["img"])[0], 8);
			echo "<li class='list-group-item status status".$s["status"]." sales$s[id]'>";
				echo $s["productName"];
				echo "<span class='right'><i class='fa fa-sort-desc'></i></span>";
			echo "</li>";
			echo "<li class='list-group-item details'>";
			echo "<h5>".$client["firstName"]." ".$client["lastName"]."</h5>";
			echo "<ul>";
				echo "<li class='pic'>";
					echo "<ul>";
						echo "<li>";
								echo "<img src='$img'>";
						echo "</li>";
						echo "<li>";
							echo "<h6>".$s["productName"]."</h6>";
							echo "<strong>Quantité:</strong> ".$quote["qty"]."<br />";
							echo "<strong>Date:</strong> ".$quote["date"];
						echo "</li>";
					echo "</ul>";
				echo "</li>";
				echo "<li>";
			echo "<address>";
				echo "<strong>$address[firstName] $address[lastName]</strong><br>";
				echo "$address[street]<br>
						$address[city], $address[region] $address[postCode]<br>
						<abbr title=\"Mail\"><i class='fa fa-at'></i></abbr> $client[email]
					</address>";
				echo "</li>";
			echo "</ul>";
					if (AuthComponent::user('type')) {
						if ($s["status"] == 0) {
							echo "<button class='btn btn-inverse' onclick='changeStatus(\"".$s['id']."\",\"".($s['status'] + 1)."\", this)'><i class='fa fa-check'></i>Passer en traitement</button>";
						} else if ($s["status"] == 1) {
							echo "<button class='btn btn-success' onclick='changeStatus(\"".$s['id']."\",\"".($s['status'] + 1)."\", this)'><i class='fa fa-truck'></i> Passer en terminée</button>";
						}
					}
					echo "<a class='moreInfo' href='/ec/sales/details/$s[id]'><button class='btn btn-info'><i class='fa fa-info'></i> Voir les détails</button></a>";
					echo "<button class='btn btn-primary'><i class='fa fa-file-pdf-o'></i>Voir la Facture</button>";
			echo "</li>";
		}

		?>
	</ul>
</div>
