<?= $this->extend('layouts/dashboard') ?>


<?= $this->section('wrapper') ?>
<?= $this->include('dashboard/partials/header') ?>


<!-- <h1>Folders</h1> -->
<!-- Folders -->
<?= $this->include('dashboard/folders/new') ?>
<div class="columns is-centered px-3">
	<div class="column is-10">
		<?= $this->include('dashboard/partials/navigator') ?>
		<!-- Passwords -->
		<?= $this->include('dashboard/passwords/new') ?>
		<div class="columns is-multiline is-centered">
			<div class="table-container is-fullwidth">
				<table class="table is-fullwidth is-hoverable">
					<tbody>
						<?= $this->include('dashboard/folders/list')?>
						<?= $this->include('dashboard/passwords/index') ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<?= $this->endSection() ?>