<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('wrapper') ?>
	<?= $this->include('dashboard/partials/header') ?>

	<div class="columns is-centered px-3">
		<div class="column is-10">
			<?= $this->include('dashboard/partials/search') ?>
			<table class="table is-hoverable is-fullwidth">
				<thead>
					<th><?= lang('cyno.title') ?></th>
					<th><?= lang('cyno.url') ?></th>
					<th><?= lang('cyno.passwords') ?></th>
					<th><?= lang('cyno.created_at') ?></th>
				</thead>	
				<tbody>
					<?php foreach($websites as &$website): ?>
					<tr>
						<td><a href="<?= base_url(route_to('dashboard_website_passwords', $website->hash_id)) ?>"><?= $website->title ?></a></td>
						<td>
							<?php 
								$website_url = new \CodeIgniter\HTTP\URI($website->url);
								echo $website_url->getHost();
							?>
						 </td>
						<td><?=
							$password_model
								->where('user_id', $session->user['id'])
								->where('website_id', $website->id)
								->countAllResults()
							?></td>
						<td title="<?= $website->created_at ?>"><?= $time::parse($website->created_at)->humanize() ?></td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
<?= $this->endSection() ?>