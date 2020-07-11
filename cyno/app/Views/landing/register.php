<?= $this->extend('layouts/authentication') ?>
	<?php if($session->has('alert')):?>
		<?= var_dump($session->alert) ?>
	<?php endif; ?>

<?= $this->section('wrapper') ?>
	<div class="hero is-fullheight">
		<?= $this->include('landing/partials/header') ?>
		<div class="columns">
				<div class="is-pulled-right column is-4">
					<?= form_open(base_url(route_to('App\Controllers\Register::create'))) ?>
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
								'value' => lang('cyno.register'),
								'type' => 'submit',
							];
						?>
						<p class="title is-size-1 has-text-justified">
							<?= lang('cyno.register_message') ?>
						</p>
						<?php if($session->has('validation')): ?>
						<div class="content">
							<div class="notification is-danger">
								<button class="delete"></button>							
								<?= $session->validation->listErrors() ?>
							</div>
						</div>
						<?php endif; ?>
						<?php if($session->has('alert')): ?>
						<div class="content">
							<div class="notification is-warning">
								<button class="delete"></button>							
								<?= $session->alert['message'] ?>
							</div>
						</div>
						<?php endif; ?>
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
						<?= form_submit($submit_input); ?>
						<div class="login_message has-text-centered py-5">
							<?= lang('cyno.login_message_one') ?>
							<a href="<?= base_url(route_to('user_login')) ?>"><?= lang('cyno.login_message_two') ?></a>
						</div>


					<?= form_close() ?>
				</div>
				<div class="is-pulled-left column">
					<div id="cyno_auth_image" class="is-pulled-left"></div>
				</div>
			</div>
		</div>
	<div id="blob"></div>

<?= $this->endSection() ?>
