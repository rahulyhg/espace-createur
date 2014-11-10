<div class='notifications'>
	<h1>Notifications</h1>
	<nav class="navbar navbar-default">
		<div class='collapse navbar-collapse'>
			<ul class="navbar-nav nav">
				<li><a href="/ec/Notifications/index/read">Notifications non lues</a></li>
				<li style='float: right !important'><a href="/ec/Notifications/index/done">Notifications non traitées</a></li>
			</ul>
		</div>
	</nav>
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
						case "productRefused";
							$message = "Votre création a été refusée.";
							$class = "productRefused";
						break;
						case "updateProduct":
							$message = "Un créateur a mis à jour sa création !";
							$class = "updateProduct";
						break;
						case "productAccepted":
							$message = "Votre création a été acceptée !";
							$class = "productAccepted";
						break;
					}
				}
			echo "<li class='list-group-item $class notification$n[id]'>";
				echo "<a href='/ec/Notifications/view/".$n["id"]."'>";
					echo $message;
				echo "</a>";
				if ($n["isRead"] == 0) {
					echo "<span class='right' onclick='markAsRead($n[id])'>";
						echo "<span class='fui-check'></span>";
					echo "</span>";
				}
			echo "</li>";
		}
	?>
	</ul>
	<?php 
		if ($i === 0) {
			echo "<span class='noNew'>Pas de nouvelles Notifications.</span>";
		}
	?>
</div>
