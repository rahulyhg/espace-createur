<h1><?php echo utf8_encode($infos["name"]) ?></h1>
<?php echo $this->Form->create('edit'); ?>
<div class='form-group'>
	<?php echo $this->Form->input("url", array(
		"class" => "form-control",
		"placeholder" => "Url",
		"value" => $infos["url"],
		"label" => false,
		"before" => "<span class='input-group-addon'><i class='fa fa-link'></i></span>",
		"div" => array(
			"class" => "input-group"
		)
	)); ?>
</div>
<div class='form-group'>
	<?php echo $this->Form->input("apiKey", array(
		"class" => "form-control",
		"placeholder" => "Clé API",
		"value" => $infos["apiKey"],
		"label" => false,
		"before" => "<span class='input-group-addon'>Clé API</span>",
		"div" => array(
			"class" => "input-group"
		)
	)) ?>
</div>
<div class='form-group'>
	<?php echo $this->Form->input("apiSecret", array(
		"type" => "password",
		"class" => "form-control",
		"placeholder" => "Api Secret",
		"value" => $infos["apiSecret"],
		"label" => false,
		"before" => "<span class='input-group-addon'><i class='fa fa-lock'></i></span>",
		"div" => array(
			"class" => "input-group"
		)
	)); ?>
</div>
<div class="form-group">
	<?php echo $this->Form->input("loginFtp", array(
		"class" => "form-control",
		"value" => $infos["loginFtp"],
		"placeholder" => "Utilisateur FTP",
		"label" => false,
		"before" => "<span class='input-group-addon'>Login FTP</span>",
		"div" => array(
			"class" => "input-group"
		)
	)) ?>
</div>
<div class='form-group'>
	<?php echo $this->Form->input("passFtp", array(
		"type" => "password",
		"class" => "form-control",
		"placeholder" => "Password Ftp",
		"value" => $infos["passFtp"],
		"label" => false,
		"before" => "<span class='input-group-addon'>FTP <i class='fa fa-lock'></i></span>",
		"div" => array(
			"class" => "input-group"
		)
	)); ?>
</div>
<div class='form-group'>
	<?php echo $this->Form->input("baseUrl", array(
		"class" => "form-control",
		"value" => $infos["baseUrl"],
		"placeholder" => "Base directory",
		"label" => false,
		"before" => "<span class='input-group-addon'><i class='fa fa-folder'></i></span>",
		"div" => array(
			"class" => "input-group"
		)
	)) ?>
</div>
<button type="submit" class='btn btn-success'>Valider</button>
