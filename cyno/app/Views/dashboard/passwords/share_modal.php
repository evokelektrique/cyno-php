<div class="modal" id="share_modal">
	<div class="modal-background"></div>
	<div class="modal-content">
		<div class="box">
			<?= form_open(route_to('dashboard_shared_create'), ['id' => 'share_form']) ?>
				<?= form_hidden('password_id',$password->hash_id) ?>
				<div class="field">
					<lable class="label"><?= lang('cyno.email') ?></lable>
					<div class="control">
						<?= form_input(['name' => 'user_email', 'type' => 'email', 'id' => 'user_email','class' => 'input', 'required' => '']) ?>
					</div>
				</div>
				<div class="field">
					<div class="control">
						<button class="button is-primary" id='submit_share'>
							<?= lang('cyno.submit') ?>
						</button>
					</div>
				</div>
			<?= form_close() ?>
		</div>
	</div>
	<button class="modal-close is-large" aria-label="close"></button>
</div>