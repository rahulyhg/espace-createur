<?php
	function	displayInput($name, $product, $commentary, $obj) {
		$class = "form-group";
		$inputClass = array(
			"class" => "form-control",
			"label" => false,
			"value" => $product[$name]
		);
		if ($name == "description" || $name == "shortDescription")
			$inputClass["type"] = "textarea";
		else if ($name == "price")
			$inputClass["type"] = "number";
		else if ($name == "img")
			$inputClass["type"] = "file";
		if (isset($commentary["commentary".ucfirst($name)])) {
			$class .= " has-error";
			$inputClass["label"] = $commentary["commentary".ucfirst($name)];
			$inputClass["div"] = array("class" => "gotError");
		} else {
			$class .= " has-success";
		}
		echo "<h4>";
			switch ($name) {
				case "name": echo "Nom de la création"; break;
				case "description": echo "Description"; break;
				case "shortDescription": echo "Description minimale"; break;
				case "price": echo "Prix"; break;
				case "img": echo "Images"; break;
			}
		echo "</h4>";
		echo "<div class='$class'>";
			echo "<ul>";
				echo "<li>";
					if ($name == "img")
						echo "<img src='".substr(json_decode($product["img"])[0], 8)."'>";
					echo $obj->Form->input($name, $inputClass);
				echo "</li>";
			if ($inputClass["label"] != false && $name != "img" && $commentary[$name] != $product[$name]) {
				$correctionClass = array(
					"class" => "form-control",
					"value" => $commentary[$name],
					"readonly",
					"label" => "Correction proposée"
				);
				if (isset($inputClass["type"]))
					$correctionClass["type"] = $inputClass["type"];
				echo "<li>";
					echo $obj->Form->input($name."Correction", $correctionClass);
				echo "</li>";
			}
			echo "</ul>";
		echo "</div>";
	}
?>

<div class='productEdit'>
	<?php 
		$p = $product["Product"];
		if (isset($comments))
			$comments = json_decode($comments[count($comments) - 1]["Commentary"]["additionnalInfo"], true);
		else
			$comments = null;
		$authorizeKey = array(
			"name",
			"description",
			"price",
			"img"
		);
	?>
	<h1><?php echo $p["name"] ?></h1>
	<h5>Statut: <span class='status'>
	<?php
		switch ($p["status"]) {
			case 1: echo "Brouillon <span class='fui fui-document'></span>"; break;
			case 2: echo "En attente de Validation <span class='fui fui-heart'></span>"; break ;
			case 3: echo "Validé ! <span class='fui fui-check'></span>"; break ;
		}
	?>
	</span></h5>
	<?php echo $this->Form->create('edit', array("type" => "file")); ?>
		<?php 
			foreach ($p as $key => $pro) {
				for ($i = 0; isset($authorizeKey[$i]); $i++) {
					if ($key == $authorizeKey[$i])
					displayInput($key, $p, $comments, $this); 
				}
			} ?>
		<button type='submit' class='btn btn-success'>Mettre à jour</button>
</div>
