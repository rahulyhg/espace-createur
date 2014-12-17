<style>
	#header {
		display: none;
	}

	body {
		background: none repeat scroll 0% 0% #BDC3C7;
	}
</style>
<div class='welcome'>
	<h1>Bienvenue, <?php echo AuthComponent::user('firstName')?></h1>
	<h6>Voici l'espace créateurs. Aidez-nous à mieux vous connaitre !</h6>
	<div class='form' style='display: none'>
	<?php echo $this->Form->create('Form', array("type" => "file")) ?>
		<div class="form-group">
			<?php echo $this->Form->input("infosStreet", array(
				"class" => "form-control",
				"label" => false,
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
</div>
