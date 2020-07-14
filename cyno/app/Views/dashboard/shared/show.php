<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('wrapper') ?>
	<?= $this->include('dashboard/partials/header') ?>
<!-- 	<div id='password-<?=$password->hash_id?>'>
		<code style="color: pink"><?= $password->hash_id ?> - <?= $password->cipher ?></code>
	</div>
 -->
 	<div class="columns is-centered px-5">
 		<div class="column is-10">
	<h1 class="is-size-2 has-text-centered py-5">
		<?php if(!empty($password->title)): ?>
			<?= $password->title ?>
		<?php else: ?>
			<?= lang('cyno.no_title') ?>
		<?php endif; ?>
	</h1>
	<div class="py-5 has-text-centered" dir="ltr" id="shared_information">
		<code>
			<b>password_cipher</b> => <?= substr($password->cipher, 0,50) ?>...
		</code>
		<br>
		<?php if(!empty($website)): ?>
		<code>
			<b>website_url</b> => <?= $website->url ?>
			<br>
			<b>website_title</b> => <?= $website->title ?>
			<br>
			<b>fav_icon</b> => <img src="<?= $website->fav_icon_url ?>" width="10" height="10" />
		</code>
		<?php endif; ?>
		<br>
		<code>
			From(<?= $sender_user->email ?>) => You(<?= $session->user['email'] ?>)
		</code>
	</div>
	<!-- Decryption Form -->
	<div id="decryption" class="has-text-centered py-5">
		<?= form_open(route_to('dashboard_shared_decrypt'), ['id' => 'share_decrypt_form']) ?>
		<?= form_hidden('user_email', $sender_user->email) ?>
		<?= form_hidden('cipher', $password->cipher) ?>
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
						<button id="submit_decrypt_shared" class="button is-primary is-fullwidth">
							<?= lang('cyno.decrypt') ?>
						</button>
					</div>
				</div>
			</div>
		</div>
		<div id="decrypted_password" class="is-hidden">
			<div class="columns is-centered">
				<div class="field column">
					<h2 class="is-size-5 py-5"><?= lang('cyno.decrypted_password') ?></h2>	
				</div>
			</div>
			<div class="columns is-centered">
				<div class="field column is-5">
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