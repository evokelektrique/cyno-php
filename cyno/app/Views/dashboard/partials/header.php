<nav class="navbar  mb-5" id="header-navigation" role="navigation" aria-label="dropdown navigation">
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
	<div class="navbar-menu" id="nav-menu">
		<a class="navbar-item" href='<?= base_url(route_to('dashboard')) ?>'>
			<?= lang('cyno.dashboard') ?>
		</a>
		<div class="navbar-item has-dropdown is-hoverable">
			<a class="navbar-link" href='<?= base_url(route_to('dashboard_folders')) ?>'>
				<?= lang('cyno.dashboard_folders') ?>
			</a>
			<div class="navbar-dropdown is-boxed">
				<a class="navbar-item" href='<?= base_url(route_to('dashboard_shared_me')) ?>'>
					<?= lang('cyno.dashboard_shared_me') ?>
				</a>
				<a class="navbar-item" href='<?= base_url(route_to('dashboard_shared_others')) ?>'>
					<?= lang('cyno.dashboard_shared_others') ?>
				</a>
			</div>
		</div>
		<a class="navbar-item" href='<?= base_url(route_to('dashboard_websites')) ?>'>
			<?= lang('cyno.websites') ?>
		</a>
		<a class="navbar-item" href='<?= base_url(route_to('dashboard_profile_settings')) ?>'>
			<?= lang('cyno.dashboard_profile_settings') ?>
		</a>

		<div class="navbar-end">
			<div class="navbar-item">
				<?= form_open(base_url(route_to('dashboard_profile_logout'))) ?>
				<?= form_hidden('_method', 'DELETE') ?>
				<button class="button is-primary">
					<span class="icon is-small">
						<i class="fas fa-sign-out-alt"></i>
					</span>
					<span><?= lang('cyno.logout') ?></span>
				</button>
				<?= form_close() ?>
			</div>
		</div>
	</div>
</nav>
<div class="columns is-centered">
	<div class="column is-10">
		<?php if($session->has('alert')): ?>
			<div class="notification <?= ((int)$session->alert['status'] > 0) ? 'is-primary':'is-danger' ?> is-light mt-3">
				<button class="delete"></button>
				<?php switch ($session->alert['status']) {
					// (Logged In) Status
					case 1: 
					echo $session->alert['message'];
					break;
					// (Error) Status
					case 0:
					echo $session->alert['message'];
					// (Default) Status
					default:
					break;
				} ?>		
			</div>
		<?php endif; ?>
		<?php if($session->has('errors')): ?>
			<ul>
				<?php foreach($session->errors as $key => $error): ?>
					<li class="has-text-danger">
						* <?= $error ?>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</div>
</div>