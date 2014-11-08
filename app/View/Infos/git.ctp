<?php
	for ($i = 0, $version = 0; isset($commits[$i]); $i++, $version += 0.01);
?>
<div class='infos_git'>
	<h1>Espace Créateurs</h1>
	<h3><span class="fui-tag"></span> Version Dev <?php echo $version ?></h3>
	<div class="commit">
		<h6><u>Derniere modification:</u> <?php echo $commits[0]["commit"]["message"] ?></h6>
		<h6><u>Par:</u> <?php echo $commits[0]["commit"]["author"]["name"] ?></h6>
		<h6><u>Le:</u> <?php echo substr($commits[0]["commit"]["author"]["date"], 0, 10) ?></h6>
	</div>
</div>
