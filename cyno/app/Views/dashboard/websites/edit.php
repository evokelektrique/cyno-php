<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('wrapper') ?>
<?= $this->include('dashboard/partials/header') ?>
<div class="columns is-centered px-3">
    <div class="column is-10">
        <?= form_open(base_url(route_to('dashboard_website_update', $website->hash_id))) ?>
        <?= form_hidden('_method', 'PUT') ?>
        <div class="field">
            <label class="label" for="title"><?= lang('cyno.title') ?></label>
            <div class="control">
                <?= form_input([
                    'name'     => 'title',
                    'value' => $website->title,
                    'id'     => 'title',
                    'class' => 'input',
                ]); ?>
            </div>
        </div>
        <?= form_submit('submit', lang('cyno.submit'), ['class' => 'button is-primary']) ?>
        <?= form_close() ?>

        <?= form_open(base_url(route_to('dashboard_website_delete', $website->hash_id))) ?>
        <?= form_hidden('_method', 'DELETE') ?>
        <button class="button is-danger my-3 is-light">
            <?= lang('cyno.delete') ?>
        </button>
        <?= form_close() ?>


    </div>
</div>

<?= $this->endSection() ?>