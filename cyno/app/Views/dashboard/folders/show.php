<?= $this->extend('layouts/dashboard') ?>

<?= $this->extend('layouts/dashboard') ?>


<?= $this->section('wrapper') ?>
<?= $this->include('dashboard/partials/header') ?>


<!-- <h1>Folders</h1> -->
<!-- Folders -->
<?= $this->include('dashboard/folders/new') ?>
<div class="columns is-centered px-3">
	<div class="column is-10">
		<nav class="breadcrumb" aria-label="breadcrumbs">
			<ul>
				<li>
					<a href="<?= base_url(route_to('dashboard_folders')) ?>"><?= lang('cyno.home') ?></a>
				</li>
				<?php foreach($breadcrumb as &$bc): ?>
					<li>
						<a class="" href="<?= base_url(route_to('dashboard_folder_show',$bc->hash_id)) ?>"><?= $bc->title ?></a>
					</li>
				<?php endforeach; ?>
			</ul>
		</nav>
		<?= $this->include('dashboard/partials/navigator') ?>

		<!-- Passwords -->
		<?= $this->include('dashboard/passwords/new') ?>
		<div class="columns is-multiline is-centered">
			<div class="table-container">
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