<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('wrapper') ?>
<?= $this->include('dashboard/partials/header') ?>

<div class="columns is-centered px-3">
	<div class="column is-10">
		<?= $this->include('dashboard/partials/search') ?>
		<div class="table-container">
			<table class="table is-hoverable is-fullwidth">
				<thead>
					<th><?= lang('cyno.title') ?></th>
					<th><?= lang('cyno.url') ?></th>
					<th><?= lang('cyno.passwords') ?></th>
					<th><?= lang('cyno.created_at') ?></th>
					<th><?= lang('cyno.operation') ?></th>
				</thead>
				<tbody>
					<?= $this->include('dashboard/websites/list') ?>
				</tbody>
			</table>
		</div>
		<?php if (empty($websites)) : ?>
			<?= lang('cyno.no_result') ?>
		<?php endif; ?>
	</div>
</div>
<?= $this->endSection() ?>