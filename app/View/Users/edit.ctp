<div class='account'>
	<h1>Mon Compte</h1>
	<?php echo $this->Form->create("user", array("type" => "file")); ?>
		<h3>Informations</h3>
		<div class='form-group'>
			<?php echo $this->Form->input('firstName', array(
				"class" => "form-control",
				"placeholder" => "Prénom",
				"label" => false,
				"before" => "<span class='input-group-addon'>Prénom</span>",
				"value" => $infos["User"]["firstName"],
				"div" => array(
					"class" => "input-group"
				)
			)) ?>
		</div>
		<div class='form-group'>
			<?php echo $this->Form->input('lastName', array(
				"class" => "form-control",
				"placeholder" => "Nom de famille",
				"label" => false,
				"before" => "<span class='input-group-addon'>Nom</span>",
				"value" => $infos["User"]["lastName"],
				"div" => array(
					"class" => "input-group"
				)
			)) ?>
		</div>
		<div class='form-group'>
			<?php echo $this->Form->input('email', array(
				"class" => "form-control",
				"placeholder" => "Email",
				"label" => false,
				"before" => "<span class='input-group-addon'>@</span>",
				"value" => $infos["User"]["email"],
				"div" => array(
					"class" => "input-group"
				)
			)) ?>
		</div>
		<h3>Mot de passe</h3>
		<div class='form-group'>
			<?php echo $this->Form->input('oldPass', array(
				"class" => "form-control",
				"placeholder" => "Mot de passe actuel",
				"label" => false,
				"type" => "password"
			)) ?>
		</div>
		<div class='form-group'>
			<?php echo $this->Form->input('newPass1', array(
				"class" => "form-control",
				"placeholder" => "Nouveau Mot de Passe",
				"label" => false,
				"type" => "password"
			)) ?>
		</div>
		<div class='form-group'>
			<?php echo $this->Form->input('newPass2', array(
				"class" => "form-control",
				"placeholder" => "Confirmez le nouveau mot de passe",
				"label" => false,
				"type" => "password"
			)) ?>
		</div>
		<h3>Moar</h3>
		<div class="form-group">
			<?php echo $this->Form->input("website", array(
				"class" => "form-control",
				"label" => false,
				"value" => $infos["User"]["website"],
				"before" => "<span class='input-group-addon'>Site</span>",
				"div" => array(
					"class" => "input-group"
				)
			)) ?>
		</div>
		<h4>Addresse</h4>
		<div class="form-group">
			<?php echo $this->Form->input("infosStreet", array(
				"class" => "form-control",
				"label" => false,
				"value" => $infos["User"]["infos"]["address"]["street"],
				"before" => "<span class='input-group-addon'>Rue</span>",
				"div" => array(
					"class" => "input-group"
				)
			)) ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->input("infosCity", array(
				"class" => "form-control",
				"label" => false,
				"value" => $infos["User"]["infos"]["address"]["city"],
				"before" => "<span class='input-group-addon'>Ville</span>",
				"div" => array(
					"class" => "input-group"
				)
			)) ?>
		</div>
		<div class='form-group'>
			<?php echo $this->Form->input("infosPostal", array(
				"class" => "form-control",
				"label" => false,
				"value" => $infos["User"]["infos"]["address"]["postal"],
				"type" => "number",
				"before" => "<span class='input-group-addon'>Code Postal</span>",
				"div" => array(
					"class" => "input-group"
				)
			)) ?>
		</div>
		<h4>Image</h4>
		<div class="form-group">
			<?php echo $this->Form->input("img", array(
				"label" => false,
				"type" => "file"
			)) ?>
		</div>
		<div class="form-group">
			<button type="submit" class="btn btn-success">Valider</button>
		</div>
	</form>
</div>
