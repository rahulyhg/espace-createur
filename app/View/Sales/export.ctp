<div class='export'>
	<h1>Exports</h1>
	<a href='/ec/Sales/export/1'><button class='btn btn-success'>Tout exporter</button></a>
	<a href='/ec/Sales/export/2'><button class='btn btn-info'>Export du Mois</button></a>
	<a href='/ec/Sales/export/3'><button class='btn btn-inverse'>Export de la Journée</button></a>
	<h4>Export de</h4>
	<?php echo $this->Form->create('date') ?>
	<ul class='input'>
		<li><input class='date1 form-control' type="text" readonly
		value="<?php echo date("Y-m-d") ?>" name='data[date][date1]'></li>
		<li>à <input class='date2 form-control' type="text" readonly
		value="<?php echo date("Y-m-d") ?>" name='data[date][date2]'></li>
	</ul>
	<ul>
		<li><?php echo $this->element('Calendars/main', array("num" => 1)); ?></li>
		<li><?php echo $this->element('Calendars/main', array("num" => 2)); ?></li>
	</ul>
	<button type='submit' class='btn btn-primary'>Lancer l'export</button>
</div>
