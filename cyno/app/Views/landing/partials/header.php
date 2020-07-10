<nav class="navbar" role="navigation" aria-label="main navigation">

	<div class="navbar-start">
		<div class="navbar-brand">
			<a class="navbar-item" href="<?= base_url() ?>">
			  <img src="<?= base_url('public/images/logo/cyno_dark.png') ?>">
			</a>
		</div>
	</div>


	<div class="navbar-end">

	<?php 
		// Router
		$router = service('router'); 
		if($router->controllerName() === "\App\Controllers\Landing"):
	?>
		<a class="navbar-item" href="<?= base_url(route_to('user_login')) ?>">
			<?= lang('cyno.login') ?>
		</a>
		<a class="navbar-item" href="<?= base_url(route_to('user_register')) ?>">
			<?= lang('cyno.register') ?>
		</a>
	<?php endif; ?>

	</div>
</nav>