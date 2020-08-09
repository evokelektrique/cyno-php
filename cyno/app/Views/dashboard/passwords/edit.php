<?= $this->extend('layouts/dashboard') ?>

<?php 
// Initiate Carbon class
use Carbon\Carbon;
?>

<?= $this->section('wrapper') ?>
<?= $this->include('dashboard/partials/header') ?>
<div class="columns is-centered px-3">
    <div class="column is-10">


        <h1 class="is-size-2 has-text-centered has-text-weight-bold py-4 mb-6 ">
            <?php if (!empty($password->title)) : ?>
                <?= $password->title ?>
            <?php else : ?>
                <?= lang('cyno.no_title') ?>
            <?php endif; ?>
        </h1>
        <div class="columns is-centered">
            <div class="column is-8">
                <h3 class="title is-size-5 has-text-weight-bold has-text-right">
                    <?= lang('cyno.change_information') ?>
                </h3>
                <?= form_open(base_url(route_to('dashboard_password_update_information', $password->hash_id))) ?>
                <?= form_hidden('_method', 'PUT') ?>
                <div class="field">
                    <label class="label" for="title"><?= lang('cyno.title') ?></label>
                    <div class="control">
                        <?= form_input([
                            'name'     => 'title',
                            'value' => $password->title,
                            'id'     => 'title',
                            'class' => 'input',
                        ]); ?>
                    </div>
                </div>
                <div class="field">
                    <label class="label"><?= lang('cyno.folder') ?></label>
                    <div class="control is-expanded">
                        <div class="select is-fullwidth">
                        <?php if(isset($folder->hash_id)): ?>
                            <?= form_dropdown('folder', $multiselect_folders, [$folder->hash_id], ['id' => 'folder']); ?>
                        <?php else: ?>
                            <?= form_dropdown('folder', $multiselect_folders, ['0'], ['id' => 'folder']); ?>
                        <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?= form_submit('submit', lang('cyno.submit').' '.lang('cyno.change_information'), ['class' => 'button is-primary']) ?>
                <?= form_close() ?>
                <hr>





























                <h3 class="title is-size-5 has-text-weight-bold has-text-right">
                    <?= lang('cyno.change_pass') ?>
                </h3>
                <?= form_open(base_url(route_to('dashboard_password_update', $password->hash_id)), ['id' => 'update_encryption_form']) ?>
                <?= form_hidden('_method', 'PUT') ?>
                <?= form_hidden('password_id', $password->hash_id) ?>
                

                <div class="columns is-centered mt-0">
                    <div class="column">
                        <div class="field">
                            <label class="label"><?= lang('cyno.masterkey') ?></label>
                            <div class="control">
                                <?= form_password('masterkey', '', ['id' => 'master_key', 'class' => 'input']) ?>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="field">
                            <label class="label"><?= lang('cyno.masterkey_ad') ?></label>
                            <div class="control">
                                <?= form_password('masterkey_ad', '', ['id' => 'master_key_ad', 'class' => 'input']) ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="field">
                    <label class="label"><?= lang('cyno.password') ?></label>
                    <div class="control">
                        <?= form_password('cipher_text', '', ['id' => 'password', 'class' => 'input']) ?>
                    </div>
                </div>
                <div class="columns is-centered">
                    <div class="column">
                        <div class="field">
                            <label class="label"><?= lang('cyno.difficulty') ?></label>
                            <div class="control is-expanded">
                                <div class="select is-fullwidth">
                                    <?= form_dropdown('difficulty', $difficulty_options, '1'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="field is-block">
                    <button class="button is-primary" id="submit_update_encryption_form">
                        <?= lang('cyno.submit') ?> <?= lang('cyno.change_pass') ?>
                    </button>
                </div>
                <?= form_close() ?>
























                <hr>
                <h2 class="has-text-weight-bold"><?= lang('cyno.delete') ?> <?= lang('cyno.password') ?></h2>
                <?php 
                    $confirm_delete = lang('cyno.confirm_delete');
                ?>
                <?= form_open(base_url(route_to('dashboard_password_delete', $password->hash_id)), ['onsubmit' => "return show_alert('$confirm_delete')"]) ?>
                <?= form_hidden('_method', 'DELETE') ?>
                <button class="button is-danger my-3 is-light">
                    <?= lang('cyno.delete') ?>
                </button>
                <?= form_close() ?>

            </div>
            <div class="column is-4">

                <?php if(!empty($website)): ?>
                <?php $uri = new \CodeIgniter\HTTP\URI($website->url) ?>
                <div class="box has-text-centered has-background-warning mb-5">
                    <h2 class="has-text-weight-bold title is-size-6 pb-3"><?= lang('cyno.edit_warning') ?> <?= lang('cyno.password') ?></h2>
                    <p class="has-text-weight-light has-text-justified">
                        <?= lang('cyno.edit_warning_message') ?>
                        <a href="#" class="button is-white is-small align-baseline mr-2">
                            <?= lang('cyno.show') ?> <?= lang('cyno.more_info') ?>
                        </a>                

                    </p>
                </div>

                <!-- Website -->
                <div class="box has-text-centered has-background-light mb-5">
                    <h2 class="has-text-weight-bold title is-size-6 pb-3"><?= lang('cyno.website') ?></h2>
                    <!-- Title -->
                    <div class="columns is-mobile">
                        <div class="column align-self-center has-text-right has-text-weight-bold">
                            <span class="icon align-middle has-text-dark">
                                <i class="fas fa-globe"></i>
                            </span>
                            <?= lang('cyno.address') ?>
                        </div>
                        <div class="column has-text-left">
                            <a href="<?= $website->url ?>" class="button is-light" dir="ltr" title="<?= $website->title ?>">
                                <span>
                                    <img src="<?= $website->fav_icon_url ?>" width="36px" class="pr-2 mt-2">
                                </span>
                                <span class="is-clipped text-ellipsis is-block">
                                    <?= $uri->getHost(); ?> 
                                </span>
                            </a>
                        </div>
                    </div>
                    <!-- Passwords -->
                    <div class="columns is-mobile">
                        <div class="column align-self-center has-text-right has-text-weight-bold">
                            <span class="icon align-middle has-text-dark">
                                <i class="fas fa-key"></i>
                            </span>
                            <?= lang('cyno.passwords') ?>
                        </div>
                        <div class="column has-text-left is-clipped text-ellipsis">
                            <a href="<?= base_url(route_to('dashboard_website_passwords', $website->hash_id)) ?>" class="button is-light has-text-weight-bold is-block">
                                <span>
                                    <?= $password_model->where('user_id', $session->user['id'])->where('website_id', $website->id)->countAllResults() ?>
                                    <?= lang('cyno.number') ?>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <!-- Password -->
                <div class="box has-text-centered has-background-white is-shadowless mb-5">
                    <h2 class="has-text-weight-bold title is-size-6 pb-3"><?= lang('cyno.password_details') ?></h2>
                    <!-- Created Date -->
                    <div class="columns is-mobile">
                        <div class="column align-self-center has-text-right has-text-weight-bold">
                            <?= lang('cyno.created_at') ?>
                        </div>
                        <div class="column has-text-right-widescreen-only is-clipped pr-0 text-ellipsis is-size-7" dir="rtl" title="<?= $password->created_at ?>">
                            <span class="px-1 py-1 has-background-light is-block text-ellipsis is-clipped">
                                <?= Carbon::parse($password->created_at)->locale('fa_IR')->diffForHumans() ?>
                            </span>
                        </div>
                    </div>
                    <!-- Updated Date -->
                    <div class="columns is-mobile">
                        <div class="column align-self-center has-text-right has-text-weight-bold">
                            <?= lang('cyno.updated_at') ?>
                        </div>
                        <div class="column has-text-right-widescreen-only is-clipped pr-0 text-ellipsis is-size-7" dir="rtl" title="<?= $password->updated_at ?>">
                            <span class="px-1 py-1 has-background-light is-block text-ellipsis is-clipped">
                                <?= Carbon::parse($password->updated_at)->locale('fa_IR')->diffForHumans() ?>
                            </span>
                        </div>
                    </div>
                    <?php if(!empty($password->hash)): ?>
                    <!-- Hash -->
                    <div class="columns is-mobile">
                        <div class="column align-self-center has-text-right has-text-weight-bold">
                            <?= lang('cyno.hash') ?>
                        </div>
                        <div class="column has-text-left is-clipped pr-0 text-ellipsis" dir="ltr">
                                <code class="is-uppercase has-text-grey is-block text-ellipsis is-clipped">
                                    <?= word_limiter($password->hash,3) ?> 
                                </code>
                            </a>
                        </div>
                    </div>
                    <?php endif; ?>
                    <!-- Salt -->
                    <div class="columns is-mobile">
                        <div class="column align-self-center has-text-right has-text-weight-bold">
                            <?= lang('cyno.salt') ?>
                        </div>
                        <div class="column has-text-left is-clipped pr-0 text-ellipsis" dir="ltr">
                                <code class="is-uppercase has-text-grey is-block text-ellipsis is-clipped">
                                    <?= word_limiter($password->salt,3) ?> 
                                </code>
                            </a>
                        </div>
                    </div>
                    <!-- Nonce -->
                    <div class="columns is-mobile">
                        <div class="column align-self-center has-text-right has-text-weight-bold">
                            <?= lang('cyno.nonce') ?>
                        </div>
                        <div class="column has-text-left is-clipped pr-0 text-ellipsis" dir="ltr">
                                <code class="is-uppercase has-text-grey is-block text-ellipsis is-clipped">
                                    <?= word_limiter($password->nonce,3) ?> 
                                </code>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>



    </div>
</div>

<?= $this->endSection() ?>