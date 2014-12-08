<h1>Mot de passe oublié ?</h1>
<?php
	echo $this->Form->create("forgot");
	echo "<div class='form-group'>";
	echo $this->Form->input("email", array(
			"class" => "form-control",
			"label" => false,
			"placeholder" => "Email"
		));
	echo "</div>";
	echo "<button type='submit' class='btn btn-info'>He we go!</button>";
?>
	</form>
