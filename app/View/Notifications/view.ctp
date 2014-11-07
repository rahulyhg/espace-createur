<?php
	$r = $result[0]["Notification"];
	if ($r["type"] == "new_user") {
		$u = $userInfo[0]["User"];
		echo "<h1>Nouveau Créateur</h1>";
		echo "<h3>".$u["firstName"]." ".$u["lastName"]."</h3>";
		echo "<h5>".$u["email"]."</h5>";
		echo "<a href='$u[website]'>$u[nickName]</a>";
		echo "<br />";
		echo "<a href='/ec/users/accept/$u[id]' onclick='notificationDone($r[id])'>
				<button class='btn btn-success'>Accepter ce Créateur</button>
				</a>";
		echo "<a href='/ec/users/delete/$u[id]' onclick='notificationDone($r[id])'>
				<button class='btn btn-danger' style='margin-left: 10px'>Refuser ce Créateur</button>
			</a>";
	}
?>
