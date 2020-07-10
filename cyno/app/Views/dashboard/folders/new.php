<div class="modal" id="new_folder_modal">
	<div class="modal-background"></div>
	<div class="modal-content">
		<div class="box">
			<?= form_open(base_url(route_to('App\Controllers\Folders::create')), ['id' => 'new_folder']) ?>
			<div class="field">
				<label class="label"><?= lang('cyno.title') ?></label>
				<div class="control">
					<?= form_input(['name' => 'title', 'value' => old('title'), 'class' => 'input']) ?>
				</div>
			</div>
			<div class="field">
				<label class="label"><?= lang('cyno.folder') ?></label>
				<div class="control">
					<div class="select">
						<?= form_dropdown('folder', $multiselect_folders, ["$default_folder"], ['id' => 'folder']); ?>
					</div>
				</div>
			</div>
			<button class="button is-primary" id="submit_new_folder"><?= lang('cyno.submit') ?></button>
			<?= form_close() ?>
		</div>
	</div>
</div>
