<?php
	/* Class for main div */
		$class = "websiteResult";

	/* Make the select order */
	if ($result == "Magento")
		$options = array(1 => "Magento", 2 => "Prestashop");
	else if ($result == "Prestashop")
		$options = array(2 => "Prestashop", 1 => "Magento");
	else {
		echo "<h5>Desole, la technologie de ce site n'est pas actuellement supportee</h5>";
		echo "<button class='btn btn-success' onclick=\"$('.websiteResult').show(300)\">N'importe quoi, ce site utilise Magento / Prestashop ...</button>";
		$error = true;
		$class .= " ninja";
		$options = array(1 => "Magento", 2 => "Prestashop");
	}
?>

<div class='<?php echo $class ?>'>
	<?php if (!isset($error)) { ?>
		<h5 class='answer'>Il semblerait que ce site soit sous <u><?php echo $result ?></u></h5>
	<?php } ?>
	<br />
	<div class='confirm-form'>
		<form role="form" action="/ec/websites/add" method="post">
		<div class='form-group'>
			<?php echo $this->Form->input('type', array(
				"options" => $options,
				"class" => "select form-control select-primary select-block mbl",
				"label" => "Technologie"
			)) ?>
		</div>
		<div class='form-group'>
			<?php echo $this->Form->input('name', array(
				"placeholder" => "Nom du site",
				"label" => false,
				"class" => "form-control"
			)) ?>
		</div>
		<div class='form-group'>
			<?php echo $this->Form->input('url', array(
					"placeholder" => "URL",
					"label" => false,
					"class" => "form-control",
					"value" => $url,
					"before" => "<span class='input-group-addon'><span class='fui-loop'></span></span>",
					"div" => array(
						"class" => "input-group"
					)
				)) ?>
		</div>
		<div class='form-group'>
			<?php echo $this->Form->input('apiUrl', array(
				"placeholder" => "Url de l'API",
				"label" => false,
				"class" => "form-control",
				"value" => $url."/api/rest",
				"before" => "<span class='input-group-addon'><span class='fui-loop'></span></span>",
					"div" => array(
						"class" => "input-group"
					)
			))?>
		</div>
		<div class='form-group'>
			<?php echo $this->Form->input('apiKey', array(
				"placeholder" => "Clé API",
				"label" => false,
				"class" => "form-control",
				"before" => "<span class='input-group-addon'><span class='fui-clip'></span></span>",
					"div" => array(
						"class" => "input-group"
					)
			)) ?>
		</div>
		<div class='form-group'>
			<?php echo $this->Form->input('apiSecret', array(
				"placeholder" => "Clé secrète API",
				"label" => false,
				"class" => "form-control",
				"before" => "<span class='input-group-addon'><span class='fui-lock'></span></span>",
					"div" => array(
						"class" => "input-group"
					)
			)) ?>
		</div>
		<button type="submit" class="btn btn-primary">Ajouter le site !</button>
	</div>
</div>
