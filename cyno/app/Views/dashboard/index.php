<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('wrapper') ?>	

<?= $this->include('dashboard/partials/header') ?> 

<div class="columns is-centered px-3">
	<div class="column is-10">
		<div class="container pb-5">
			<?= $this->include('dashboard/partials/navigator') ?>
			<!-- Password Modal -->
			<?= $this->include('dashboard/passwords/new') ?>
			<!-- Folder Modal -->
			<?= $this->include('dashboard/folders/new') ?>
			
			<div class="is-pulled-right">
				<h1><?= lang('cyno.latest_passwords') ?></h1>
			</div>
			<div class="is-pulled-left">
				<a href="<?= base_url(route_to('dashboard_folders')) ?>"><?= lang('cyno.show_more') ?></a>
			</div>
			<div class="is-clearfix"></div>
			
		</div>

		<!-- Passwords -->
		<div class="columns">
			<?php foreach($passwords as $password): ?>
			<div class="column is-4">
				<div id='password-<?=$password->hash_id?>' class="box has-background-info has-text-white">
					<div class="level">
						<div class="level-right">
							<h1 class="is-size-4 has-text-weight-bold">آزمایش عنوان</h1>
						</div>
						<div class="level-left is-hidden-touch">
							<span class="icon is-large">
								<i class="fas fa-3x fa-fingerprint"></i>
							</span>
						</div>
					</div>
					<span class="is-block pb-4 is-family-monospace is-unselectable has-text-centered is-uppercase has-text-weight-bold"><?= $password->cipher ?></span>
					<div class="level">
						<div class="level-right">
							<span class="icon is-small">
								<i class="fas fa-clock"></i>
							</span>
							<?= $password->created_at ?>
						</div>
						<div class="level-left">
							<a href="<?= base_url(route_to('dashboard_password_show', $password->hash_id)) ?>" class="is-size-7 has-text-white"><?= lang('cyno.show_more') ?>
								<span class="icon">
								  <i class="fas fa-arrow-left"></i>
								</span>
							</a>
						</div>
					</div>
		<!-- 			<?= form_open(route_to('App\Controllers\Passwords::delete', $password->hash_id), ['style' => 'display: inline-block']) ?>
						<?= form_hidden('_method', 'DELETE') ?>
						<?= form_submit('delete', 'DELETE!', ['class' => 'button is-small is-danger']) ?>
					<?= form_close() ?>	
		 -->
				</div>
			</div>
			<?php endforeach; ?>
		</div>
		<?php if(empty($password)): ?>
			<div class="box has-background-dark has-text-white has-text-centered has-text-weight-light is-size-4 my-5"><?= lang('cyno.no_password_message') ?></div>
		<?php endif; ?>
	</div>
</div>
<?= $this->endSection('wrapper') ?>