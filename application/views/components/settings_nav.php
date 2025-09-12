<h3 class="text-black-50 py-3 mb-3 border-bottom">
    <?= lang('settings_menu') ?>
</h3>

<ul id="settings-nav" class="nav flex-column">
    <li class="nav-item mb-3">
        <a id="general_settings" href="<?= site_url('general_settings') ?>" class="nav-link px-3 py-2" title="<?= lang('general_settings') ?>" aria-label="<?= lang('general_settings') ?>" target="_self">
            <?= lang('general_settings') ?>
        </a>
    </li>

    <li class="nav-item mb-3">
        <a id="booking_settings" href="<?= site_url('booking_settings') ?>" class="nav-link px-3 py-2" title="<?= lang('booking_settings') ?>" aria-label="<?= lang('booking_settings') ?>" target="_self">
            <?= lang('booking_settings') ?>
        </a>
    </li>

    <li class="nav-item mb-3">
        <a id="business_settings" href="<?= site_url('business_settings') ?>" class="nav-link px-3 py-2" title="<?= lang('business_logic') ?>" aria-label="<?= lang('business_logic') ?>" target="_self">
            <?= lang('business_logic') ?>
        </a>
    </li>

    <li class="nav-item mb-3">
        <a id="legal_settings" href="<?= site_url('legal_settings') ?>" class="nav-link px-3 py-2" title="<?= lang('legal_contents') ?>" aria-label="<?= lang('legal_contents') ?>" target="_self">
            <?= lang('legal_contents') ?>
        </a>
    </li>

    <li class="nav-item mb-3">
        <a id="integrations" href="<?= site_url('integrations') ?>" class="nav-link px-3 py-2" title="<?= lang('integrations') ?>" aria-label="<?= lang('integrations') ?>" target="_self">
            <?= lang('integrations') ?>
        </a>
    </li>
</ul>
