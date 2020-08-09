<?php $uri = new \CodeIgniter\HTTP\URI($website->url) ?>
<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('wrapper') ?>
<?= $this->include('dashboard/partials/header') ?>



<div class="columns is-centered px-3">
	<div class="column is-10">
		<h1 class="is-flex">
			<span class="align-baseline">
				<?= lang('cyno.passwords') ?> 
				
			</span>
			<a href="#" class="button is-light">
				<?= $uri->getHost() ?>
			</a>
		</h1>
		<div class="table-container">
			<table class="table is-hoverable is-fullwidth">
				<tbody>
					<?= $this->include('dashboard/passwords/index') ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<?= $this->endSection() ?>