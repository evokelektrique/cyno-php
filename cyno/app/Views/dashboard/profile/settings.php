<?= $this->extend('layouts/dashboard') ?>
<?= $this->section('wrapper') ?>
	<?= $this->include('dashboard/partials/header') ?>
	<h1> profile settings </h1>

<?= form_open(base_url(route_to('App\Controllers\Profile::validate_settings'))) ?>
	<?= form_hidden('_method', 'PUT') ?>
	<?= form_input('user[email]', $user->email, 'disabled="disabled"') ?>
	<br>
	<?= form_password('user[password]', '') ?>
	<br>
	<?= form_password('user[password_confirm]', '') ?>
	<br>
	<?= form_submit('submit', 'Submit!') ?>

<?= $this->endSection() ?>