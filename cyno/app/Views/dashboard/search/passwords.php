<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('wrapper') ?>
	<?= $this->include('dashboard/partials/header') ?>



	<div class="columns is-centered px-3">
		<div class="column is-10">
			<h1><?= lang('cyno.passwords') ?></h1>
			<?= $this->include('dashboard/partials/search') ?>
			<table class="table is-hoverable is-fullwidth">
				<tbody>
				<?php foreach($passwords as &$password): ?>
					<tr id='password-<?=$password->hash_id?>'>
						<td><i class="fas fa-fingerprint fa-lg"></i></td>
						<td>
							<a href="<?= base_url(route_to('dashboard_password_show', $password->hash_id)) ?>">
							<?php if (!empty($password->title)): ?>
								<?= $password->title ?>
							<?php else: ?>
								<?= lang('cyno.no_title') ?>
							<?php endif ?>
							</a>
						</td>
						<td title="<?= $password->created_at ?>"><?= $time::parse($password->created_at)->humanize() ?></td>
						<td><a href="<?= base_url(route_to('dashboard_password_show', $password->hash_id)) ?>">مشاهده</a></td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
			<?php if(empty($passwords)): ?>
				<?= lang('cyno.no_result') ?>
			<?php endif; ?>
		</div>
	</div>
<?= $this->endSection() ?>