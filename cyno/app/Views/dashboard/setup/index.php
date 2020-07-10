<?= $this->extend('layouts/dashboard') ?>
<?= $this->section('wrapper') ?>
<?= $this->include('dashboard/partials/header') ?>
<div class="columns is-centered px-3">
	<div class="column is-10">
		<h1 class="has-text-centered has-text-weight-bold is-size-3"><?= lang('cyno.setup') ?></h1>
		<h5 class="has-text-right py-5 mb-5 has-text-weight-light is-size-6"><?= lang('cyno.setup_description') ?></h5>
		<?= form_open(base_url(route_to('dashboard_validation')), ['id' => 'setup_form']) ?>
		<div class="columns is-centered">
			<div class="column">
				<div class="field">
					<label class="label"><?= lang('cyno.masterkey') ?>:</label>
					<div class="control is-expanded">
						<?= form_password('masterkey', '', ['class' => 'input']) ?>
					</div>
					<p class="help">رمز اول</p>
				</div>
			</div>
			<div class="column">
				<div class="field">
					<label class="label"><?= lang('cyno.masterkey_ad') ?>:</label>
					<div class="control is-expanded">
						<?= form_password('masterkey_ad', '', ['class' => 'input']) ?>
					</div>
					<p class="help">رمز دوم</p>
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
					<p class="help">درجه سختی رمزنگاری</p>
				</div>
			</div>
			<div class="column is-2">
				<div class="field">
					<label class="label">&nbsp;</label>
					<div class="control">
						<button class="button is-primary is-fullwidth" id="submit_setup_button">
							<?= lang('cyno.submit') ?>
						</button>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?= $this->endSection() ?>