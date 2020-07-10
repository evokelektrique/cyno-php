<div class="modal" id="new_password_modal">
  <div class="modal-background"></div>
  <div class="modal-content">
  	<div class="box">
		<?= form_open(base_url(route_to('App\Controllers\Passwords::create')), ['id' => 'encryption_form']) ?>
		<div class="field">
			<label class="label"><?= lang('cyno.masterkey') ?></label>
			<div class="control">
				<?= form_password('masterkey', '', ['id' => 'master_key', 'class' => 'input']) ?>
			</div>
		</div>

		<div class="field">
			<label class="label"><?= lang('cyno.masterkey_ad') ?></label>
			<div class="control">
				<?= form_password('masterkey_ad', '', ['id' => 'master_key_ad', 'class' => 'input']) ?>
			</div>
		</div>

		<div class="field ">
			<label class="label"><?= lang('cyno.password') ?></label>
			<div class="control">
				<?= form_password('cipher_text', '', ['id' => 'password', 'class' => 'input']) ?>
			</div>
		</div>
		<div class="columns is-centered">
			<div class="column">
				<div class="field">
					<label class="label"><?= lang('cyno.folder') ?></label>
					<div class="control is-expanded">
						<div class="select is-fullwidth">
						<?php if(isset($folder->hash_id)): ?>
							<?= form_dropdown('folder', $multiselect_folders, [$folder->hash_id], ['id' => 'folder']); ?>
						<?php else: ?>
							<?= form_dropdown('folder', $multiselect_folders, ['0'], ['id' => 'folder']); ?>
						<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
			<div class="column">
				<div class="field">
					<label class="label"><?= lang('cyno.difficulty') ?></label>
					<div class="control is-expanded">
						<div class="select is-fullwidth">
							<?= form_dropdown('difficulty', $difficulty_options, '1'); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="field is-block">
			<button class="button is-primary" id="submit_encrypt">
				<?= lang('cyno.submit') ?>
			</button>
		</div>
		<?= form_close() ?>
	  </div>
  	</div>
  <button class="modal-close is-large" aria-label="close"></button>
</div>