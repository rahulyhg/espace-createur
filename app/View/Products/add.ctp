<div class='addProduct'>
	<h1>Ajouter une création</h1>
	<?php echo $this->Form->create('add', array('type' => 'file')); ?>
		<div class='form-group'>
			<?php echo $this->Form->input('name', array(
				"class" => "form-control",
				"placeholder" => "Nom de la création",
				"label" => false
			)) ?>
		</div>
		<div class='form-group'>
			<?php echo $this->Form->input('description', array(
				"class" => "form-control",
				"placeholder" => "Description",
				"label" => false,
				"type" => "textarea"
			)); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->input('shortDescription', array(
				"class" => "form-control shortDescription",
				"placeholder" => "Description minimale",
				"label" => false,
				"type" => "textarea"
			)) ?>
		</div>
		<div class="form-group">
				<label class='checkbox' for="checkbox">
					<input class="custom-checkbox useShortDescription" checked="checked" value="" id="checkbox" data-toggle="checkbox" type="checkbox" name="data[add][useShortDescription]">
					<span class="icons">
						<span class="icon-checked"></span>
						<span class="icon-unchecked"></span>
					</span>
					Utiliser la description comme description minimale
				</label>
		</div>
		<div class="form-group">
			<?php echo $this->Form->input('price', array(
				"class" => "form-control",
				"type" => "number",
				"label" => false,
				"placeholder" => "Prix €"
			)) ?>
		</div>
		<div class='form-group'>
			<?php echo $this->Form->input('weight', array(
				"class" => "form-control",
				"type" => "number",
				"label" => false,
				"placeholder" => "Poids"
			)) ?>
		</div>
		<h3>Images</h3>
		<div class="form-group">
			<?php echo $this->Form->input("img", array(
				"type" => "file",
				"label" => false
			)) ?>
		</div>
		<button class='btn btn-success' type='submit'>Ajouter la création</button>
</div>
