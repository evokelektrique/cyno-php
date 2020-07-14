<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('wrapper') ?>
	<?= $this->include('dashboard/partials/header') ?>
	<div class="columns is-centered px-3">
		<div class="column is-10">

            <h1 class="title is-size-2 has-text-centered has-text-weight-bold pb-2">
                <?php if(!empty($password->title)): ?>
                    <?= $password->title ?>
                <?php else: ?>
                    <?= lang('cyno.no_title') ?>
                <?php endif; ?>
            </h1>

            <div class="box has-text-centered has-background-warning my-3">
                <h2 class="has-text-weight-bold pb-3"><?= lang('cyno.cannot_edit') ?></h2>
                <p class="has-text-weight-light">
                    <?= lang('cyno.cannot_edit_message') ?>
                    <a href="#" class="button is-white is-small align-baseline mr-2">
                        <?= lang('cyno.show') ?> <?= lang('cyno.more_info') ?>
                    </a>
                </p>
            </div>
        
            <hr>
            <h2 class="has-text-weight-bold"><?= lang('cyno.delete') ?> <?= lang('cyno.password') ?></h2>
			<?= form_open(base_url(route_to('dashboard_password_delete', $password->hash_id))) ?>
				<?= form_hidden('_method', 'DELETE') ?>
				<button class="button is-danger my-3 is-light">
					<?= lang('cyno.delete') ?>
				</button>
			<?= form_close() ?>


		</div>
	</div>

<?= $this->endSection() ?>