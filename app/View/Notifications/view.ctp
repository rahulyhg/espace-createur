<?php
	/**
	 * Echo input[checkbox] and hidden commentary
	 * @param: name
	 */
	 function	showCommentary($name, $obj) {
		/* checkbox */
			?>
				<label class='checkbox commentaryCheckbox' for="checkbox<?php echo $name?>">
					<input class="custom-checkbox" checked="checked" value="<?php echo $name ?>" id="checkbox<?php echo $name ?>" data-toggle="checkbox" type="checkbox">
					<span class="icons">
						<span class="icon-checked"></span>
						<span class="icon-unchecked"></span>
					</span>
					OK
				</label>
			<?php
			/* Commentary input */
				echo "<div class='form-group commentary commentary$name'>";
					echo $obj->Form->input("commentary$name", array(
						"class" => "form-control",
						"placeholder" => "Commentaire",
						"label" => false
					));
				echo "</div>";
	 }
?>

<div class='viewNotifications'>
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
	} else if ($r["type"] == "newProduct" || $r["type"] == "updateProduct") {
		echo "<h1>Nouvelle Proposition de Création</h1>";
		$p = $product["Product"];
		echo "<h3><strong>Par:</strong> ".$creator["User"]["nickName"]."</h3>";
		?>
		<?php echo $this->Form->create('add'); ?>
			<div class='form-group'>
				<?php echo $this->Form->input('name', array(
					"class" => "form-control notificationInput",
					"label" => "Nom de la création",
					"value" => $p["name"]
				)) ?>
			</div>
			<?php showCommentary("Name", $this); ?>

			<div class='form-group'>
				<?php echo $this->Form->input('description', array(
					"class" => "form-control notificationInput",
					"label" => "Description",
					"value" => $p["description"],
					"type" => "textarea"
				)); ?>
				</div>
				<?php echo showCommentary("Description", $this); ?>

			<?php 
				if ($p["shortDescription"] != $p["description"]) {
			?>
				<div class='form-group'>
					<?php echo $this->Form->input('shortDescription', array(
						"class" => "form-control notificationInput",
						"label" => "Description Minimale",
						"value" => $p["shortDescription"],
						"type" => "textarea"
					)) ?>
				</div>
				<?php echo showCommentary("shortDescription", $this); } ?>

				<div class='form-group'>
					<?php echo $this->Form->input('price', array(
						"class" => "form-control notificationInput",
						"label" => "Prix",
						"value" => $p["price"],
						"type" => "number"
					)) ?>
				</div>
				<?php echo showCommentary("Price", $this) ?>
				<h3>Images</h3>
				<div class='image'>
					<?php
						$img = json_decode($p["img"]);
						echo "<ul>";
						for ($i = 0; isset($img[$i]); $i++) {
							echo "<li>";
								echo "<img src='".substr($img[$i], 8)."'>";
							echo "</li>";
						}
						echo "</ul>";
						showCommentary("Img", $this);
					?>
				</div>
			<button type='submit' name='go' value='go' class='btn btn-success go'>Valider la création</button>
			<button type='submit' name='change' value='change' class='btn btn-inverse change'>Soumettre les changements</button>
		</form>
		<?php
	}
?>
</div>
