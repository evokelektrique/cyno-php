<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('wrapper') ?>
<?= $this->include('dashboard/partials/header') ?>



<div class="columns is-centered px-3">
	<div class="column is-10">
		<h1><?= lang('cyno.passwords') ?></h1>
		<?= $this->include('dashboard/partials/search') ?>
		<div class="table-container">
			<table class="table is-hoverable is-fullwidth">
				<tbody>
					<?= $this->include('dashboard/passwords/index') ?>
				</tbody>
			</table>
		</div>
		<?php if (empty($passwords)) : ?>
			<?= lang('cyno.no_result') ?>
		<?php endif; ?>
	</div>
</div>
<?= $this->endSection() ?>