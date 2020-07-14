<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('wrapper') ?>
<?= $this->include('dashboard/partials/header') ?>


<!-- 	<div id='password-<?= $password->hash_id ?>'>
		<code style="color: pink"><?= $password->hash_id ?> - <?= $password->cipher ?></code>
	</div>
 -->
<div class="columns is-centered px-5">
	<div class="column is-10">
		<h1 class="is-size-2 has-text-centered py-5">
			<?php if (!empty($password->title)) : ?>
				<?= $password->title ?>
			<?php else : ?>
				<?= lang('cyno.no_title') ?>
			<?php endif; ?>
		</h1>
		<!-- Decryption Form -->
		<div id="decryption" class="has-text-centered py-5">
			<?= form_open(route_to('dashboard'), ['id' => 'decrypt_form']) ?>
			<?= form_hidden('difficulty', $password->difficulty) ?>
			<?= form_hidden('bytes_url', base_url(route_to('dashboard_password_ajax_get_bytes', $password->hash_id))) ?>
			<div class="columns is-centered has-text-centered">
				<div class="column is-expanded">
					<div class="field">
						<label class="label has-text-right"><?= lang('cyno.masterkey') ?></label>
						<div class="control is-expanded">
							<input type="password" id="masterkey" name="masterkey" class="input">
						</div>
					</div>
				</div>
				<div class="column is-expanded">
					<div class="field">
						<label class="label has-text-right"><?= lang('cyno.masterkey_ad') ?></label>
						<div class="control is-expanded">
							<input type="password" id="masterkey_ad" name="masterkey_ad" class="input">
						</div>
					</div>
				</div>
				<div class="column is-2 is-expanded">
					<div class="field">
						<label class="label">&nbsp;</label>
						<div class="control">
							<button id="submit_decrypt" class="button is-primary is-fullwidth">
								<?= lang('cyno.decrypt') ?>
							</button>
						</div>
					</div>
				</div>
			</div>
			<hr>
			<div class="edit has-text-right">
				<a href="<?= base_url(route_to('dashboard_password_edit', $password->hash_id)) ?>" class="button is-warning">
					<?= lang('cyno.edit') ?>
				</a>
			</div>
			<div id="decrypted_password" class="is-hidden">
				<div class="columns is-centered">
					<div class="field column">
						<h2 class="is-size-5 py-5"><?= lang('cyno.decrypted_password') ?></h2>
					</div>
				</div>
				<div class="columns is-centered">
					<div class="field column is-5 has-addons">
						<div class="control">
							<a class="has-icon button is-relative" id="share_options_menu_button">
								<div class="icon">
									<i class="fas fa-ellipsis-h"></i>
								</div>
								<ul id="share_options_menu" class="box">
									<li>
										<div id="share_password_button" class="is-hidden">
											<?= lang('cyno.share') ?>
										</div>
									</li>
								</ul>
							</a>
						</div>
						<div class="control is-expanded">
							<input class="input" type="text" value="" readonly id="decrypted_password_value" />
						</div>
					</div>
				</div>
			</div>
			<?= form_close() ?>
		</div>
		<?= $this->include('dashboard/passwords/share_modal') ?>

	</div>
</div>

<?= $this->endSection() ?>