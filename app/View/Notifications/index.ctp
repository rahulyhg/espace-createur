<div class='notifications'>
	<h1>Notifications</h1>
	<ul class='list-group'>
	<?php
		for ($i = 0; isset($notifications[$i]); $i++) {
			$n = $notifications[$i]['Notification'];
				if ($n["message"])
					$message = $n["message"];
				else {
					switch ($n["type"]) {
						case "new_user": 
							$message = "Un Nouveau créateur veut s'inscrire !";
							$class = "newUser";
						break;
						case "newProduct":
							$message = "Un créateur a ajouté un nouveau produit";
							$class = "newProduct";
						break;
					}
				}
			echo "<li class='list-group-item $class'>";
				echo "<a href='/ec/Notifications/view/".$n["id"]."'>";
					echo $message;
				echo "</a>";
			echo "</li>";
		}
	?>
	</ul>
	<?php 
		if ($i === 0) {
			echo "Pas de nouvelles Notifications.";
		}
	?>
</div>
