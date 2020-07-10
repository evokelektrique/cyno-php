

<table class="table is-hoverable is-fullwidth">
	<tbody>
	<?php foreach($passwords as &$password): ?>
		<tr id='password-<?=$password->hash_id?>'>
			<td><i class="fas fa-fingerprint fa-lg"></i></td>
			<td>
				<a href="<?= base_url(route_to('dashboard_shared_me_show', $password->hash_id)) ?>">
				<?php if (!empty($password->title)): ?>
					<?= $password->title ?>
				<?php else: ?>
					<?= lang('cyno.no_title') ?>
				<?php endif ?>
				</a>
			</td>
			<td title="<?= $password->created_at ?>"><?= $time::parse($password->created_at)->humanize() ?></td>
			<td class="hast-text-left">
				<a class="button is-small is-primary" href="<?= base_url(route_to('dashboard_shared_me_show', $password->hash_id)) ?>">
					<?= lang('cyno.show') ?>
				</a>
				<a class="button is-small is-warning" href="<?= base_url(route_to('dashboard_shared_edit', $password->hash_id)) ?>">
					<?= lang('cyno.edit') ?>
				</a>
			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>
