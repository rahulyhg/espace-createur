<div class="row">
	<div class="col-md-12">
		<h1>S'inscrire</h1>
		<form role="form" action="/ec/users/signUp" method="post">
			<div class="form-group">
				<?php echo $this->Form->input('email', array(
					"class" => "form-control", 
					"placeholder" => "Email", 
					"label" => false,
					"before" => "<span class=\"input-group-addon\">@</span>",
					"div" => array(
						"class" => "input-group"
					)
				)) ?>
			</div>
			<div class="form-group">
				<?php echo $this->Form->input('nickName', array(
					"class" => "form-control",
					"placeholder" => "Mon nom de scène",
					"label" => false
				)) ?>
			</div>
			<div class="form-group">
				<?php echo $this->Form->input('firstName', array(
					"class" => "form-control",
					"placeholder" => "Prénom",
					"label" => false
				)) ?>
			</div>
			<div class="form-group">
				<?php echo $this->Form->input('lastName', array(
					"class" => "form-control",
					"placeholder" => "Nom de Famille",
					"label" => false
				)) ?>
			</div>
			<div class="form-group">
				<?php echo $this->Form->input('password', array(
					"class" => "form-control",
					"placeholder" => "Mot de passe",
					"label" => false
				)) ?>
			</div>
			<div class="form-group">
				<?php echo $this->Form->input('passwordConfirmation', array(
					"class" => "form-control",
					"placeholder" => "Confirmation",
					"label" => false,
					'type' => "password"
				)) ?>
			</div>
			<div class="form-group">
				<?php echo $this->Form->input('website', array(
					"class" => "form-control",
					"placeholder" => "Site web",
					"label" => false
				)) ?>
			</div>
			<div class="form-group">
				<?php echo $this->Form->input('type', array(
					"options" => array(1 => "Une Créatrice", 2 => "Une Blogeuse"),
					"class" => "select",
					"label" => "Je suis...",
					"data-toggle" => "select"
				))
				?>
			</div>
			<?php echo $this->Html->link("J'ai deja un compte !", array(
				"controller" => "Users",
				"action" => "logIn"
			)) ?>
			<div class="form-group">
					<button type="submit" class="btn btn-primary oneHundred">S'inscrire !</button>
			</div>
		</form>
	</div>
</div>
