<?= $this->extend('layouts/authentication') ?>
<?php if ($session->has('alert')) : ?>
	<?= var_dump($session->alert) ?>
<?php endif; ?>

<?= $this->section('wrapper') ?>
<div class="hero is-fullheight">
	<?= $this->include('landing/partials/header') ?>
	<div class="columns is-centered">
		<div class="column is-4 is-12-touch is-12-mobile px-5">
			<?php
			$email_input = [
				'name' 			=> 'user[email]',
				'id' 			=> 'user_email',
				'class'	 		=> 'input',
				'value' 		=> old('user.email'),
				'maxlength'	 	=> '100',
				'type' 			=> 'email',
				'placeholder' 	=> lang('cyno.email_placeholder'),
			];
			$password_input = [
				'name' => 'user[password]',
				'id' 	=> 'password',
				'class' => 'input',
				'value' => '',
				'maxlength' => '100',
				'type' => 'password',
				'placeholder' => lang('cyno.password_placeholder'),
			];
			$submit_input = [
				'name' => 'submit',
				'id' => 'submit',
				'class' => 'button is-primary is-fullwidth',
				'value' => lang('cyno.login'),
				'type' => 'submit',
			];
			?>
			<p class="title is-size-1 has-text-justified">
				<?= lang('cyno.welcome_message') ?>
			</p>
			<?php if ($session->has('email_not_verified')) : ?>
				<div class="content">
					<div class="notification is-danger">
						<button class="delete"></button>
						<strong><?= lang('cyno.email_not_verified') ?></strong>
						<?= form_open(base_url(route_to('user_resend_email'))) ?>
						<?= form_hidden('hash', $session->email_not_verified['hash']) ?>
						<button class='button is-light'>
							<?= lang('cyno.resend_email_button') ?>
						</button>
						<?= form_close() ?>
					</div>
				</div>
			<?php endif; ?>
			<?php if ($session->has('validation')) : ?>
				<div class="content">
					<div class="notification is-danger">
						<button class="delete"></button>
						<?= $session->validation->listErrors() ?>
					</div>
				</div>
			<?php endif; ?>
			<?php if ($session->has('alert')) : ?>
				<div class="content">
					<div class="notification <?= ((int)$session->alert['status'] > 0) ? 'is-primary' : 'is-danger' ?> ">
						<button class="delete"></button>
						<?= $session->alert['message'] ?>
					</div>
				</div>
			<?php endif; ?>
			<?= form_open(base_url(route_to('App\Controllers\Login::validation'))) ?>
			<div class="field">
				<label class="label"><?= lang('cyno.email') ?></label>
				<div class="control">
					<?= form_input($email_input); ?>
				</div>
			</div>
			<div class="field">
				<label class="label"><?= lang('cyno.password') ?></label>
				<div class="control">
					<?= form_password($password_input); ?>
				</div>
			</div>
			<div class="level">
				<div class="level-right">
					<label class="checkbox">
						<input type="checkbox">
						<?= lang('cyno.remember_me') ?>
					</label>
				</div>
				<div class="level-left">
					<a href="#"><?= lang('cyno.forget_password') ?></a>
				</div>
			</div>
			<?= form_submit($submit_input); ?>
			<div class="register_message has-text-centered py-5">
				<?= lang('cyno.register_message_one') ?>
				<a href="<?= base_url(route_to('user_register')) ?>"><?= lang('cyno.register_message_two') ?></a>
			</div>


			<?= form_close() ?>
		</div>
		<div class="column is-hidden-touch is-hidden-mobile">
			<div id="cyno_auth_image" class="is-pulled-left"></div>
		</div>
	</div>
</div>
<div id="blob" class="is-hidden-touch is-hidden-mobile"></div>

<?= $this->endSection() ?>