<div class="tabs">
    <ul>
        <?php
        // $uri = service('uri');
        $url = current_url(true);
        $method = $url->getSegments()[array_key_last($url->getSegments())];
        ?>
        <li class="<?= ($method === 'settings') ? 'is-active' : '' ?>">
            <a href="<?= base_url(route_to('dashboard_profile_settings')) ?>">
                <span class="icon is-small"><i class="fas fa-key" aria-hidden="true"></i></span>
                <span><?= lang('cyno.change_password') ?></span>
            </a>
        </li>
        <li class="<?= ($method === 'deactive') ? 'is-active' : '' ?>">
            <a href="<?= base_url(route_to('dashboard_profile_deactive')) ?>">
                <span class="icon is-small"><i class="fas fa-power-off" aria-hidden="true"></i></span>
                <span><?= lang('cyno.deactive') ?></span>
            </a>
        </li>
    </ul>
</div>