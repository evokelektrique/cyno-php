
<!-- Passwords -->

<?php foreach($passwords as $password): ?>
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
		<td>-</td>
		<td title="<?= $password->created_at ?>"><?= $time::parse($password->created_at)->humanize() ?></td>
		<td class="has-text-left">
			<a class="button is-small is-primary" href="<?= base_url(route_to('dashboard_password_show', $password->hash_id)) ?>"><?= lang('cyno.show') ?></a>
			<a class="button is-small is-warning" href="<?= base_url(route_to('dashboard_password_edit', $password->hash_id)) ?>"><?= lang('cyno.edit') ?></a>
		</td>

	</tr>
<?php endforeach; ?>

<!-- <?php foreach($passwords as $password): ?>
	<div class="column is-one-quarter is-mobile">
		<a href="<?= base_url(route_to('dashboard_password_show', $password->hash_id)) ?>" class="box has-background-info has-text-white">
			<div id='password-<?=$password->hash_id?>' class="">
				<div class="password_title has-text-centered">
					<span class="icon is-large">
						<i class="fas fa-3x fa-fingerprint"></i>
					</span>
					<h1 class="is-size-4 has-text-weight-bold">آزمایش عنوان</h1>
				</div>
			</div>
		</a>
	</div>
<?php endforeach; ?>

 -->