<?= $this->extend('layouts/dashboard') ?>
<?= $this->section('wrapper') ?>
<?= $this->include('dashboard/partials/header') ?>
<div class="columns is-centered px-3">
	<div class="column is-10">
		<h1 class="title is-size-2 has-text-centered has-text-weight-bold pb-2"><?= lang('cyno.profile_settings') ?></h1>		
		
		<!-- Tabs -->
		<?= $this->include('dashboard/partials/profile/tabs') ?>
		
		<!-- Change-Password Form -->
		<?= form_open(base_url(route_to('App\Controllers\Profile::validate_settings'))) ?>
		<?= form_hidden('_method', 'PUT') ?>
		<div class="field">
			<div class="control">
				<label for="email" class="label"><?= lang('cyno.email') ?></label>
				<?= form_input('user[email]', $user->email, ['disabled' => 'disabled', 'id' => 'email', 'class' => 'input']) ?>
			</div>
		</div>
		<div class="field">
			<div class="control">
				<label for="password" class="label"><?= lang('cyno.password') ?></label>
				<?= form_password('user[password]', '', ['id' => 'password', 'class' => 'input']) ?>
			</div>
		</div>
		<div class="field">
			<div class="control">
				<label for="confirm_password" class="label"><?= lang('cyno.confirm_password') ?></label>
				<?= form_password('user[password_confirm]', '', ['id' => 'confirm_password', 'class' => 'input']) ?>
			</div>
		</div>
		<?= form_submit('submit', lang('cyno.submit'), ['class' => 'button is-primary']) ?>

	</div>
</div>
<?= $this->endSection() ?>