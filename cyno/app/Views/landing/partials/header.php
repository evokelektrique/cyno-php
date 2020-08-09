<?php 
// Router
$router = service('router'); 
?>
<nav class="navbar" id="header-navigation" role="navigation" aria-label="main navigation">

	<div class="navbar-start">
		<div class="navbar-brand">
			<a class="navbar-item" href="<?= base_url() ?>">
				<img src="<?= base_url('public/images/logo/cyno_dark.png') ?>">
			</a>
			<a role="button" class="navbar-burger" data-target="nav-menu" aria-label="menu" aria-expanded="false">
				<span aria-hidden="true"></span>
				<span aria-hidden="true"></span>
				<span aria-hidden="true"></span>
			</a>
		</div>
	</div>

	<div class="navbar-end">
		<div class="navbar-menu" id="nav-menu">
			<?php if($session->user['is_logged_in']): ?>	
				<?php if($router->controllerName() === "\App\Controllers\Landing"): ?>
					<a class="navbar-item" href="<?= base_url(route_to('dashboard')) ?>">
						<?= lang('cyno.dashboard') ?>
					</a>
				<?php endif; ?>
			<?php else: ?>
				<?php if($router->controllerName() === "\App\Controllers\Landing"): ?>
					<a class="navbar-item" href="<?= base_url(route_to('user_login')) ?>">
						<?= lang('cyno.login') ?>
					</a>
					<a class="navbar-item" href="<?= base_url(route_to('user_register')) ?>">
						<?= lang('cyno.register') ?>
					</a>
				<?php endif; ?>
			<?php endif; ?>
		</div>
	</div>
</nav>