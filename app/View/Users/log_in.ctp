<div class="row">
	<div class="col-md-12">
		<h1>Se Connecter</h1>
		<?php echo $this->Form->create('User') ?>
			<div class="form-group">
				<?php echo $this->Form->input('email', array(
					"class" => "form-control",
					"placeholder" => "Email",
					"label" => false,
					"before" => "<span class=\"input-group-addon\">@</span>",
					"div" => array(
						"class" => "input-group"
					)
				))?>
			</div>
			<div class="form-group">
				<?php echo $this->Form->input('password', array(
					"class" => "form-control",
					"placeholder" => "Mot de Passe",
					"label" => false
				)) ?>
			</div>
			<?php echo $this->Html->link("Je n'ai pas de compte !", array(
				"controller" => "users",
				"action" => "signUp"
			)) ?>
			<br />
			<?php echo $this->Html->link("Vous allez rire, je ne me souviens plus de mon mot de passe", array(
				"controller" => "users",
				"action" => "forgotPassword"
			)) ?>

			<div class="form-group">
					<button type="submit" class="btn btn-primary oneHundred">Se Connecter !</button>
			</div>
		</form>
	</div>
</div>
