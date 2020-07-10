<?php foreach($folders as &$folder): ?>
	<tr id='folder-<?=$folder->hash_id?>'>
		<td><i class="fas fa-folder fa-lg"></i></td>
		<td><a href="<?= base_url(route_to('dashboard_folder_show', $folder->hash_id)) ?>"><?= $folder->title ?></a></td>
		<td>
			<?= $password_model
				->where('user_id', $session->user['id'])
				->where('folder_id', $folder->id)
				->countAllResults() ?>
			<?= lang('cyno.pass') ?></td>
		<td title="<?= $folder->created_at ?>"><?= $time::parse($folder->created_at)->humanize() ?></td>
		<td class="has-text-left">
			<a class="button is-small is-primary" href="<?= base_url(route_to('dashboard_folder_show', $folder->hash_id)) ?>"><?= lang('cyno.show') ?></a>
			<a class="button is-small is-warning" href="<?= base_url(route_to('dashboard_folder_edit', $folder->hash_id)) ?>"><?= lang('cyno.edit') ?></a>
		</td>
	</tr>
<?php endforeach; ?>
