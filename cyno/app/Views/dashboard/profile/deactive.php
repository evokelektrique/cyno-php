<?= $this->extend('layouts/dashboard') ?>
<?= $this->section('wrapper') ?>
<?= $this->include('dashboard/partials/header') ?>
<div class="columns is-centered px-3">
    <div class="column is-10">
        <h1 class="title is-size-2 has-text-centered has-text-weight-bold pb-2"><?= lang('cyno.profile_deactive') ?></h1>

        <!-- Tabs -->
        <?= $this->include('dashboard/partials/profile/tabs') ?>

        <!-- Change-Password Form -->
        <?php 
            $alert_message = lang('cyno.deactive_description');
        ?>
        <?= form_open(base_url(route_to('App\Controllers\Profile::validate_deactive')), ['onsubmit' => "return show_alert('$alert_message')"]) ?>
        <?= form_submit('submit', lang('cyno.deactive'), ['class' => 'button is-danger']) ?>
        <p class="help has-text-danger pt-2">
            <?= lang('cyno.deactive_description') ?>
        </p>


    </div>
</div>
<?= $this->endSection() ?>