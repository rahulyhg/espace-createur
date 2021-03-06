<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!--
Espace Créateurs, 2014 Under MIT License.
https://github.com/Ne02ptzero/espace-createur

███████╗███████╗██████╗  █████╗  ██████╗███████╗     ██████╗██████╗ ███████╗ █████╗ ████████╗███████╗██╗   ██╗██████╗ ███████╗
██╔════╝██╔════╝██╔══██╗██╔══██╗██╔════╝██╔════╝    ██╔════╝██╔══██╗██╔════╝██╔══██╗╚══██╔══╝██╔════╝██║   ██║██╔══██╗██╔════╝
█████╗  ███████╗██████╔╝███████║██║     █████╗      ██║     ██████╔╝█████╗  ███████║   ██║   █████╗  ██║   ██║██████╔╝███████╗
██╔══╝  ╚════██║██╔═══╝ ██╔══██║██║     ██╔══╝      ██║     ██╔══██╗██╔══╝  ██╔══██║   ██║   ██╔══╝  ██║   ██║██╔══██╗╚════██║
███████╗███████║██║     ██║  ██║╚██████╗███████╗    ╚██████╗██║  ██║███████╗██║  ██║   ██║   ███████╗╚██████╔╝██║  ██║███████║
╚══════╝╚══════╝╚═╝     ╚═╝  ╚═╝ ╚═════╝╚══════╝     ╚═════╝╚═╝  ╚═╝╚══════╝╚═╝  ╚═╝   ╚═╝   ╚══════╝ ╚═════╝ ╚═╝  ╚═╝╚══════╝
                                                                                                                              

Louis <louis@ne02ptzero.me>
-->
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo "EC:" ?>
		<?php echo $this->fetch('title'); ?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		/* CSS DECLARATION */
			echo $this->Html->css(array(
				'bootstrap.min',
				'flat-ui.min',
				'main',
				'Infos',
				'Menus',
				'Admins',
				'Tickets',
				'Notifications',
				'Products',
				'Sales',
				'Calendar',
				'Users',
				'//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css'
			));

		/* JS DECLARATION */
			echo $this->Html->script(array(
				'jquery.min',
				'flat-ui',
				'Chart.min',
				'main',
				'Admins',
				'Notifications',
				'Products',
				'Sales',
				'Calendar',
				'Users',
				'Tour'
			));

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
	<meta charset="utf-8">
<?php
	if (isset($_GET['tour'])) {
		echo "<script>$(document).ready(function() {tour();});</script>";
	}
?>

</head>
<body>
	<div id="container">
	<?php if (AuthComponent::user('id')) { ?>
		<div id="header" class="col-xs-12">
			<nav class="navbar navbar-inverse navbar-embossed" role="navigation">
				<div class="navbar-header">
					<button class="navbar-toggle" data-target="#navbar-collapse-01" data-toggle="collapse" type="button"></button>
					<a href="/ec" class='navbar-brand popOver0'>Espace Créateurs</a>
				</div>
				<div class="collapse navbar-collapse" id="navbar-collapse-01">
					<ul class="nav navbar-nav navbar-left">
						<li>
							<a class='popOver1' href="/ec/Products">
							<?php if (AuthComponent::user('type') != 0) {
										echo "Mes Créations";
									} else {
										echo "Créations"; } ?>
							</a>
						</li>
						<li>
							<a href="/ec/Sales/" class='popOver2'>
								<?php if (AuthComponent::user('type') != 0) {
										echo "Mes Ventes";
									} else {
										echo "Ventes"; } 
									if (isset($Sales) && $Sales != 0) {
									 	echo '<span class="navbar-new notification-count">';
										echo $Sales;
										echo "</span>";
									}
								?>
							</a>
						</li>
						<li>
							<a href="/ec/Notifications/index/read" class='popOver3'>
								Notifications
								<?php
								 if (isset($Notifications) && $Notifications != 0) {
								 	echo '<span class="navbar-new notification-count">';
									echo $Notifications; 
									echo "</span>";
								}
								?>
							</a>
						</li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li>
							<a href="/ec/users/edit" class='popOver4'>
								Mon Compte <span class="fui-user"></span>
							</a>
						</li>
						<li>
							<a href="/ec/Tickets" class='popOver5'>
								Tickets <span class="fa fa-ticket"></span>
							</a>
						</li>
						<?php if (AuthComponent::user('type') == 0) { ?>
						<li>
							<a href='/ec/admins'>
								Admin <span class="fui-gear"></span>
							</a>
						</li>
						<?php } ?>
						<li>
							<a href="/ec/infos/git" class='popOver6'>
								A propos <span class="fui-link"></span>
							</a>
						<li>
							<a href="/ec/users/logOut" class='popOver11'>
								Déconnexion <span class="fui-power"></span>
							</a>
						</li>
					</ul>
				</div>
			</nav>
		</div>
		<div id="content">
	<?php } else {
			echo "<div id=\"content\" class='content_spe'>";
			echo "<h1 class='spe_title'>Espace Créateurs</h1>";
		}
		?>

			<?= $this->Session->flash(); ?>
			<?php if (($message = $this->Session->flash('good'))) {
					echo "<div class='notify notify-good ";
					if (!AuthComponent::user('id'))
						echo "noLogin";
					echo "'>";
						echo "<span class='fui-check-circle'></span>";
						echo $message;
					echo "</div>";
				} if (($message = $this->Session->flash('bad'))) {
					echo "<div class='notify notify-bad ";
					if (!AuthComponent::user('id'))
						echo "noLogin";
					echo "'>";
						echo "<span class='fui-cross-circle'></span>";
						echo $message;
					echo "</div>";
				} ?>
			<div id="main">
				<?php echo $this->fetch('content'); ?>
			</div>
		</div>
		<div id="footer">
		</div>
	</div>
</body>
</html>
