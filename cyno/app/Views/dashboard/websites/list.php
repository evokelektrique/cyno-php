<?php foreach ($websites as &$website) : ?>
    <tr>
        <td span="1"><a href="<?= base_url(route_to('dashboard_website_passwords', $website->hash_id)) ?>"><?= $website->title ?></a></td>
        <td>
            <?php
            $website_url = new \CodeIgniter\HTTP\URI($website->url);
            echo $website_url->getHost();
            ?>
        </td>
        <td><?=
                $password_model
                    ->where('user_id', $session->user['id'])
                    ->where('website_id', $website->id)
                    ->countAllResults()
            ?></td>
        <td title="<?= $website->created_at ?>"><?= $time::parse($website->created_at)->humanize() ?></td>
        <td class="has-text-left">
            <a class="button is-small is-primary" href="<?= base_url(route_to('dashboard_website_passwords', $website->hash_id)) ?>"><?= lang('cyno.show') ?> <?= lang('cyno.passwords') ?></a>
            <a class="button is-small is-warning" href="<?= base_url(route_to('dashboard_website_edit', $website->hash_id)) ?>"><?= lang('cyno.edit') ?></a>
        </td>
    </tr>
<?php endforeach; ?>