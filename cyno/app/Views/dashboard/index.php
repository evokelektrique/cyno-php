<?php 
// Initiate Carbon
use Carbon\Carbon;
?>
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
				<a href="<?= base_url(route_to('dashboard_folders')) ?>" class="button is-light is-primary"><?= lang('cyno.show_more') ?></a>
			</div>
			<div class="is-clearfix"></div>

		</div>

		<!-- Passwords -->
		<div class="columns" id="passwords">
			<?php foreach ($passwords as $password) : ?>
				<div class="column is-4">
					<div id='password-<?= $password->hash_id ?>' class="password box has-background-info has-text-white is-clipped">
						<div class="level">
							<div class="level-right">
								<h1 class="is-size-4 is-size-6-tablet has-text-weight-bold text-ellipsis">
									<?php if (!empty($password->title)) : ?>
										<?= $password->title ?>
									<?php else : ?>
										<?= lang('cyno.no_title') ?>
									<?php endif; ?>
								</h1>
							</div>
							<div class="level-left is-hidden-touch">
								<span class="icon is-large">
									<i class="fas fa-3x fa-fingerprint"></i>
								</span>
							</div>
						</div>
						<span class="is-block pb-4 is-family-monospace is-unselectable has-text-centered is-uppercase has-text-weight-bold is-clipped text-ellipsis text-opacity-50"><?= $password->cipher ?></span>
						<div class="columns is-flex-mobile is-fullwidth is-size-7">
							<div class="column has-text-right pr-0">
								<span class="icon is-small">
									<i class="fas fa-sm fa-clock"></i>
								</span>
								<?= Carbon::parse($password->updated_at)->locale('fa_IR')->diffForHumans();  ?>
							</div>
							<div class="column has-text-left pl-0">
								<a href="<?= base_url(route_to('dashboard_password_show', $password->hash_id)) ?>" class="has-text-white"><?= lang('cyno.show_more') ?>
									<span class="icon">
										<i class="fas fa-sm fa-arrow-left"></i>
									</span>
								</a>
							</div>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
		<?php if (empty($password)) : ?>
			<div class="box has-background-dark has-text-white has-text-centered has-text-weight-light is-size-4 my-5"><?= lang('cyno.no_password_message') ?></div>
		<?php endif; ?>
	</div>
</div>
<?= $this->endSection('wrapper') ?>