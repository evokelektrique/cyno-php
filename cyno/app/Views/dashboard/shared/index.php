<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('wrapper') ?>
	<?= $this->include('dashboard/partials/header') ?>

	<div class="columns is-centered px-3">
		<div class="column is-10">
			<h1 class="is-size-4 has-text-centered py-5 my-5"><?= $title ?></h1>
			<?= $this->include('dashboard/shared/list') ?>
		</div>
	</div>
<?= $this->endSection() ?>