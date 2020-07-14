<?= $this->extend('layouts/landing') ?>
<?= $this->section('wrapper') ?>
<div class="container">
	<!-- Header -->
	<?= $this->include('landing/partials/header') ?>
	
    <div id="email" class="mt-3">
        <div class="content">
            <div class="notification <?= ($status) ? 'is-primary':'is-danger' ?> ">
                <button class="delete"></button>							
                <?php if($status):?>
                    <?= lang('cyno.email_resent_successfully') ?>
                <?php else: ?>
                    <?= lang('cyno.email_sent_failed') ?>
                <?php endif; ?>
            </div>
        </div>
	</div>	

</div>



<?= $this->endSection('wrapper') ?>